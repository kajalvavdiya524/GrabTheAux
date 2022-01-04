<?php

namespace App\Http\Controllers;

use App\Membership;
use Illuminate\Http\Request;
use App\DataTables\MembershipDataTable;
use App\Http\Requests\StoreMembershipRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MembershipDataTable $dataTable)
    {
        try {
            return $this->getMembershipUtils()->getMembershipsList($dataTable);
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembershipRequest $request)
    {
        $request->validated();
        try {
          return $this->getMembershipUtils()->storeMembership($request);
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        return $this->getMembershipUtils()->showMembership($id);
      } catch (ModelNotFoundException $exception) {
          get_log($exception);
          return back()->withErrors($exception->getMessage())->withInput();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
        return $this->getMembershipUtils()->editMembership($id);
      } catch (ModelNotFoundException $exception) {
          get_log($exception);
          return back()->withErrors($exception->getMessage())->withInput();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMembershipRequest $request, $id)
    {
        $request->validated();
        try {
          return $this->getMembershipUtils()->updateMembership($request , $id);
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return back()->withErrors($exception->getMessage())->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
          return $this->getMembershipUtils()->deleteMembership($id);
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return back()->withErrors($exception->getMessage())->withInput();
        }

    }
    
    public function membershipPaymentDetail(Request $request){
      try {
        return $this->getMembershipUtils()->membershipPaymentDetail($request);
      } catch (ModelNotFoundException $exception) {
          get_log($exception);
          return back()->withErrors($exception->getMessage())->withInput();
      }
    }

    public function membershipPayment(Request $request , $id){
      try {
        return $this->getMembershipUtils()->membershipPayment($request, $id);
      } catch (ModelNotFoundException $exception) {
          get_log($exception);
          return back()->withErrors($exception->getMessage())->withInput();
      }
    }

}
