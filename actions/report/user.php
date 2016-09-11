<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/4/2015
 * Time: 5:56 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if( !isReady($params,array("uid")) || !isset($_SESSION['loggedin']) ) {
    dj($output);
}

$uid                    =   intval($params['uid']);
$insertReportQuery      =   $db->prepare("INSERT INTO reports(report_desc,uid,r_type,ruid) VALUES(:rd, :uid, :rt, :ruid)");
$insertReportQuery->execute(array(
    ":rd"               =>  "User reported for malicious behaviour.",
    ":uid"              =>  $_SESSION['uid'],
    ":rt"               =>  3,
    ":ruid"             =>  $uid
));

$output['status']       =   2;
dj($output);