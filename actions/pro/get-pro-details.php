<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/6/2015
 * Time: 10:37 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array( 'status' => 1 );

if( !isset($_SESSION['loggedin']) ) {
    dj($output);
}

$userCheckQuery         =   $db->prepare("SELECT `isPro`,`pro_expires` FROM users WHERE id = :id");
$userCheckQuery->execute(array(
    ":id"               =>  $_SESSION['uid']
));
$userCheckRow           =   $userCheckQuery->fetch();

$output['uid']          =   $_SESSION['uid'];
$output['isPro']        =   $userCheckRow['isPro'] == 1 ? false : true;
$output['expires']      =   @date("M d, Y", $userCheckRow['pro_expires']);
$output['status']       =   2;
dj($output);