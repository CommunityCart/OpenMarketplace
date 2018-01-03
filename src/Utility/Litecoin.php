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
            $this->wallet = new Wallet(new JsonRPC($conf));

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

        $asdgf = $this->wallet->getNewAddress('hello');

        return $asdgf;
        
        } catch (RPCException $e) {
            echo $e->getTraceAsString();
            die();
        }
    }
}