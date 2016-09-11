<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/3/2015
 * Time: 5:22 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params, array('code'))){
    dj($output);
}

$code                   =   secure($params['code']);

$checkUserQuery         =   $db->prepare("SELECT `username` FROM users WHERE user_code = :code");
$checkUserQuery->execute(array(
    ":code"         =>  $code,
));

if($checkUserQuery->rowCount() !== 1){
    dj($output);
}

$updateUserQuery        =   $db->prepare("UPDATE users SET email_confirmed='2' WHERE user_code = :code");
$updateUserQuery->execute(array(
    ":code"             =>  $code
));

$output['status']       =   2;
dj($output);