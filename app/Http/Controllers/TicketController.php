<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Productlink;
use App\Role;
use App\Ticket;
use App\Ticketpost;
use App\Ticketstatus;
use App\User;
use Cache;
use Gate;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Mail\Message;
use Flash;
use Mail;
use Response;
use Redirect;
use Swift_Mailer;
use Swift_SmtpTransport;

class TicketController extends Controller
{

    public $allowed_tags = '<a> <b> <br> <blockquote> <code> <div> <del> <dd> <dl> <dt> <em> <i> <img> <kbd> <ul> <li> <ol> <p> <pre> <s> <sup> <sub> <strong> <strike> <h1> <h2> <h3> <h4> <h5> <h6> <span> <hr>';
    public $email_domains = [
        /* Default domains included */
        "aol.com", "att.net", "comcast.net", "facebook.com", "gmail.com", "gmx.com", "googlemail.com",
        "google.com", "hotmail.com", "hotmail.co.uk", "mac.com", "me.com", "mail.com", "msn.com",
        "live.com", "sbcglobal.net", "verizon.net", "yahoo.com", "yahoo.co.uk",

        /* Other global domains */
        "email.com", "games.com" /* AOL */, "gmx.net", "hush.com", "hushmail.com", "icloud.com", "inbox.com",
        "lavabit.com", "love.com" /* AOL */, "outlook.com", "pobox.com", "rocketmail.com" /* Yahoo */,
        "safe-mail.net", "wow.com" /* AOL */, "ygm.com" /* AOL */, "ymail.com" /* Yahoo */, "zoho.com", "fastmail.fm",
        "yandex.com",

        /* United States ISP domains */
        "bellsouth.net", "charter.net", "comcast.net", "cox.net", "earthlink.net", "juno.com",

        /* British ISP domains */
        "btinternet.com", "virginmedia.com", "blueyonder.co.uk", "freeserve.co.uk", "live.co.uk",
        "ntlworld.com", "o2.co.uk", "orange.net", "sky.com", "talktalk.co.uk", "tiscali.co.uk",
        "virgin.net", "wanadoo.co.uk", "bt.com",

        /* Domains used in Asia */
        "sina.com", "qq.com", "naver.com", "hanmail.net", "daum.net", "nate.com", "yahoo.co.jp", "yahoo.co.kr", "yahoo.co.id", "yahoo.co.in", "yahoo.com.sg", "yahoo.com.ph",

        /* French ISP domains */
        "hotmail.fr", "live.fr", "laposte.net", "yahoo.fr", "wanadoo.fr", "orange.fr", "gmx.fr", "sfr.fr", "neuf.fr", "free.fr",

        /* German ISP domains */
        "gmx.de", "hotmail.de", "live.de", "online.de", "t-online.de" /* T-Mobile */, "web.de", "yahoo.de",

        /* Russian ISP domains */
        "mail.ru", "rambler.ru", "yandex.ru", "ya.ru", "list.ru",

        /* Belgian ISP domains */
        "hotmail.be", "live.be", "skynet.be", "voo.be", "tvcablenet.be", "telenet.be",

        /* Argentinian ISP domains */
        "hotmail.com.ar", "live.com.ar", "yahoo.com.ar", "fibertel.com.ar", "speedy.com.ar", "arnet.com.ar",

        /* Domains used in Mexico */
        "hotmail.com", "gmail.com", "yahoo.com.mx", "live.com.mx", "yahoo.com", "hotmail.es", "live.com", "hotmail.com.mx", "prodigy.net.mx", "msn.com"
    ];

    public static $store_rules = [
        'username' => 'required',
        'email' => 'required|email',
        'title' => 'required',
        'ticket_category' => 'required',
        'product' => 'required',
        'initial_post' => 'required',
        'g-recaptcha-response' => 'recaptcha'

    ];

    public static $download_form_rules = [
        'product' => 'required',
        'email' => 'required|email'
    ];

