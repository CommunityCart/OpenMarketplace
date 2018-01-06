<?php

namespace App\Utility;

use Headzoo\Bitcoin\Wallet\Api\JsonRPC;
use Headzoo\Bitcoin\Wallet\Api\Wallet;
use Headzoo\Bitcoin\Wallet\Api\Exceptions\RPCException;
use Cake\Core\Configure;

class Litecoin
{
    public $wallet;

    public function __construct()
    {
        $conf = [
            "user" => Configure::read('litecoin.user'),
            "pass" => Configure::read('litecoin.pass'),
            "host" => "127.0.0.1",
            "port" => 9335
        ];

        try {
            $this->wallet = new Wallet(new JsonRPC($conf), 2);

        } catch (RPCException $e) {

            echo $e->getTraceAsString();
            die();
        }
    }

    public function checkAddressForDeposit($address)
    {
        try {
        return $this->wallet->getBalanceByAddress($address);
        } catch (RPCException $e) {
            echo $e->getTraceAsString();
            die();
        }
    }

    public function checkAccountForBalance($account)
    {
        return $this->wallet->getBalanceByAccount($account);
    }

    public function generateNewDepositAddress($account)
    {
        try {

        return $this->wallet->getNewAddress('hello');

        } catch (RPCException $e) {
            echo $e->getTraceAsString();
            die();
        }
    }

    public function getPrivateKeyByAddress($address)
    {
        return $this->wallet->getPrivateKeyByAddress($address);
    }

    public function getTransactionsByAccount($account)
    {
        return $this->wallet->getTransactions($account);
    }

    public function getAllBalances($inlcude_empty)
    {
        return $this->wallet->getBalances($inlcude_empty);
    }
}