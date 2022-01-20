<?php namespace Matat\HappyGift\Models;

use Matat\HappyGift\Models\RequestHandler;

class CustomerData
{
    public static function getCustomerDetail($data, $token){
        $customerData = array();
        $action = 'api-extend/getCustomerUser';
        $customerRecord = RequestHandler::makeRequest('post', $action, $data, $token);
        $customerArr = json_decode($customerRecord, true);
        if($customerArr['data']['status'] == 200 && $customerArr['code'] == 'Success') {
            $customerData['customerData'] = $customerArr['data'];
        }
        return $customerData;
    }
}