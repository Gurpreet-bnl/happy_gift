<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Session;

/**
 * Dashboard Component
 */
class Dashboard extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dashboard Component',
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
        $result = array();
        if(!empty($userArr['userUUID']) && !empty($userArr['customerUUID'])){
            $token = $userArr['token'];
            $data['customerUUID'] = $userArr['customerUUID'];
            $data['userUUID'] = $userArr['userUUID'];
            $data['order_status'] = 1;
            $action = 'api-extend/getOrderInfo';
            $getWaitingOrder = RequestHandler::makeRequest('post', $action, $data, $token);
            $jsonData = json_decode($getWaitingOrder, true);
            if(@$jsonData['data']['status'] == 200 && $jsonData['code'] == 'Success') {
                $result = $jsonData['data']['results'];
            }
        }
        $totalOrder = count($result);
        $dataArr = array();
        foreach($result as $key => $val){
            if($key == 5){
                break;
            }
            $dataArr[] = $val;
        }
        $this->page['orders'] = $dataArr;
        $this->page['totalOrder'] = $totalOrder;
    }
}
