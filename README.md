# Laravel Payment Package For Iranian Bank Gateways
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sinarajabpour1998/transaction.svg?style=flat-square)](https://packagist.org/packages/sinarajabpour1998/gateway)
[![GitHub issues](https://img.shields.io/github/issues/sinarajabpour1998/gateway?style=flat-square)](https://github.com/sinarajabpour1998/gateway/issues)
[![GitHub stars](https://img.shields.io/github/stars/sinarajabpour1998/gateway?style=flat-square)](https://github.com/sinarajabpour1998/gateway/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/sinarajabpour1998/gateway?style=flat-square)](https://github.com/sinarajabpour1998/gateway/network)
[![Total Downloads](https://img.shields.io/packagist/dt/sinarajabpour1998/gateway.svg?style=flat-square)](https://packagist.org/packages/sinarajabpour1998/gateway)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sinarajabpour1998/gateway/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sinarajabpour1998/gateway/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/sinarajabpour1998/gateway/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sinarajabpour1998/gateway/build-status/master)
[![GitHub license](https://img.shields.io/github/license/sinarajabpour1998/gateway?style=flat-square)](https://github.com/sinarajabpour1998/gateway/blob/master/LICENSE)

A Laravel Package for Payment Gateway Integration.

## <g-emoji class="g-emoji" alias="gem" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f48e.png">💎</g-emoji> List of available drivers

- [parsian](https://www.pec.ir/)

- [pasargad](https://bpi.ir/)

- [vandar](https://vandar.io/)
- 
- [poolam](https://poolam.ir/fa/)


## How to install and config [sinarajabpour1998/gateway](https://github.com/sinarajabpour1998/gateway) package?

#### <g-emoji class="g-emoji" alias="arrow_down" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/2b07.png">⬇️</g-emoji> Installation

```bash
composer require sinarajabpour1998/gateway
```

#### Publish Config file

```bash
php artisan vendor:publish --tag=gateway
```

#### Migrate tables, to add transactions table to database

```bash
php artisan migrate
```

#### <g-emoji class="g-emoji" alias="book" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f4d6.png">📖</g-emoji> How to use exists drivers from package

- Set the configs in /config/gateway.php

  - Use this sample code for Request Payment 

      ```php
      <?php
  
      // Parsian Driver
      $transaction = Transaction::driver('parsian')
              ->amount(2000)
              ->orderId(2000)
              ->callbackUrl('callback_parsian')
              ->detail(['auto_redirect' => false]) // if we want to get {token, url} and not auto redirect to Bank Gateway.
              ->pay();
  
      // Pasargad Driver
      $transaction = Transaction::driver('pasargad')
              ->amount(2000)
              ->orderId(2000)
              ->callbackUrl('callback_pasargad')
              ->detail(['auto_redirect' => false]) // if we want to get {token, url} and not auto redirect to Bank Gateway.
              ->pay();
      // Vandar Driver
      $transaction = Transaction::driver('vandar')
              ->amount(2000)
              ->orderId(2000)
              ->callbackUrl('callback_vandar')
              ->detail(['auto_redirect' => false]) // if we want to get {token, url} and not auto redirect to Bank Gateway.
              ->pay();

      ```
  
    - Use this sample code for Verify Payment

        ```php
        // Parsian Driver, that use POST type
        Route::post('/callback_parsian', function () {
            $verify = Transaction::driver('parsian')->request(request()->all())->verify();
        });
    
        // Pasargad Driver, that use GET type
        Route::get('/callback_pasargad', function () {
            $verify = Transaction::driver('pasargad')->request(request()->all())->verify();
        });
      
        // Vandar Driver, that use GET type
        request()->merge(['transId' => $order->transaction->id]);
        $result = Transaction::driver('vandar')->request(request()->all())->verify();
      ```

- Use this Trait in you'r Model (for example Payment, Invoice, Order, ...) that has many transactions and has relation with Transaction Model

    ```php
    // Use the Trait
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
  
    use Sinarajabpour1998\Gateway\Traits\HasTransaction;
    
    class Order extends Model
    {
        use HasFactory, HasTransaction;
    }
  
    // After add the Trait we can use this relations
    $order->transaction; // get latest transaction from this order
    $order->transactions; // get the all transactions for this order
    $order->pendingTransactions; // get the pending transactions for this order
    $order->successfulTransactions; // get the successful transactions for this order
    $order->failedTransactions; // get the failed transactions for this order
    $order->refundedTransactions; // get the refunded transactions for this order
    ```
- Get the parent of a transaction or this transaction belongs to which model

    ```php
    // Set the namespace of your model in /config/transaction.php
    'model' => 'App\Models\Order',

    // Use relation for get a parent of this transaction
    $transaction->parent;
    ```
  
- Transaction model's data and appends

    ```php
    // Default
    $transaction->id;
    $transaction->order_id;
    $transaction->amount;
    $transaction->driver;
    $transaction->status;
    $transaction->ref_no;
    $transaction->token;
    $transaction->created_at;
    $transaction->updated_at;
    // Appends
    $transaction->gateway; // Label of driver 
    $transaction->toman; // Get price to taman (convert rial to toman)
    $transaction->status_label; // Label of status
    ```

#### Requirements:

- PHP v7.0 or above
- Laravel v7.0 or above
- [parsian_gateway](https://github.com/sinarajabpour1998/parsian_gateway)
- [pasargad_gateway](https://github.com/sinarajabpour1998/pasargad_gateway)
- [vandar-laravel](https://github.com/maryamnbyn/vandar-laravel)
