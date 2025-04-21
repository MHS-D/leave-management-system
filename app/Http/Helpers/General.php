<?php

function getSideBarTransalted($label)
{
    $sidebar = [
        'Dashboard' => __('strings.DASHBOARD'),
        'Users' => __('strings.USERS'),
        'Logout' => __('strings.LOGOUT'),
        'Leave Requests' => __('strings.LEAVE_REQUESTS'),
    ];

    return $sidebar[$label];
}

function loadCssFolder(){
    $lang = [
        'ar' => 'css',
        'en' => 'css-ltr',
    ][app()->getLocale()];

    return $lang;

}






