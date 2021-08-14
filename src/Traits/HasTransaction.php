<?php

namespace Sinarajabpour1998\Gateway\Traits;

use Sinarajabpour1998\Gateway\Models\Transaction;

trait HasTransaction
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function pendingTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id')->where('status', 'pending');
    }

    public function successfulTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id')->where('status', 'successful');
    }

    public function failedTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id')->where('status', 'failed');
    }

    public function refundedTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id')->where('status', 'refunded');
    }
}
