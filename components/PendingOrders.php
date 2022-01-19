<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Session;

/**
 * PendingOrders Component
 */
class PendingOrders extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'PendingOrders Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $this->addJs('assets/js/datatable.js');
        $this->addJs('assets/js/initDataTable.js');
        $this->addCss('assets/css/datatable.css');
        $userArr = Session::get('User');
        $data = array();
        $result = '';
        if(!empty($userArr['userUUID']) && !empty($userArr['customerUUID'])){
            $token = $userArr['token'];
            $data['customerUUID'] = $userArr['customerUUID'];
            $data['userUUID'] = $userArr['userUUID'];
            $data['order_status'] = 1;
            $action = 'api-extend/getOrderInfo';
            $getWaitingOrder = RequestHandler::makeRequest('post', $action, $data, $token);
            $jsonData = json_decode($getWaitingOrder, true);
            if(@$jsonData['data']['status'] == 200 && $jsonData['code'] == 'Success') {
                $result = array_merge($jsonData['data']['results'], $jsonData['data']['results'], $jsonData['data']['results']);
                $result = array_merge($result, $result);
            }
        }
        $this->page['orders'] = $result;
    }
}
