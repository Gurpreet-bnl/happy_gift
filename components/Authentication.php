<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Input;
use Session;
use Redirect;

/**
 * Authentication Component
 */
class Authentication extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Authentication Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        if (Session::has('User')) {
            return Redirect::to('/');
        }
    }

    public function onSubmit() {
        $credentials = Input::all();
        $_data = array();
        $_data['username'] = $credentials['user_name'];
        $_data['password'] = $credentials['password'];
        $_action = 'jwt-auth/v1/token';
        $post_req = RequestHandler::makeRequest('post', $_action, $_data);
        $_jsonData = json_decode($post_req, true);
        if(@$_jsonData['statusCode'] == 200 && $_jsonData['code'] == 'jwt_auth_valid_credential') {
            Session::put('User', $_jsonData['data']);
            Session::save();
            return Redirect::to('/');
        } else {
            return Redirect::to('login');
        }
    }
}
