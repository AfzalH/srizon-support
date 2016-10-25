<?php

namespace App\Http\Controllers;

use App\Ticketstatus;
use Illuminate\Http\Request;

use App\Http\Requests;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Ticketstatus::orderBy('sort_order', 'asc')->get();
        return view('ticket-status.index',compact('statuses'));
    }

    public function sort(Request $request){
        $jsonobj = json_decode($request->get('query'));

        foreach ($jsonobj as $obj) {
            if(isset($obj->id)){
                if($p = Ticketstatus::find($obj->id)) {
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
            'name' => 'required',
            'class' => 'required'
        ]);
        $status = new Ticketstatus();
        $status->name = $request->name;
        $status->class = $request->class;
        $status->save();
        \Cache::forget('ticket_status_list');
        \Flash::success('New status created');
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
        $status = Ticketstatus::find($id);
        return view('ticket-status.show',compact('status'));
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
            'name' => 'required',
            'class' => 'required'
        ]);
        $status = Ticketstatus::find($id);
        $status->name = $request->name;
        $status->class = $request->class;
        $status->save();
        \Cache::forget('ticket_status_list');
        \Flash::success('Status Updated');
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
        Ticketstatus::destroy($id);
        return \Redirect::route('super.ticketstatus.index');
    }
}
