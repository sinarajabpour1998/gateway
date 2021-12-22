<?php

namespace Sinarajabpour1998\Gateway\Traits;

use Sinarajabpour1998\Gateway\Models\Transaction;

trait DatabaseActions
{
    protected function createNewTransaction($orderId, $amount)
    {
        $transaction = Transaction::query()->create([
            'order_id' => $orderId,
            'amount' => $amount,
            'driver' => $this->driver,
            'status' => 'pending'
        ]);
        return $transaction;
    }

    protected function updateTransactionData($transactionId, $data)
    {
        Transaction::query()->where('id', $transactionId)->update($data);
    }

    protected function getTransaction($transactionId)
    {
        return Transaction::query()->where('id', $transactionId)->first();
    }

    protected function getTransactionByToken($token)
    {
        return Transaction::query()->where('token', $token)->first();
    }
}
