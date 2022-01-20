<?php namespace Matat\Happygift\Components;

use Cms\Classes\ComponentBase;
use Matat\HappyGift\Models\RequestHandler;
use Session;
use Flash;
use Redirect;
use Input;

/**
 * NewOrder Component
 */
class NewOrder extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'NewOrder Component',
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
        if(!empty($userArr['userUUID']) && !empty($userArr['customerUUID'])){
            $data['userUUID'] = $userArr['userUUID'];
        }
        $this->page['userArr'] = $userArr;
    }
    public function onSubmitContactForm()
    {
        $userArr = request()->session()->get('User');
        $merchantData = '';
        if(!empty($userArr['userUUID']) && !empty(request()->companyGovId) && !empty($userArr['token'])){
            $data['userUUID'] = $userArr['userUUID'];
            $data['companyGovId'] = request()->companyGovId;
            $action = 'api-extend/getMerchantInfoByGovId';
            $merchantRecord = RequestHandler::makeRequest('post', $action, $data, $userArr['token']);
            $merchantArr = json_decode($merchantRecord, true);
            if($merchantArr['data']['status'] == 200 && $merchantArr['code'] == 'Success') {
                $merchantData = $merchantArr['data']['Data'];
            }
            $output = ['success' => true, 'data' => $merchantData];
        }else{
            $output = ['success' => false];
        }
        return response()->json($output);
        // return  ['name' => 'Mani', 'email' => 'zz@email.com'];
    }

    function onSubmitCeateOrder(){   
        // Flash::success('Settings successfully saved!');
        // Flash::error('Settings successfully saved!');
        // return Redirect::to('/waiting_orders/123456');
             
        $dataArr = array();
        $userArr = request()->session()->get('User');
        $dataArr['customerUUID'] = $userArr['customerUUID'];
        $dataArr['userUUID'] = $userArr['userUUID'];
        if(!empty($userArr['userUUID']) && !empty($userArr['token'])){
            if(!empty(request()->merchant['companyGovId']) && !empty(request()->meta_order['name']) && !empty(request()->customerOrder['number'])){
                
                $dataArr['merchant'] = request()->merchant;

                $dataArr['meta_order'] = request()->meta_order;
                $dataArr['meta_order']['order_status'] = 1;
                $dataArr['meta_order']['externalId'] = time();
                $dataArr['meta_order']['fileRef'] = (isset(request()->meta_order['fileRef']) ? $this->uploadFile(request()->meta_order['fileRef']) : '');
                
                $paymentDate = request()->payment['receipt_service_year'].'-'.request()->payment['receipt_service_date'].'-'.request()->payment['receipt_service_month'];
                
                $dataArr['payment'] = request()->payment;
                unset($dataArr['payment']['receipt_service_year']);
                unset($dataArr['payment']['receipt_service_date']);
                unset($dataArr['payment']['receipt_service_month']);
                $dataArr['payment']['date'] = $paymentDate;
                $dataArr['payment']['immediateRequest'] = (isset(request()->payment['immediateRequest']) ? true : false);
                $dataArr['payment']['knowledgeOfService'] = (isset(request()->payment['knowledgeOfService']) ? true : false);
                
                $dataArr['customerOrder'] = request()->customerOrder;
                $dataArr['customerOrder']['type'] = (isset(request()->customerOrder['type']) ? true : false);
                $dataArr['customerOrder']['fileRef'] = (isset(request()->customerOrder['fileRef']) ? $this->uploadFile(request()->customerOrder['fileRef']) : '');
                
                $action = 'api-extend/postNewEventData';
                $merchantRecord = RequestHandler::makeRequest('post', $action, $dataArr, $userArr['token']);

                preg_match('~\{(?:[^{}]|(?R))*\}~', $merchantRecord->body, $result);
                $merchantArr = json_decode($result[0], true);

                if($merchantArr['data']['status'] == 200 && $merchantArr['code'] == 'Success') {
                    $descrition = $merchantArr['data']['order_Descrition'];
                    $order_uuid = $merchantArr['data']['order uuid'];
                    $message = $merchantArr['message'];
                    Flash::success($message);
                    return Redirect::to('/awaiting-confirmation/'.$order_uuid);
                }else{
                    Flash::error('משהו השתבש.');
                }
            }else{
                Flash::error('נא למלא את כל פרטי הטופס.');
            }
        }else{
            Flash::error('משהו השתבש.');
        }
    }    
    
    function uploadFile($uploaddata){
        $plugin_dir = plugins_path();
        $assetUrl = $plugin_dir . dirname(dirname($this->dirName)).'/assets';
        $data_file = $uploaddata;
        $fileName = $data_file->getClientOriginalName();
        $destinationPath = $assetUrl.'/images';
        $file = rand().'_'.$fileName;
        $data_file->move($destinationPath, $file);
        $uploaded_path = $destinationPath.'/'.$file;
        return $uploaded_path;
    }

    function onClickAppendForm(){
        $this->page['numerOfForm'] = request()->numerOfForm + 1;
    }


}
