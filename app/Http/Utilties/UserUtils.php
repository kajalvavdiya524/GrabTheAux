<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Utilties;
use App\Membership;

class UserUtils extends BaseUtility {
    public function getUsersList($dataTable){
        return $dataTable->render('users.index');
    }

    public function deleteUser($id){
        $user = $this->userModal()->findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success' , 'User Deleted Successfully');
    }

    public function profile($id){
        $user = $this->userModal()->findOrFail($id);
        $total_users = $this->userModal()->count();
        $total_memberships = Membership::count();
        return view('users.profile',compact('user' , 'total_users' , 'total_memberships'));
    }

}
