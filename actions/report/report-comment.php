<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/4/2015
 * Time: 7:01 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if( !isReady($params,array("id")) || !isset($_SESSION['loggedin'])) {
    dj($output);
}

$cid                    =   intval($params['id']);
$insertReportQuery      =   $db->prepare("INSERT INTO reports(report_desc,uid,r_type,cid) VALUES(:rd, :uid, :rt, :cid)");
$insertReportQuery->execute(array(
    ":rd"               =>  "Comment is inappropriate/spam.",
    ":uid"              =>  $_SESSION['uid'],
    ":rt"               =>  2,
    ":cid"              =>  $cid
));
dj($output);