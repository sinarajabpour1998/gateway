<?php

namespace Sinarajabpour1998\Gateway\Drivers;

use Vandar\Laravel\Facade\Vandar as VandarFacade;
use Sinarajabpour1998\Gateway\Abstracts\Driver;

class Vandar extends Driver
{
    public function init($amount, $orderId, $callbackUrl, $detail = [])
    {
        // Create new transaction
        $transaction = $this->createNewTransaction($orderId, $amount);

        $result = VandarFacade::request($amount, $callbackUrl, null, $orderId, null);

        $given_result = (object) array('token' => '', 'url' => '');

        if ($result['status'] == 1){
            $this->updateTransactionData($transaction->id, ['token' => $result['token']]);
            if(isset($detail['auto_redirect']) && $detail['auto_redirect'] == false) {
                $given_result->token = $result['token'];
                $given_result->url = 'https://ipg.vandar.io/v3/' . $result['token'];
                return $given_result;

            } else {
                header( 'Location: https://ipg.vandar.io/v3/' . $result['token']);
                die();
            }
        }

        return $result;
    }

    public function verify($request)
    {
        $result = VandarFacade::verify($request['token']);
        
        if ($result['status'] == 1) {
            if ($result['message'] == 'ok') {
                $this->updateTransactionData($result['factorNumber'], ['status' => 'successful', 'ref_no' => $result['transId']]);
            } else {
                $this->updateTransactionData($result['factorNumber'], ['status' => 'failed', 'ref_no' => $result['transId']]);
            }
            return $result;

        }elseif ($result['status'] == 0){
            $this->updateTransactionData($request['transId'], ['status' => 'failed', 'description' => $result['error']]);
        }elseif ($result['status'] == 3){
            $this->updateTransactionData($request['transId'], ['status' => 'failed', 'description' => $result['errors'][0]]);
        }
        return $result;
    }
}
