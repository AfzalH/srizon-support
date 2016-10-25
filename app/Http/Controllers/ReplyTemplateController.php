<?php

namespace App\Http\Controllers;

use App\Product;
use App\Replytemplate;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReplyTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reply = Replytemplate::all();
        return view('reply-template.index', compact('reply'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:replytemplates',
            'body' => 'required'
        ]);

        $reply = new Replytemplate();
        $reply->title = $request->input('title');

        $reply->body = $request->input('body');
        $reply->save();
        \Flash::success('Reply template created');
        return \Redirect::route('super.reply-template.show', $reply->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Replytemplate $reply */
        $reply = Replytemplate::find($id);
        $thisproducts = $reply->products;
        $products = Product::all()->diff($thisproducts);
        return view('reply-template.show', compact('reply', 'thisproducts', 'products'));
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
        $reply = Replytemplate::find($id);
        $this->validate($request, [
            'title' => 'required|unique:replytemplates,title,' . $id
        ]);
        $reply->title = $request->input('title');

        $reply->body = $request->input('body');
        $reply->save();
        \Flash::success('Reply Text Updated');
        return \Redirect::back();
    }

    public function assign_product($id, $product_id)
    {
        Replytemplate::find($id)->assignProduct($product_id);
        \Flash::success('Product assigned to this template');
        return \Redirect::back();
    }

    public function revoke_product($id, $product_id)
    {
        Replytemplate::find($id)->revokeProduct($product_id);
        \Flash::success('Product removed from this template');
        return \Redirect::back();
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
        if ($id == 1) {
            \Flash::error("Template 'Default' cannot be deleted!");
        } else {
            Replytemplate::destroy($id);
            \Flash::success('Deleted!');
        }
        return \Redirect::route('super.reply-template.index');
    }
}
