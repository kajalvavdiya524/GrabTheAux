<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Utilties\MeetingUtils;
use App\Http\Utilties\MembershipUtils;
use App\Http\Utilties\UserUtils;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getMeetingUtils() {
        return new MeetingUtils();
    }
    
    public function getMembershipUtils() {
        return new MembershipUtils();
    }

    public function getUserUtils() {
        return new UserUtils();
    }
}
