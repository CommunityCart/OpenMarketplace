<?php

namespace App\Utility;

use Headzoo\Bitcoin\Wallet\Api\JsonRPC;
use Headzoo\Bitcoin\Wallet\Api\Wallet;
use Headzoo\Bitcoin\Wallet\Api\Exceptions\RPCException;
use Cake\Core\Configure;
use App\Utility\Wallet as WalletUtility;

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
            $this->wallet = new Wallet(new JsonRPC($conf), 6);

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

    public function getAllAccounts()
    {
        return $this->wallet->getAccounts();
    }

    public function getBalances()
    {
        return $this->wallet->getBalances();
    }

    public function getBalance()
    {
        return $this->wallet->getBalance();
    }

    public function checkAccountForBalance($account)
    {
        return $this->wallet->getBalanceByAccount($account);
    }

    public function generateNewDepositAddress($account)
    {
        try {

        return $this->wallet->getNewAddress($account);

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

    public function sendFromAccount($account, $address, $amount)
    {
        return $this->wallet->sendFromAccount($account, $address, $amount);
    }

    public function moveFromAccountToAccount($fromAccount, $toAccount, $amount)
    {
        $details = $this->wallet->move($fromAccount, $toAccount, $amount);

        $fromWallet = WalletUtility::getWalletByUserID($fromAccount);

        MenuCounts::updateUserViewedWallet($fromAccount);

        $walletTransactionTable = Tables::getWalletTransactionTable();
        $transaction = $walletTransactionTable->newEntity([
            'wallet_id' => $fromWallet->get('id'),
            'transaction_hash' => '(send) internal funds transfer',
            'transaction_details' => $details,
            'balance' => '-' . $amount,
            'created' => new \DateTime('now'),
            'transaction_time' => $details['time'],
            'confirmations' => 11
        ]);
        $walletTransactionTable->save($transaction);

        $toWallet = WalletUtility::getWalletByUserID($toAccount);

        MenuCounts::updateUserViewedWallet($toAccount);

        $walletTransactionTable = Tables::getWalletTransactionTable();
        $transaction = $walletTransactionTable->newEntity([
            'wallet_id' => $toWallet->get('id'),
            'transaction_hash' => '(receive) internal funds transfer',
            'transaction_details' => $details,
            'balance' => $amount,
            'created' => new \DateTime('now'),
            'transaction_time' => $details['time'],
            'confirmations' => 11
        ]);
        $walletTransactionTable->save($transaction);

        return $details;
    }

    /**
     * Sends coins to multiple addresses
     *
     * @param  string $account   Name of the from account
     * @param  array  $addresses ["address1" => "amount1", "address2" => "amount2"]
     * @param  string $comment   A comment on this transaction
     * @return array
     */
    public function sendManyFromAccount($account, array $addresses)
    {
        return $this->wallet->sendManyFromAccount($account, $addresses);
    }
}