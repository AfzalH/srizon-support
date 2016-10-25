<?php

namespace App\Http\Controllers;

use App\Product;
use App\Ticket;
use App\Ticketcategory;
use App\Ticketstatus;
use Cache;
use App\Http\Requests;
use JsValidator;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ticket_categories = Cache::remember('ticket_categories', 50000, function () {
            return Ticketcategory::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        });
        $products = Cache::remember('product_list', 50000, function () {
            return Product::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        });
        $downloadable_products = Cache::remember('dl_product_list', 50000, function () {
            return Product::orderBy('sort_order', 'asc')->whereHas('downloadlinks', function ($q) {
                $q->where('id', '!=', 0);
            })->get()->pluck('name', 'id');
        });
        $rules = TicketController::$store_rules;
        $ticketstatuses = Cache::remember('ticket_status_list', 50000, function () {
            return Ticketstatus::orderBy('sort_order', 'asc')->get()->pluck('name', 'id');
        });
        unset($rules['g-recaptcha-response']);
        $validator_script = JsValidator::make($rules, TicketController::$store_rules_messages);
        $validator_script2 = JsValidator::make(TicketController::$download_form_rules);
        $tickets = Cache::remember('recent_tickets', 50000, function () {
            return Ticket::with('user', 'ticketstatus', 'product')->orderBy('updated_at', 'desc')->take(7)->get();
        });
        return view('welcome', compact('ticket_categories', 'validator_script', 'validator_script2', 'tickets', 'products', 'downloadable_products', 'ticketstatuses'));
    }
}
