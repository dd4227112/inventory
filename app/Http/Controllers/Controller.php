<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;

// use App\Http\Controllers\Auth\checkPermission;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function checkPermission($permission)
    {
        if (can_access($permission)) {
            return true;
        } else {
            abort(403);
            // return Redirect::to('/unauthorized');
            return redirect()->route('unauthorized');

        }
    }
}
