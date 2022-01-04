<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Utilties;
use Stripe;
use Session;
use Exception;
class MembershipUtils extends BaseUtility {

    public function getMembershipsList($dataTable){

        return $dataTable->render('memberships.index');
    }

    public function storeMembership($request){

        $membership                 = $this->membershipModal();
        $membership->title          = $request->get('title');
        $membership->description    = $request->get('description');
        $membership->price          = $request->get('price');
        $membership->status         = $request->get('status');
        $membership->save();

        return redirect()->back()->with('success' , 'Membership Created Successfully');
    }

    public function showMembership($id){

      $membership = $this->membershipModal()->where('id', $id)->first();
      return view('memberships.show' , compact('membership'));
    }

    public function editMembership($id){

        $membership = $this->membershipModal()->where('id', $id)->first();

        return view('memberships.edit' , compact('membership'));
    }

    public function updateMembership($request, $id){

        $membership                     = $this->membershipModal()->where('id', $id)->first();
        $membership->title              = $request->get('title');
        $membership->description        = $request->get('description');
        $membership->price              = $request->get('price');
        $membership->status             = $request->get('status');
        $membership->save();

        return redirect()->back()->with('success' , 'Membership Updated Successfully');
    }

    public function deleteMembership($id){
        $membership    = $this->membershipModal()->where('id', $id)->first();
        $membership->delete();

        return redirect()->back()->with('success' , 'Membership Deleted Successfully');
    }

    public function membershipPaymentDetail($request){
        $membership    = $this->membershipModal()->where('status', 1)->latest()->first();
        return view('memberships.membership_payment_detail' , compact('membership'));
    }

    public function membershipPayment($request, $id){
        $membership             = $this->membershipModal()->where('id', $id)->first();
        $user                   = auth()->user();
        $user->membership_id    = $id;
        $user->save();

        Stripe\Stripe::setApiKey(config('stripe.stripe_secret'));
        Stripe\Charge::create ([
                "amount" => $membership->price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => $membership->title.' Membership selected by user '.$user->first_name.' '.$user->last_name,
        ]);

        return redirect('/meetings')->with('success' , 'Membership purchase completed successfully!');
    }
}
