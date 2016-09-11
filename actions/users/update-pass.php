<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/7/2015
 * Time: 2:48 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1, 'message' => 'You do not have permission to perform this action.' );

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

if( !isReady($params,array("newPass1","newPass2")) ){
    $output['message']  =   "You must enter a valid password.";
    dj($output);
}

$newPass1               =   secure($params['newPass1'],true);
$newPass2               =   secure($params['newPass2'],true);

if($newPass1 !== $newPass2){
    $output['message']  =   "Passwords don't match.";
    dj($output);
}

$updateUserQuery        =   $db->prepare("UPDATE users SET pass = :pass WHERE id = :id");
$updateUserQuery->execute(array(
    ":pass"             =>  $newPass2,
    ":id"               =>  $_SESSION['uid']
));

$output['status']       =   2;
$output['message']      =   "Your password has successfully been updated.";
dj($output);