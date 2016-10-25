<?php

namespace App\Http\Controllers;

use App\Product;
use App\Productlink;
use Flash;
use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use Redirect;

class ProductLinkController extends Controller
{
    protected $filepath = 'downloads';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Productlink::with('product')->orderBy('sort_order', 'asc')->get();
        $products = Product::orderBy('sort_order','asc')->get()->pluck('name','id');
        return view('product-link.index', compact('links','products'));
    }

    public function sort(Request $request){
        $jsonobj = json_decode($request->get('query'));

        foreach ($jsonobj as $obj) {
            if(isset($obj->id)){
                if($p = Productlink::find($obj->id)) {
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
        $this->validate($request,[
            'version'=>'required',
            'product'=>'required',
            'thefile'=>'required'
        ]);
        if ($request->hasFile('thefile') and $request->file('thefile')->isValid()) {
            $thefile = $request->file('thefile');
            $thefile->move(resource_path($this->filepath),$thefile->getClientOriginalName());
            $productlink = new Productlink();
            $productlink->version = $request->version;
            $productlink->product_id = $request->product;
            $productlink->filename = $thefile->getClientOriginalName();
            $productlink->notes = $request->notes;
            $productlink->save();
            Flash::success('Product Link Created!');
            \Cache::forget('dl_product_list');
            return Redirect::back();
        }
        else{
            Flash::warning('File upload failed');
            return Redirect::back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $link = Productlink::find($id);
        $products = Product::orderBy('sort_order','asc')->get()->pluck('name','id');
        return view('product-link.show', compact('link','products'));
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
        $productlink = Productlink::find($id);
        $prev_file_name = $productlink->filename;
        $this->validate($request,[
            'version'=>'required',
            'product'=>'required'
        ]);
        if ($request->hasFile('thefile') and $request->file('thefile')->isValid()) {
            $thefile = $request->file('thefile');
            $thefile->move(resource_path($this->filepath),$thefile->getClientOriginalName());
            $productlink->version = $request->version;
            $productlink->product_id = $request->product;
            $productlink->filename = $thefile->getClientOriginalName();
            $productlink->notes = $request->notes;
            $productlink->save();
            $this->maybeRemoveFile($prev_file_name);
            \Cache::forget('dl_product_list');
            Flash::success('Product link updated and new file uploaded!');
            return Redirect::back();
        }
        else{
            $productlink->version = $request->version;
            $productlink->product_id = $request->product;
            $productlink->notes = $request->notes;
            $productlink->save();
            \Cache::forget('dl_product_list');
            Flash::success('Product link updated keeping previous file!');
            return Redirect::back();
        }
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
        $link = Productlink::find($id);
        $filename = $link->filename;
        $link->delete();
        $this->maybeRemoveFile($filename);
        Flash::success('Link deleted');
        \Cache::forget('dl_product_list');
        return Redirect::route('super.productlink.index');
    }

    public function maybeRemoveFile($filename){
        if(!Productlink::whereFilename($filename)->count()){
            File::delete(resource_path($this->filepath.'/'.$filename));
        }
    }
}
