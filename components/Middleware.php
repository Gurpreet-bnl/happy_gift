<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Session;
use Request;
use Redirect;

/**
 * Middleware Component
 */
class Middleware extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Middleware Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        if( Session::has('User') ) {
            
        } else {
            return Redirect::to('login');
        }
    }
}
