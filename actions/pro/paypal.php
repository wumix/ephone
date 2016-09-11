<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/6/2015
 * Time: 11:06 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );
include( '../../inc/paypal.php' );

$paypal                     =   new Paypal();
$result                     =   $paypal->confirmIpn($_POST);

//If a Paypal transaction ID was returned
if(!is_string($result)) {
    die("Invalid Transaction");
}

$uid                   =    secure($_POST['custom']);
$name                  =    secure($_POST['address_name']);
$buyer_email           =    secure($_POST['payer_email']);
$txn_id                =    secure($_POST['txn_id']);
$payment_amount        =    secure($_POST['mc_gross']);

if($payment_amount != $settings['monthly_price'] && $payment_amount != $settings['yearly_price']){
    die("Invalid Transaction");
}

$expires                =   $payment_amount == $settings['monthly_price'] ?  time() + (86400 * 30) : time() + (86400 * 365);

$insertPurchaseQuery    =   $db->prepare("INSERT INTO pro_purchases(uid,buyer_name,paypal_email,txn_id,payment_amount,time_purchased,time_expires)
                                          VALUES( :uid, :bn, :pe, :txn, :pa, :tp, :te )");
$insertPurchaseQuery->execute(array(
    ":uid"              =>  $uid,
    ":bn"               =>  $name,
    ":pe"               =>  $buyer_email,
    ":txn"              =>  $txn_id,
    ":pa"               =>  $payment_amount,
    ":tp"               =>  time(),
    ":te"               =>  $expires
));

$updateUserQuery        =   $db->prepare("UPDATE users SET isPro='2', pro_expires = :pe WHERE id = :uid");
$updateUserQuery->execute(array(
    ":pe"               =>  $expires,
    ":uid"              =>  $uid
));