<?php

namespace Sinarajabpour1998\Gateway\Drivers;

use Illuminate\Support\Facades\Auth;
use Sinarajabpour1998\Gateway\Abstracts\Driver;

class Poolam extends Driver
{
    public function init($amount, $orderId, $callbackUrl, $detail = [])
    {
        // Create new transaction
        $transaction = $this->createNewTransaction($orderId, $amount);

        // $amount, $transaction->id, $transaction->created_at->format('Y/m/d H:i:s'), $callbackUrl
        $result = $this->payment_request($amount, $callbackUrl);

        if(isset($detail['auto_redirect']) && $detail['auto_redirect'] == false && $result['status'] == 1) {
            $result['token'] = $result['invoice_key'];
            $result['url'] = config('gateway.information')['poolam']['api_url'] . "pay/" . $result['token'];
            return $result;

        } elseif($result['status'] == 1) {
            $this->updateTransactionData($transaction->id, ['token' => $result['invoice_key']]);
            header( 'Location: ' . config('gateway.information')['poolam']['api_url'] . "pay/" . $result['invoice_key']);
            die();

        }

        return $result;
    }

    public function verify($request)
    {
        $check = $this->check_payment($request['invoice_key']);
        $transaction = $this->getTransaction($request['invoice_key']);

        if (!is_null($transaction)) {
            if ($check['status'] == 1 && $transaction->parent->user->id == Auth::user()->id) {
                $this->updateTransactionData($transaction->id, ['status' => 'successful', 'ref_no' => $check['bank_code']]);
                return $result;
            }

            $this->updateTransactionData($transaction->id, ['status' => 'failed', 'ref_no' => $result['errorCode'], 'description' => $result['errorDescription']]);
        }
        return $check;
    }

    protected function check_payment($inv_key){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,config('gateway.information')['poolam']['api_url'] . 'check/'.$inv_key);
        curl_setopt($ch,CURLOPT_POSTFIELDS,"api_key=" . config('gateway.information')['poolam']['api_key']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,1);
    }

    protected function payment_request($amount,$redirect){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,config('gateway.information')['poolam']['api_url'] . 'request');
        curl_setopt($ch,CURLOPT_POSTFIELDS,"api_key=" . config('gateway.information')['poolam']['api_key'] . "&amount=$amount&return_url=$redirect");
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,1);
    }
}
