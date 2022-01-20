<?php namespace Matat\HappyGift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Session;
use Matat\HappyGift\Models\CustomerData;

/**
 * PlacedOrders Component
 */
class PlacedOrders extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'PlacedOrders Component',
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
        $customerDetail = array();
        if(!empty($userArr['userUUID']) && !empty($userArr['customerUUID'])){
            $token = $userArr['token'];
            $data['customerUUID'] = $userArr['customerUUID'];
            $data['userUUID'] = $userArr['userUUID'];
            $data['order_status'] = 3;
            $action = 'api-extend/getOrderInfo';
            $getPlacedOrder = RequestHandler::makeRequest('post', $action, $data, $token);
            $jsonData = json_decode($getPlacedOrder, true);
            if(@$jsonData['data']['status'] == 200 && $jsonData['code'] == 'Success') {
                $result = $jsonData['data']['results'];
                $customerDetail = CustomerData::getCustomerDetail($data, $token);
            }
        }
        $this->page['orders'] = $result;
        $this->page['customerDetail'] = $customerDetail;
    }
}