    public static $update_rules = [
        'username' => 'required',
        'email' => 'required|email',
        'title' => 'required',
        'ticketcategory_id' => 'required',
        'product_id' => 'required',
        'ticketstatus_id' => 'required',
        'secret' => 'required',
        'email_code' => 'required',
        'email_verified' => 'required',
    ];

    public static $store_rules_messages = [
        'username.required' => 'Name is required',
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'title.required' => 'Title is required',
        'initial_post.required' => 'Please add some text describing your query/request/issue',
    ];

    public function  __construct()
    {
        if (Gate::denies('support')) {
            $this->middleware('throttle:5,60', ['only' => ['store', 'downloadFile', 'storeDownload']]); // 5 ticket per hour
            $this->middleware('throttle:120,60', ['only' => ['publicSearch', 'recent']]); // 120 search per hour
            $this->middleware('throttle:25,60', ['only' => ['addPost',
                'emailVerification', 'email_secret', 'emailVerify', 'verify_secret', 'switchSecrecy', 'ticketpost_update']]); // 25 posts per hour
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::with('user', 'ticketstatus', 'product', 'ticketcategory')->orderBy('updated_at', 'desc')->paginate(15);
        $pagination = true;
        return view('ticket-admin.index', compact('tickets', 'pagination'));
    }

    public function search(Request $request)
    {
        $tickets = Ticket::with('user', 'ticketstatus', 'product', 'ticketcategory')
            ->where('id', '=', $request->term)
            ->orWhere('title', 'like', '%' . $request->term . '%')
            ->orwhereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->term . '%');
            })
            ->orwhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->term . '%');
            })->take(30)->get();
        $pagination = false;
        return view('ticket-admin.parts.ticket-box', compact('tickets', 'pagination'));
    }

    public function recent(Request $request)
    {
        $query = Ticket::with('user', 'ticketstatus', 'product');
        if (!empty($request->product)) {
            $query->where('product_id', $request->product);
        }
        if (!empty($request->status)) {
            $query->where('ticketstatus_id', $request->status);
        }
        $tickets = $query->orderBy('updated_at', 'desc')->take(7)->get();

        return view('parts.ticket-list', compact('tickets'));
    }

    function switchSecrecy($id)
    {
        /** @var Ticketpost $post */
        $post = Ticketpost::findOrFail($id);
        if (Gate::allows('support') or ($this->is_creator($post->ticket) and $post->ticket->ticketstatus_id != env('TICKET_STATUS_CLOSED'))) {
            if ($post->secrecy == 'secret') {
                $post->secrecy = 'public';
            } else {
                $post->secrecy = 'secret';
            }
            $post->save();
            return back();
        }
    }

    function addPost(Request $request)
    {
        $this->validate($request, [
            'postbody' => 'required'
        ], [
            'postbody.required' => 'You forgot to enter some text!'
        ]);
        if (isset($request->ticket_id)) {
            /** @var Ticket $ticket */
            $ticket = Ticket::find($request->ticket_id);
            if (\Auth::guest() and $this->is_creator($ticket) and $ticket->ticketstatus_id != 7) {
                $user_id = $ticket->user_id;
            } else if (Gate::allows('support') or Gate::allows('super')) {
                $user_id = \Auth::user()->id;
            } else {
                Flash::error('You are not authorized');
                return Redirect::back();
            }
            $post = new Ticketpost();
            $post->secrecy = $request->secrecy;
            $post->body = strip_tags($request->postbody, $this->allowed_tags);
            $post->user_id = $user_id;
            $ticket->ticketposts()->save($post);

            // when the owner posts if ticket status is not new or open make it open
            if ($this->is_creator($ticket) and in_array($ticket->ticketstatus_id, array(env('TICKET_STATUS_NEW_ID'), env('TICKET_STATUS_OPEN_ID'), env('TICKET_STATUS_NEW_MODERATED_ID'))) == false) {
                $ticket->ticketstatus_id = env('TICKET_STATUS_OPEN_ID');
            }
            $ticket->touch();
            Cache::forget('recent_tickets');
            if (Gate::allows('support') or Gate::allows('super')) {
                $this->sendEmailNotification($ticket);
            }
            return back();
        }
    }

    public function publicSearch(Request $request)
    {
        $tickets = Ticket::with('user', 'ticketstatus', 'product', 'ticketcategory')
            ->where('id', '=', $request->q)
            ->orWhere('title', 'like', '%' . $request->q . '%')
            ->orwhereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->q . '%');
            })
            ->orwhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%');
            })->orderBy('updated_at', 'desc')->paginate(15);
        $q = $request->q;
        $pagination = true;
        \View::share('pagetitle', 'Ticket Search Results: Page ' . $tickets->currentPage());
        return view('ticket.list', compact('tickets', 'pagination', 'q'));
    }

    public function ticketList(Request $request)
    {
        $tickets = Ticket::with('user', 'ticketstatus', 'product', 'ticketcategory')->orderBy('updated_at', 'desc')->paginate(15);
        $pagination = true;
        \View::share('pagetitle', 'Ticket List: Page ' . $tickets->currentPage());
        return view('ticket.list', compact('tickets', 'pagination'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function changeStatus(Request $request)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::findOrFail($request->ticketid);
        if (Ticketstatus::find($request->statusid) and $ticket->ticketstatus_id != $request->statusid) {
            $ticket->ticketstatus_id = $request->statusid;
            $ticket->touch();
            Cache::forget('recent_tickets');
        }
        return 'Ok';
    }

    public function storeDownload(Request $request)
    {
        $this->validate($request, self::$download_form_rules);
        if ($this->is_valid_customer_email($request->email, $request->product)) {
            /** @var Order $order */
            $order = Order::where('email', '=', $request->email)->where('product_id', '=', $request->product)->where('status', '=', 'Processed')->first();
            /** @var Product $product */
//            $product = Product::find($request->product);
            $user_id = $this->create_or_get_user_from_order($order);
            /** @var Ticket $ticket */
            $ticket = new Ticket;
            $ticket->title = 'Download request by ' . $order->first_name . ' ' . $order->last_name;
            $ticket->ticketcategory_id = env('DOWNLOAD_CAT_ID', 7);
            $ticket->product_id = $request->product;
            $ticket->user_id = $user_id;
            $ticket->secret = str_random();
            $ticket->email_code = str_random(5);
            $ticket->ticketstatus_id = env('TICKET_STATUS_NEW_ID');
            $ticket->touch();

            Cache::forget('recent_tickets');

            return Redirect::route('ticket.show', $ticket->slug)
                ->withCookie(cookie('ticketsecret' . $ticket->id, $ticket->secret, config('ticket_secret_validity', 10080)));
        } else {
            Flash::error('Couldn\'t find a record of a valid purchase of this product using this email');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (env('TEST_MODE', false) == true) {
            $faker = \Faker\Factory::create();
            if (empty($request->username)) $request->merge(['username' => $faker->name]);
            if (empty($request->email)) $request->merge(['email' => $faker->email]);
            if (empty($request->title)) $request->merge(['title' => $faker->realText(50)]);
            if (empty($request->ticket_category)) $request->merge(['ticket_category' => \App\Ticketcategory::all()->random()->id]);
            if (empty($request->product)) $request->merge(['product' => \App\Product::all()->random()->id]);
            if (empty($request->initial_post)) $request->merge(['initial_post' => $faker->realText()]);
        }

        if (env('TEST_MODE', false) != true) {
            $this->validate($request, self::$store_rules, self::$store_rules_messages);
        }
        $user_id = $this->create_or_get_user($request);
        $ticket = new Ticket;
        $ticket->title = $request->title;
        $ticket->ticketcategory_id = $request->ticket_category;
        $ticket->product_id = $request->product;
        $ticket->user_id = $user_id;
        $ticket->secret = str_random();
        $ticket->email_code = str_random(5);
        if ($this->customer_exists($request->email)) {
            $ticket->ticketstatus_id = env('TICKET_STATUS_NEW_ID');
        } else {
            $ticket->ticketstatus_id = env('TICKET_STATUS_NEW_MODERATED_ID');
        }
        $ticket->save();

        $post = new Ticketpost;
        $post->user_id = $user_id;
        $post->body = strip_tags($request->initial_post, $this->allowed_tags);

        $ticket->ticketposts()->save($post);

        Cache::forget('recent_tickets');

        return Redirect::route('ticket.show', $ticket->slug)
            ->withCookie(cookie('ticketsecret' . $ticket->id, $ticket->secret, config('ticket_secret_validity', 10080)))
            ->with('justcreated', 'yes');
    }

    public function verify_secret(Request $request)
    {
        $rules = ['secret' => 'required', 'ticket_id' => 'required'];
        $this->validate($request, $rules);
        $ticket = Ticket::find($request->ticket_id);
        if ($ticket->secret == $request->secret or $ticket->email_code == $request->secret) {
            if ($ticket->email_code == $request->secret) {
                $ticket->email_verified = 1;
                $ticket->save();
            }
            return Redirect::route('ticket.show', $ticket->slug)
                ->withCookie(cookie('ticketsecret' . $ticket->id, $ticket->secret, config('ticket_secret_validity', 10080)));
        } else {
            Flash::error('Wrong secret key for this ticket!');
            return Redirect::route('ticket.show', $ticket->slug);
        }
    }

    public function emailVerify(Request $request)
    {
        $rules = ['code' => 'required', 'ticket_id' => 'required'];
        $this->validate($request, $rules);
        $ticket = Ticket::find($request->ticket_id);
        if ($ticket->email_code == $request->code) {
            $ticket->email_verified = 1;
            $ticket->save();
            return Redirect::route('ticket.show', $ticket->slug);
        } else {
            Flash::error('Wrong code for this ticket!');
            return Redirect::route('ticket.show', $ticket->slug);
        }
    }

    public function downloadFile($id, $link_id)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::findOrFail($id);
        $link = Productlink::findOrFail($link_id);
        if ($this->is_creator($ticket)
            and $this->is_valid_customer($ticket)
            and ($ticket->email_verified == 1)
            and $ticket->product_id == $link->product_id
        ) {
            if ($ticket->ticketcategory_id == env('DOWNLOAD_CAT_ID', 7) and $ticket->ticketstatus_id != env('TICKET_STATUS_RESOLVED', 6)) {
                $ticket->ticketstatus_id = env('TICKET_STATUS_RESOLVED', 6);
                $ticket->touch();
                Cache::forget('recent_tickets');
            }
            return Response::download(resource_path('downloads/' . $link->filename));
        } else {
            Flash::error('Download not autorized');
            return Redirect::to('/');
        }

    }

    public function sendEmailNotification($ticket)
    {

        // If not under public domain then choose MailGun or Gmail as mail service for reliability
        if (!$this->is_public_email($ticket->user->email)) {
//            $flip = rand(0, 1);
            $flip = true; // use mailgun permanently
            if ($flip) {
                $this->switchToMailgun();
                Mail::send(['ticket.email.admin-replied', 'ticket.email.admin-replied-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                    $message->to($ticket->user->email, $ticket->user->name);
                    $message->from('support@srizon.com', 'Srizon Support');
                    $message->subject('New Activity on your ticket #' . $ticket->id);
                });
            } else {
                $this->switchToGmail();
                Mail::send(['ticket.email.admin-replied', 'ticket.email.admin-replied-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                    $message->to($ticket->user->email, $ticket->user->name);
                    $message->from(env('GMAIL_USERNAME'), 'Srizon Solutions');
                    $message->subject('New Activity on your ticket #' . $ticket->id);
                });
            }
        } else {
            Mail::send(['ticket.email.admin-replied', 'ticket.email.admin-replied-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('support@srizon.com', 'Srizon Support');
                $message->subject('New Activity on your ticket #' . $ticket->id);
            });
        }
    }

    public function emailVerification($id)
    {
        $ticket = Ticket::find($id);
        $emailattempt = \Request::cookie('emailattemptv' . $ticket->id);

        if (empty($emailattempt)) {
            if ($this->is_public_email($ticket->user->email)) {
                $emailattempt = 'sendmail';
            } else {
                $emailattempt = 'mailgun';
            }
        }

        if ($emailattempt == 'mailgun') {
            $this->switchToMailgun();
        } else if ($emailattempt == 'gmail') {
            $this->switchToGmail();
        }
        if ($emailattempt == 'sendmail') {
            Mail::send(['ticket.email.email-verification', 'ticket.email.email-verification-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('support@srizon.com', 'Srizon Support');
                $message->subject('Email verification code for ticket #' . $ticket->id);
            });
            Flash::success('Email verification code sent to your email address from our server');
            return Redirect::back()->withCookie('emailattemptv' . $ticket->id, 'mailgun', 30);
        } else if ($emailattempt == 'mailgun') {
            Mail::send(['ticket.email.email-verification', 'ticket.email.email-verification-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('support@srizon.com', 'Srizon Support');
                $message->subject('Email verification code for ticket #' . $ticket->id);
            });
            Flash::success('Email verification code sent to your email address from mailgun server');
            return Redirect::back()->withCookie('emailattemptv' . $ticket->id, 'gmail', 30);
        } else if ($emailattempt == 'gmail') {
            Mail::send(['ticket.email.email-verification', 'ticket.email.email-verification-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('srizon.solutions@gmail.com', 'Srizon Solutions');
                $message->subject('Email verification code for ticket #' . $ticket->id);
            });
            Flash::success('Email verification code sent to your email address from gmail server');
            return Redirect::back()->withCookie('emailattemptv' . $ticket->id, 'all', 30);
        } else {
            Flash::warning('You have already tried all emailing options. Please check your mailbox including spam. You can retry it after about 30 minutes or email <code>' . env('ADMIN_EMAIL') . '</code> directly');
            return Redirect::back();
        }
    }

    public function email_secret($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket->user->email != \Request::get('email')) {
            Flash::error('This is not the email associated with this ticket. Please enter the correct one or open a new ticket.');
            return Redirect::back()->withInput();
        }
        $emailattempt = \Request::cookie('emailattempt' . $ticket->id);
        if (empty($emailattempt)) {
            if ($this->is_public_email($ticket->user->email)) {
                $emailattempt = 'sendmail';
            } else {
                $emailattempt = 'mailgun';
            }
        }
        if ($emailattempt == 'mailgun') {
            $this->switchToMailgun();
        } else if ($emailattempt == 'gmail') {
            $this->switchToGmail();
        }
        if ($emailattempt == 'sendmail') {
            Mail::send(['ticket.email.secret', 'ticket.email.secret-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('support@srizon.com', 'Srizon Support');
                $message->subject('Secret key for ticket #' . $ticket->id);
            });
            Flash::success('Secret sent to your email address from our server');
            return Redirect::back()->withCookie('emailattempt' . $ticket->id, 'mailgun', 30)->withInput();
        } else if ($emailattempt == 'mailgun') {
            Mail::send(['ticket.email.secret', 'ticket.email.secret-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('support@srizon.com', 'Srizon Support');
                $message->subject('Secret key for ticket #' . $ticket->id);
            });
            Flash::success('Secret sent to your email address from mailgun server');
            return Redirect::back()->withCookie('emailattempt' . $ticket->id, 'gmail', 30)->withInput();
        } else if ($emailattempt == 'gmail') {
            Mail::send(['ticket.email.secret', 'ticket.email.secret-plain'], compact('ticket'), function (Message $message) use ($ticket) {
                $message->to($ticket->user->email, $ticket->user->name);
                $message->from('srizon.solutions@gmail.com', 'Srizon Solutions');
                $message->subject('Secret key for ticket #' . $ticket->id);
            });
            Flash::success('Secret sent to your email address from gmail server');
            return Redirect::back()->withCookie('emailattempt' . $ticket->id, 'all', 30)->withInput();
        } else {
            Flash::warning('You have already tried all emailing options. Please check your mailbox including spam. You can retry it after about 30 minutes or email <code>' . env('ADMIN_EMAIL') . '</code> directly');
            return Redirect::back()->withInput();
        }
    }


    public function create_or_get_user(Request $request)
    {
        if (User::whereEmail($request->email)->count() == 0) {
            $user = new User;
            $user->name = $request->username;
            $user->password = bcrypt(str_random());
            $user->email = $request->email;
            $user->save();
            if (Role::whereAlias('customer')->count()) {
                $user->assignRole('customer');
            }
            return $user->id;
        } else {
            return User::whereEmail($request->email)->first()->id;
        }
    }

    public function create_or_get_user_from_order(Order $order)
    {
        if (User::whereEmail($order->email)->count() == 0) {
            $user = new User;
            $user->name = $order->first_name . ' ' . $order->last_name;
            $user->password = bcrypt(str_random());
            $user->email = $order->email;
            $user->save();
            if (Role::whereAlias('customer')->count()) {
                $user->assignRole('customer');
            }
            return $user->id;
        } else {
            return User::whereEmail($order->email)->first()->id;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {
        $flags = [];
        $ticket_categories = Cache::remember('ticket_categories', 50000, function () {
            return Ticketcategory::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        });
        $products = Cache::remember('product_list', 50000, function () {
            return Product::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        });
        $ticketstatuses = Cache::remember('ticket_status_list', 50000, function () {
            return Ticketstatus::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        });
        $ticket = Ticket::with([
            'ticketposts' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'ticketposts.user',
            'ticketcategory',
            'product',
            'product.downloadlinks' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            },
            'ticketstatus',
            'user'])->where('slug', '=', $slug)->first();
        if (empty($ticket)) $ticket = Ticket::with([
            'ticketposts' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'ticketposts.user',
            'ticketcategory',
            'product',
            'product.downloadlinks' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            },
            'ticketstatus',
            'user'])->where('id', '=', $slug)->first();

        $flags['is_creator'] = $this->is_creator($ticket);
        $flags['is_public_email'] = $this->is_public_email($ticket->user->email);
        $flags['is_valid_customer'] = $this->is_valid_customer($ticket);
        $flags['ticket_email_verified'] = ($ticket->email_verified == 1);
        $ticketstatus = Ticketstatus::all();
        $allowed_tags = $this->allowed_tags;
        \View::share('pagetitle', $ticket->title);
        return view('ticket.show', compact('ticket', 'flags', 'ticketstatus', 'ticket_categories', 'products', 'ticketstatuses', 'allowed_tags'));
    }

    protected function is_valid_customer(Ticket &$ticket)
    {
        $order_count = Order::where('email', '=', $ticket->user->email)
            ->where('product_id', '=', $ticket->product_id)
            ->where('status', '=', 'Processed')->count();
        if ($order_count > 0) return true;
        return false;
    }

    protected function is_valid_customer_email($email, $product_id)
    {
        $order_count = Order::where('email', '=', $email)
            ->where('product_id', '=', $product_id)
            ->where('status', '=', 'Processed')->count();
        if ($order_count > 0) return true;
        return false;
    }

    protected function customer_exists($email)
    {
        $order_count = Order::where('email', '=', $email)
            ->where('status', '=', 'Processed')->count();
        if ($order_count > 0) return true;
        return false;
    }


    protected function switchToGmail()
    {
        if (env('TEST_MODE', false) == true) {
            return;
        }
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl');
        $transport->setUsername(env('GMAIL_USERNAME'));
        $transport->setPassword(env('GMAIL_PASSWORD'));
        $gmail = new Swift_Mailer($transport);
        Mail::setSwiftMailer($gmail);
    }

    protected function switchToMailgun()
    {
        if (env('TEST_MODE', false) == true) {
            return;
        }
        $transport = Swift_SmtpTransport::newInstance('smtp.mailgun.org', 465, 'ssl');
        $transport->setUsername(env('MAILGUN_USERNAME'));
        $transport->setPassword(env('MAILGUN_PASSWORD'));
        $gmail = new Swift_Mailer($transport);
        Mail::setSwiftMailer($gmail);
    }

    protected function is_public_email($email)
    {
        return false; // temporary... ip seems blacklisted in hotmail
        $domain = $this->getDomainFromEmail($email);
        if (array_search($domain, $this->email_domains) === false) return false;
        return true;
    }

    protected function is_creator(Ticket &$ticket)
    {
        $cookievalue = \Request::cookie('ticketsecret' . $ticket->id);
        if (empty($cookievalue)) return false;
        return $cookievalue == $ticket->secret;
    }

    public function ticketpost_edit($id)
    {
        /** @var Ticketpost $post */
        $post = Ticketpost::findOrFail($id);
        if (Gate::allows('support') or $this->is_creator($post->ticket)) {
            return view('ticket.edit-post', compact('post'));
        }
        Flash::error('Unauthorized!');
        return Redirect::route('ticket.show', $post->ticket->slug);
    }

    public function reply_from_template($id, $secrecy)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::findOrFail($id);
        $templates = $ticket->product->replytemplates;
        return view('ticket.reply-from-template', compact('ticket', 'templates', 'secrecy'));
    }

    public function ticketpost_as_template($id)
    {
        /** @var Ticketpost $post */
        $post = Ticketpost::findOrFail($id);
        if (Gate::allows('support') or $this->is_creator($post->ticket)) {
            return view('ticket.save-as-template', compact('post'));
        }
        Flash::error('Unauthorized!');
        return Redirect::route('ticket.show', $post->ticket->slug);
    }

    public function ticketpost_update(Request $request, $id)
    {
        /** @var Ticketpost $post */
        $post = Ticketpost::findOrFail($id);
        if (Gate::allows('support') or $this->is_creator($post->ticket)) {
            if ($post->body != $request->body) {
                $post->body = strip_tags($request->body, $this->allowed_tags);
                $post->touch();
            }
            return Redirect::route('ticket.show', $post->ticket->slug);
        }
        Flash::error('Unauthorized!');
        return Redirect::route('ticket.show', $post->ticket->slug);
    }

    public function post_history($id)
    {
        $post = Ticketpost::findOrFail($id);
        $history = $post->revisionHistory->reverse();
        return view('ticket.post-history', compact('history'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, self::$update_rules);
        /** @var Ticket $ticket */
        $ticket = Ticket::findOrFail($id);
        if (($request->username != $ticket->user->name) and ($request->email == $ticket->user->email)) {
            /** @var User $user */
            $user = User::findOrFail($ticket->user_id);
            $user->name = $request->username;
            $user->save();
        }
        if ($request->email != $ticket->user->email) {
            $ticket->user_id = $this->create_or_get_user($request);
            foreach ($ticket->ticketposts as $post) {
                $post->user_id = $ticket->user_id;
                $post->save();
            }
        }
        $ticket->title = $request->title;
        $ticket->ticketcategory_id = $request->ticketcategory_id;
        $ticket->product_id = $request->product_id;
        $ticket->ticketstatus_id = $request->ticketstatus_id;
        $ticket->secret = $request->secret;
        $ticket->email_code = $request->email_code;
        $ticket->email_verified = $request->email_verified;
        $ticket->touch();

        Cache::forget('recent_tickets');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (env('DELETE_DISABLED') == true) {
            \Flash::error('Delete operation is disabled from environment file');
            return \Redirect::back();
        }
    }

    protected function getDomainFromEmail($email)
    {
        // Get the data after the @ sign
        $domain = substr(strrchr($email, "@"), 1);
        return $domain;
    }
}
