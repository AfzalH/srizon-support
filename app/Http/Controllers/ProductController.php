<?php

namespace App\Http\Controllers;

use App\Product;
use App\Productcategory;
use App\Replytemplate;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('sort_order', 'asc')->get();
        return view('products.index', compact('products'));
    }

    public function sort(Request $request)
    {
        $jsonobj = json_decode($request->get('query'));

        foreach ($jsonobj as $obj) {
            if(isset($obj->id)){
                if($p = Product::find($obj->id)) {
                    $p->sort_order = $obj->sort_order;
                    $p->save();
                }
            }
        }
        return 'Saved';
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
            'name' => 'required|unique:products',
            'purchase_url' => 'unique:products',
            'paypro_name' => 'unique:products'
        ]);
        $product = new Product();
        $product->name = $request->input('name');
        $product->paypro_name = $request->input('paypro_name');
        $product->description_url = $request->input('description_url');
        $product->docs_url = $request->input('docs_url');
        $product->demo_url = $request->input('demo_url');
        $product->purchase_url = $request->input('purchase_url');
        $product->save();
        \Cache::forget('product_list');
        \Flash::success('Product Created');
        return \Redirect::back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $thiscategory = $product->productcategories;
        $categories = Productcategory::all()->diff($thiscategory);
        $thisreply = $product->replytemplates;
        $replies = Replytemplate::all()->diff($thisreply);
        return view('products.show', compact('product', 'thiscategory', 'categories', 'thisreply', 'replies'));
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
        $product = Product::find($id);
        $this->validate($request, [
            'name' => 'required|unique:products,name,' . $id,
            'purchase_url' => 'unique:products,purchase_url,' . $id,
            'paypro_name' => 'unique:products,paypro_name,' . $id
        ]);
        $product->name = $request->input('name');
        $product->paypro_name = $request->input('paypro_name');
        $product->description_url = $request->input('description_url');
        $product->docs_url = $request->input('docs_url');
        $product->demo_url = $request->input('demo_url');
        $product->purchase_url = $request->input('purchase_url');
        $product->save();
        \Cache::forget('product_list');
        \Flash::success('Product Info Updated');
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
        if(env('DELETE_DISABLED') == true){
            \Flash::error('Delete operation is disabled from environment file');
            return \Redirect::back();
        }
        if ($id == 1) {
            \Flash::error("Default product cannot be deleted!");
        } else {
            Product::destroy($id);
            \Flash::success('Deleted!');
        }

        return \Redirect::route('super.products.index');
    }

    public function assignCategory($id, $cat_id)
    {
        Product::find($id)->assignCategory($cat_id);
        \Flash::success('Product assigned to this category');
        return \Redirect::back();
    }

    public function revokeCategory($id, $cat_id)
    {
        Product::find($id)->revokeCategory($cat_id);
        \Flash::success('Product revoked from this category');
        return \Redirect::back();
    }

    public function assignReplyTemplate($id, $reply_id)
    {
        Product::find($id)->assignReplyTemplate($reply_id);
        \Flash::success('Reply Template assigned to this product');
        return \Redirect::back();
    }

    public function revokeReplyTemplate($id, $reply_id)
    {
        Product::find($id)->revokeReplyTemplate($reply_id);
        \Flash::success('Reply Template revoked from this product');
        return \Redirect::back();
    }
}
