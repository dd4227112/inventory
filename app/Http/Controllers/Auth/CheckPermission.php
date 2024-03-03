<?php
namespace App\Http\Controllers\Auth;
trait checkPermission
{
    public function checkPermission($permission)
    {
        if (can_access($permission)) {
            return true;
        } else {
            abort(403);
        }
    }
}
?>