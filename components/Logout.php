<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Session;
use Redirect;

/**
 * Logout Component
 */
class Logout extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Logout Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        Session::forget('User');
        return Redirect::to('login');
    }
}
