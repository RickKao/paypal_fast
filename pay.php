<?php
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;


require 'app/start.php';

if(!isset($_GET['success'],$_GET['paymentId'],$_GET['PayerID'])){
	die("not set");
	// 傳回值三個都要有設置
}

if((bool)$_GET['success'] === false){
	die("not success");
	// 扣款沒成功就die
}

$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];

$payment = Payment::get($paymentId, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerId);

try {
	$result = $payment->execute($execute, $paypal);
}catch (Execption $e){
	$data = json_decode($e->getData());
	var_dump($data);
	die();
}

echo "Payment made. Thanks!";
