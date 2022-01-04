<?php

namespace App\Http\Utilties;

use App\Http\Utilties\CommonUtils;
use App\Meeting;
use App\Membership;
use App\User;
class BaseUtility {

    function __construct() {
        
    }

    /**
     * 
     * SETTERS
     */
    public function getCommonUtils() {
        return new CommonUtils();
    }  

    public function meetingModal() {
        return new Meeting();
    }

    public function membershipModal() {
        return new Membership();
    }

    public function userModal() {
        return new User();
    }


}