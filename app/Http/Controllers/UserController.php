<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable; 
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        try {
            return $this->getUserUtils()->getUsersList($dataTable);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return $this->getUserUtils()->deleteUser($id);
        } catch (ModelNotFoundException $exception) {
            get_log($exception); 
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }

    public function profile(Request $request)
    {
        try {
            return $this->getUserUtils()->profile(auth()->user()->id);
        } catch (ModelNotFoundException $exception) {
            get_log($exception); 
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }

}
