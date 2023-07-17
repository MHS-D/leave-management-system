<?php

use App\Constants\FollowersLevel;
use App\Constants\SubscriptionStatus;
use App\Constants\WalletType;
use App\Models\ProjectSubscription;
use App\Models\Setting;
use App\Models\SystemTotal;
use App\Models\UserNotification;
use App\Models\UsersToken;
use App\Models\Wallet;

/**
 * Get setting value by key
 *
 * @param string $key
 * @return null|string|integer|float
 */
function setting(string $key): null|string|int|float
{
    $setting = Setting::where('key', $key)->first();

    return $setting?->value;
}

/**
 * Extract Numbers From String
 *
 * @param string $string
 * @param bool $keepNegative
 * @return string
 */
function extractNumbers(string|null $string, bool $keepNegative = false): string|null
{
    if (!$string) {
        return null;
    }

    preg_match_all('!\d+!', $string, $matches); // Reference: https://www.delftstack.com/howto/php/how-to-extract-numbers-from-a-string-in-php/

    if ($keepNegative) {
        if ($string && $string[0] == '-') {
            array_unshift($matches[0], '-');
        }
    }

    return count($matches ?? []) > 0 ? implode('', $matches[0]) : '';
}

function getArrayKeysWhere($array, $string, $operator = 'like', $case = 'insensitive')
{
    $values = array_values($array);
    $keys = array_keys($array);

    $filtredValues = array_filter($array, function ($item) use ($string, $operator, $case) {
        if ($case == 'insensitive') {
            $item = strtolower($item);
            $string = strtolower($string);
        }

        if ($operator == 'like') {
            return strpos($item, $string) !== false;
        }
        else if ($operator == '=') {
            return $item == $string;
        }
    });

    dd($filtredValues);
}

function getSideBarTransalted($label)
{
    $sidebar = [
        'Dashboard' => __('strings.DASHBOARD'),
        'Users' => __('strings.USERS'),
        'Logout' => __('strings.LOGOUT'),
        'Projects' => __('strings.PROJECTS'),
    ];

    return $sidebar[$label];
}

function getAllowedStatuses($action = 'view' ,$user = null)
{
    $user = $user ?? auth()->user();
    return $user ? config('settings.roles.allowed_statuses.' . $user->role . '.' . $action) : [];
}

function loadCssFolder(){
    $lang = [
        'ar' => 'css',
        'en' => 'css-ltr',
    ][app()->getLocale()];

    return $lang;

}






