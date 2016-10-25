<?php

namespace App\Http\Controllers;

use App\Ticketcategory;
use Illuminate\Http\Request;

use App\Http\Requests;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Ticketcategory::orderBy('sort_order', 'asc')->get();
        return view('ticket-category.index',compact('categories'));
    }

    public function sort(Request $request){
        $jsonobj = json_decode($request->get('query'));

        foreach ($jsonobj as $obj) {
            if(isset($obj->id)){
                if($p = Ticketcategory::find($obj->id)) {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);
        $category = new Ticketcategory();
        $category->name = $request->name;
        $category->save();
        \Cache::forget('ticket_categories');
        \Flash::success('New Category created');
        return \Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Ticketcategory::find($id);
        return view('ticket-category.show',compact('category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);
        $status = Ticketcategory::find($id);
        $status->name = $request->name;
        $status->save();
        \Cache::forget('ticket_categories');
        \Flash::success('Category name updated');
        return \Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(env('DELETE_DISABLED') == true){
            \Flash::error('Delete operation is disabled from environment file');
            return \Redirect::back();
        }
        Ticketcategory::destroy($id);
        \Flash::success('Category deleted');
        return \Redirect::route('super.ticketcategory.index');
    }
}
