<?php
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require 'app/start.php';

if(!isset($_POST['product'],$_POST['price'])){
	die();
}

$product = $_POST['product'];
$price = $_POST['price'];
$shipping = 2.00;

$total = $price + $shipping;

$payer = new Payer();
$payer->setPaymentMethod('paypal');
// 付款方式設置

$item = new Item();
$item->setName($product)
	->setCurrency('USD')
	->setQuantity(1)
	->setPrice($price);

$itemList = new ItemList();
$itemList->setItems([$item]);

$details = new Details();
$details->setShipping($shipping)
	->setSubtotal($price);

$amount = new Amount();
$amount->setCurrency('USD')
	->setTotal($total)
	->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
	->setItemList($itemList)
	->setDescription('PayForSomething Payment')
	->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true')
	->setCancelUrl(SITE_URL . '/pay.php?success=false');

$payment = new Payment();
$payment->setIntent("sale")
	->setPayer($payer)
	->setRedirectUrls($redirectUrls)
	->setTransactions(array($transaction));	

try{
	$payment->create($paypal);

}catch (Exception $e) {
	die($e);
}

$approvalUrl =$payment->getApprovalLink();

header("location: {$approvalUrl}");