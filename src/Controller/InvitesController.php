<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Settings;
use Cake\Routing\Router;
use App\Utility\MenuCounts;

/**
 * Invites Controller
 *
 * @property \App\Model\Table\InvitesTable $Invites
 *
 * @method \App\Model\Entity\Invite[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvitesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        MenuCounts::updateUserViewedInvites($this->Auth->user('id'), true);

        $this->loadModel('InvitesClaimed');
        $this->loadModel('InvitesFinalized');
        $this->loadModel('Orders');
        $this->loadModel('Products');

        $invite = $this->Invites->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if(!isset($invite)) {

            $invite = $this->Invites->newEntity([
                'user_id' => $this->Auth->user('id'),
                'code' => substr(md5($this->Auth->user('id')), 0, 10),
                'count_left' => Settings::getInviteMax(),
                'count_claimed' => 0,
                'created' => new \DateTime('now')
            ]);

            $this->Invites->save($invite);
        }

        $purchasesInEscrow = 0;
        $purchasesFinalized = 0;
        $purchasesInEscrowCash = 0;
        $purchasesFinalizedCash = 0;

        $invitees = $this->InvitesClaimed->find('all', ['contain' => ['Users']])->where(['invite_id' => $invite->get('id')])->all();

        foreach($invitees as $invitee)
        {
            $orders = $this->Orders->find('all')->where(['user_id' => $invitee->get('user_id'), 'status >=' => 2, 'status <' => 5])->all();

            $purchasesInEscrow = $purchasesInEscrow + count($orders);

            foreach($orders as $order) {

                $purchasesInEscrowCash = $purchasesInEscrowCash + $order->get('order_total_dollars');
            }

            $orders = $this->Orders->find('all')->where(['user_id' => $invitee->get('user_id'), 'status >=' => 5, 'status <' => 7])->all();

            $purchasesFinalized = $purchasesFinalized + count($orders);

            foreach($orders as $order) {

                $purchasesFinalizedCash = $purchasesFinalizedCash + $order->get('order_total_dollars');
            }
        }

        $salesInEscrow = 0;
        $salesInEscrowCash = 0;
        $salesFinalized = 0;
        $salesFinalizedCash = 0;

        $invitees = $this->InvitesClaimed->find('all', ['contain' => ['Users']])->where(['invite_id' => $invite->get('id'), 'upgraded_to_vendor' => 1])->all();

        foreach($invitees as $invitee) {

            $products = $this->Products->find('all')->where(['vendor_id' => $invitee->get('vendor_id')])->all();

            foreach($products as $product) {

                $orders = $this->Orders->find('all')->where(['product_id' => $product->get('id'), 'status >=' => 2, 'status <' => 5])->all();

                $salesInEscrow = $salesInEscrow + count($orders);

                foreach($orders as $order) {

                    $salesInEscrowCash = $salesInEscrowCash + $order->get('order_total_dollars');
                }

                $orders = $this->Orders->find('all')->where(['product_id' => $product->get('id'), 'status >=' => 5, 'status <' => 7])->all();

                $salesFinalized = $salesFinalized + count($orders);

                foreach($orders as $order) {

                    $salesFinalizedCash = $salesFinalizedCash + $order->get('order_total_dollars');
                }
            }
        }

        $unpaidPurchasesInEscrow = $purchasesInEscrowCash * Settings::getUserCommissionPercent();
        $unpaidSalesInEscrow = $salesInEscrowCash * Settings::getVendorCommissionPercent();
        $unpaidTotalInEscrow = $unpaidPurchasesInEscrow + $unpaidSalesInEscrow;

        $paidFinalizedPurchases = $purchasesFinalizedCash * Settings::getUserCommissionPercent();
        $paidFinalizedSales = $salesFinalizedCash * Settings::getVendorCommissionPercent();
        $paidFinalizedTotal = $paidFinalizedPurchases + $paidFinalizedSales;

        $userRegistrations = $this->InvitesClaimed->find('all', ['contain' => ['Users']])->where(['invite_id' => $invite->get('id')])->count();
        $vendorUpgrades = $this->InvitesClaimed->find('all', ['contain' => ['Users']])->where(['invite_id' => $invite->get('id'), 'upgraded_to_vendor' => 1])->count();
        $invitesClaimed = $this->InvitesClaimed->find('all', ['contain' => ['Users']])->where(['invite_id' => $invite->get('id')])->orderDesc('InvitesClaimed.created')->limit(100)->all();
        $invitesFinalized = $this->InvitesFinalized->find('all', ['contain' => ['Orders']])->where(['invite_id' => $invite->get('id')])->orderDesc('InvitesFinalized.finalized')->limit(100)->all();

        $inviteLink = Router::url('/', true) . 'youre-invited/' . $invite->get('code');

        $this->set('unpaidPurchasesInEscrow', $unpaidPurchasesInEscrow);
        $this->set('unpaidSalesInEscrow', $unpaidSalesInEscrow);
        $this->set('unpaidTotalInEscrow', $unpaidTotalInEscrow);
        $this->set('paidFinalizedPurchases', $paidFinalizedPurchases);
        $this->set('paidFinalizedSales', $paidFinalizedSales);
        $this->set('paidFinalizedTotal', $paidFinalizedTotal);
        $this->set('salesInEscrow', $salesInEscrow);
        $this->set('salesInEscrowCash', $salesInEscrowCash);
        $this->set('salesFinalized', $salesFinalized);
        $this->set('salesFinalizedCash', $salesFinalizedCash);
        $this->set('purchasesInEscrow', $purchasesInEscrow);
        $this->set('purchasesInEscrowCash', $purchasesInEscrowCash);
        $this->set('purchasesFinalized', $purchasesFinalized);
        $this->set('purchasesFinalizedCash', $purchasesFinalizedCash);
        $this->set('invitesFinalized', $invitesFinalized);
        $this->set('invitesClaimed', $invitesClaimed);
        $this->set('commissionPercent', Settings::getUserCommission());
        $this->set('commissionPercentVendors', Settings::getVendorCommission());
        $this->set('userRegistrations', $userRegistrations);
        $this->set('vendorUpgrades', $vendorUpgrades);
        if($invite->get('count_left') == '-1') {
            $this->set('invitesLeft', 'unlimited');
        }
        else {
            $this->set('invitesLeft', $invite->get('count_left'));
        }
        if(Settings::getInviteMax() == -1) {
            $this->set('invitesTotal', 'unlimited');
        }
        else {
            $this->set('invitesTotal', Settings::getInviteMax());
        }
        $this->set('inviteLink', $inviteLink);
    }
}
