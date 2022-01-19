<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Session;

/**
 * Profile Component
 */
class Profile extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Profile Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $userArr = Session::get('User');
        $data = array();
        $result = '';
        if(!empty($userArr['userUUID']) && !empty($userArr['customerUUID'])){
            $token = $userArr['token'];
            $data['customerUUID'] = $userArr['customerUUID'];
            $data['userUUID'] = $userArr['userUUID'];
            $action = 'api-extend/getCustomerUser';
            $post_req = RequestHandler::makeRequest('post', $action, $data, $token);
            $_profileData = json_decode($post_req, true);
            if(@$_profileData['data']['status'] == 200 && $_profileData['code'] == 'Success') {
                $result = $_profileData['data'];
            }
        }
        $this->page['profileData'] = $result;
    }
}
