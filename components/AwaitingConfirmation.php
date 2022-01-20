<?php namespace Matat\Happygift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Session;
use Flash;
use Redirect;

/**
 * AwaitingConfirmation Component
 */
class AwaitingConfirmation extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'AwaitingConfirmation Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $userArr = Session::get('User');
        $orderId = $this->param('id');
        $data = array();
        $order_detail = array();
        if(!empty($userArr['userUUID']) && !empty($userArr['customerUUID']) && !empty($orderId)){
            $data['customerUUID'] = $userArr['customerUUID'];
            $data['userUUID'] = $userArr['userUUID'];
            $data['order_uuid'] = $orderId;
            $action = 'api-extend/getOrderData';
            $merchantRecord = RequestHandler::makeRequest('post', $action, $data, $userArr['token']);
            $merchantArr = json_decode($merchantRecord->body, true);            
            if($merchantArr['data']['status'] == 200 && $merchantArr['code'] == 'Success') {
                $order_detail = $merchantArr['data'];
            }
            $this->page['orderDetail'] = $order_detail;
        }else{
            Flash::error('משהו השתבש.');
        }
    }
}
