<?php
function ds_login_redirect( $redirect_to, $request_redirect_to, $user )
{
    if ($user->ID != 0) {
        $user_info = get_userdata($user->ID);
        if ($user_info->primary_blog) {
            $primary_url = get_blogaddress_by_id($user_info->primary_blog) . '';
            if ($primary_url) {
                wp_redirect($primary_url);
                die();
            }
        }
    }
    return $redirect_to;
}
add_filter('login_redirect','ds_login_redirect', 100, 3);
?>