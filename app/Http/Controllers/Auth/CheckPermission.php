<?php
namespace App\Http\Controllers\Auth;
trait CheckPermission
{
    public function CheckPermission($permission)
    {
        if (can_access($permission)) {
            return true;
        } else {
            abort(403);
        }
    }
}
?>