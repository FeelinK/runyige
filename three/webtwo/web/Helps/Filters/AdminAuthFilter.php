<?php
class Filters_AdminAuthFilter extends Filters_BaseFilter
{
    public function filter()
    {
        if (Session::has(UserEnum::ADMIN_USER_KEY)) {

            $admin_info = Session::get(UserEnum::ADMIN_USER_KEY);
            $action      = Route::currentRouteAction();
            list($class, $method) = explode('@', $action);
//            $user_info->role_id = UserEnum::USER_ROLE_ADMINISTRATOR;
            $aMenus      = AdminMenuEnum::getUserMenus($admin_info->role_id);
            if(!in_array($method,$aMenus)){
                $page = AccountService::instance()->getDefaultPage($admin_info->role_id);
                return Redirect::to($page);
            }
        } else {
            return Redirect::to('/');
        }
    }
}