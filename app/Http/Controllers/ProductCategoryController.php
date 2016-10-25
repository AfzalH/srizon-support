<?php

namespace App\Http\Controllers;

use App\Productcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Redirect;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Productcategory::orderBy('sort_order', 'asc')->get();
        return view('product-category.index', compact('categories'));
    }

    public function sort(Request $request){
        $jsonobj = json_decode($request->get('query'));

        foreach ($jsonobj as $obj) {
            if(isset($obj->id)){
                if($p = Productcategory::find($obj->id)) {
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
            'name' => 'required|unique:productcategories'
        ]);
        $cat = new Productcategory();
        $cat->name = $request->input('name');
        if ($request->input('icon') == '') $cat->icon = 'fa fa-exclamation-circle';
        else if (strpos($request->input('icon'), 'fa ') === false) {
            $cat->icon = 'fa ' . $request->input('icon');
        } else {
            $cat->icon = $request->input('icon');
        }
        $cat->description = $request->input('description');
        $cat->save();
        \Flash::success('Category created');
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
        $category = Productcategory::find($id);
        return view('product-category.show', compact('category'));
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
        $cat = Productcategory::find($id);
        $this->validate($request, [
            'name' => 'required|unique:productcategories,name,' . $id
        ]);
        $cat->name = $request->input('name');
        if ($request->input('icon') == '') $cat->icon = 'fa fa-exclamation-circle';
        else if (strpos($request->input('icon'), 'fa ') === false) {
            $cat->icon = 'fa ' . $request->input('icon');
        } else {
            $cat->icon = $request->input('icon');
        }
        $cat->description = $request->input('description');
        $cat->save();
        \Flash::success('Category Info Updated');
        return Redirect::back();
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
            \Flash::error("Category 'Others' cannot be deleted!");
        } else {
            Productcategory::destroy($id);
            \Flash::success('Deleted!');
        }
        return Redirect::route('super.product-category.index');

    }
}
