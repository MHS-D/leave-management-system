<?php

namespace App\Services\Auth;

use App\Constants\Roles;
use App\Constants\Status;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * Discription: create a new user
     * @param
     * Name, email, password
     */
    public function storeUser($data)
    {
        try {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'status' => Status::UNACTIVE,
            ]);

            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Discription: generate sanctum token
     * @param
     * user
     */
    public function generateToken($user)
    {
        try {
            // delete old token
            $user->tokens()->delete();

            // new token
            $token = $user->createToken('my-app-token')->plainTextToken;

            return $token;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Description: check user credentials
     * @param $credentials email_username & password
     * @param $remember
     */
    public function checkUserCredentials($credentials, $remember = false)
    {
        try {
            if (Auth::attempt(["username" => $credentials['username'], 'password' => $credentials['password']], $remember)) {
                return Auth::user();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Description: redirect after authentication
     * @param
     * user
     */
    public function redirectAfterAuthentication($user)
    {
        try {
            if ($user->status == Status::ACTIVE && $user->roles()->exists()) {

                $route = in_array($user->role,[config('settings.roles.names.adminRole'),config('settings.roles.names.subAdminRole')]) ? route('dashboard') : route('leave-requests.index');

                return self::ajaxRedirectUrl($route);
            } else {
                Auth::logout($user);
                throw new Exception(__('strings.ACCOUNT_NOT_ACTIVE'));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Description: control user role (assign or remove)
     * @param
     * User, Role, action
     */
    public function Role($role, $user, $action)
    {
        try {
            if (!in_array($action, config('settings.roles.actions')) || !in_array($role, config('settings.roles.names')))
                throw new Exception('Invalid action or role');

            if ($action == config('settings.roles.actions.assignRole')) {
                if ($user->getRoleNames()->count())
                    throw new Exception('User already has a role');

                $user->assignRole($role);
            } elseif ($action == config('settings.roles.removeRole')) $user->removeRole($role);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $this;
    }

    /**
     * Description: redirect url after ajax
     * @param
     * url,
     */

    /**
     * Discription: logout user
     */
    public function logout()
    {
        try {
            Auth::logout();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Description: redirect url after ajax
     * @param
     * url,
     */
    public function ajaxRedirectUrl($url)
    {
        return json_encode([
            'redirect_url' => $url,
        ]);
    }
}
