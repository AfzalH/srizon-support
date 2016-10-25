<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Carbon\Carbon;
use Faker\Factory;
use Flash;
use Illuminate\Http\Request;

use App\Http\Requests;
use Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('product')->orderBy('id', 'desc')->paginate(15);
        $products = Product::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        $pagination = true;
        $countries = get_country_array();
        return view('order.index', compact('orders', 'products', 'pagination', 'countries'));
    }

    public function search(Request $request)
    {
        $orders = Order::where('id', '=', $request->term)
            ->orWhere('p_id', '=', $request->term)
            ->orWhere('email', 'like', '%' . $request->term . '%')
            ->orWhere('first_name', 'like', '%' . $request->term . '%')
            ->orWhere('last_name', 'like', '%' . $request->term . '%')->with('product')->orderBy('id', 'desc')->take(30)->get();
        $pagination = false;
        return view('order.parts.order-box', compact('orders', 'pagination'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


//        return $request->all();
        $this->validate($request, [
            'p_id' => 'required|unique:orders',
            'product_id' => 'required',
            'email' => 'required|email',
            'first_name' => 'required',
        ], [
            'p_id.required' => 'Purchase/Order ID is required',
            'p_id.unique' => 'Purchase/Order ID is already in the database',
            'product_id.required' => 'You should select a product'
        ]);


        $order = new Order();
        $order->p_id = $request->p_id;
        $order->product_id = $request->product_id;
        $prod_order = Order::where('product_id', '=', $request->product_id)->first();
        if (isset($prod_order)) {
            $order->product_name = $prod_order->product_name;
        } else {
            $order->product_name = '';
        }
        $order->email = $request->email;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->country = $request->country;
        $order->status = $request->status;
        $order->payment_method = $request->payment_method;

        $date1 = new Carbon($request->p_date);
        $order->p_date = $date1->format('m/d/Y h:i:s A');

        $order->save();
        Flash::success('Order Created');
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Order $order */
        $order = Order::find($id);
        $products = Product::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        $countries = get_country_array();
        return view('order.show', compact('order', 'products', 'countries'));
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
        /** @var Order $order */
        $order = Order::find($id);
        $this->validate($request, [
            'p_id' => 'required|unique:orders,p_id,' . $order->id,
            'product_id' => 'required',
            'email' => 'required|email',
            'first_name' => 'required',
        ], [
            'p_id.required' => 'Purchase/Order ID is required',
            'p_id.unique' => 'Purchase/Order ID is already in the database',
            'product_id.required' => 'You should select a product'
        ]);

        $order->p_id = $request->p_id;
        $order->product_id = $request->product_id;
        $prod_order = Order::where('product_id', '=', $request->product_id)->first();
        if (isset($prod_order)) {
            $order->product_name = $prod_order->product_name;
        } else {
            $order->product_name = '';
        }
        $order->email = $request->email;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->country = $request->country;
        $order->status = $request->status;
        $order->payment_method = $request->payment_method;

        $date1 = new Carbon($request->p_date);
        $order->p_date = $date1->format('m/d/Y h:i:s A');

        $order->save();
        Flash::success('Order Updated');
        return Redirect::back();
    }

    public function ipntest()
    {
        if (env('TEST_MODE', false) == true && Order::count()>0) {
            $status_a = collect(['Processed', 'Processed', 'Processed', 'Processed', 'Processed', 'Canceled', 'Refunded', 'Chargeback']);
            $payment_method = collect(['PayPal', 'Visa', 'MasterCard']);
            $faker = Factory::create();
            $secret = env('PAYPRO_IPN_SECRET');
            $order['id'] = $faker->randomNumber(4);
            $order['hash'] = md5($order['id'] . $secret);
            $order['status'] = $status_a->random();
            $order['first_name'] = $faker->firstName;
            $order['last_name'] = $faker->lastName;
            $order['email'] = $faker->email;
            $order['datetime'] = date('m/d/Y h:i:s A');
            $product = Product::orderBy('sort_order', 'asc')->get()->pluck('paypro_name')->reject(function ($name) {return empty($name);});
            $order['product_name'] = $product->random();
            $countries = collect(get_country_array());
            $country = $countries->random();
            $country_name = substr($country, 0, strpos($country, '(') - 1);
            $country_code = substr($country, strpos($country, '(') + 1, 2);
            $order['country'] = $country_name;
            $order['country_code'] = $country_code;
            $order['payment_method'] = $payment_method->random();

            return view('order.ipntest', compact('order'));
        }
        else {
            Flash::error('Order Table is empty. Import some order data first');
            return Redirect::route('dashboard');
        }
    }

    public function ipnhandler(Request $request)
    {
        if ($request->HASH != md5($request->ORDER_ID . env('PAYPRO_IPN_SECRET'))) exit();
        if ($request->ORDER_STATUS == 'Processed' and Order::wherePId($request->ORDER_ID)->count() == 0) {
            $order = new Order();
            $order->p_id = $request->ORDER_ID;
            $order->product_name = $request->ORDER_ITEM_NAME;
            $order->product_id = Product::wherePayproName($request->ORDER_ITEM_NAME)->first()->id;
            $order->email = $request->CUSTOMER_EMAIL;
            $order->first_name = $request->CUSTOMER_FIRST_NAME;
            $order->last_name = $request->CUSTOMER_LAST_NAME;
            $order->country = $request->CUSTOMER_COUNTRY_NAME . ' (' . $request->CUSTOMER_COUNTRY_CODE . ')';
            $order->payment_method = $request->PAYMENT_METHOD_NAME;
            $order->p_date = $request->ORDER_PLACED_TIME_UTC;
            $order->status = $request->ORDER_STATUS;
            $order->save();
        }
        if (
            ($request->ORDER_STATUS == 'Canceled'
                or $request->ORDER_STATUS == 'Refunded'
                or $request->ORDER_STATUS == 'Chargeback')
            and Order::wherePId($request->ORDER_ID)->count()
        ) {
            $order = Order::wherePId($request->ORDER_ID)->first();
            $order->status = $request->ORDER_STATUS;
            $order->save();
        }
        return 'Ok';
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
            Flash::error('Delete operation is disabled from environment file');
            return Redirect::back();
        }
        Order::destroy($id);
        return Redirect::route('super.order.index');
    }
}
