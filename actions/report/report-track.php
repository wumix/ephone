<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/4/2015
 * Time: 9:47 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if( !isReady($params,array("desc")) || !isset($_SESSION['loggedin']) ) {
    dj($output);
}

$tid                    =   intval($params['tid']);
$desc                   =   secure($params['desc']);
$num                    =   secure($params['num']);
$email                  =   secure($params['email']);

$insertReportQuery      =   $db->prepare("INSERT INTO reports(tid,report_desc,contact_email,contact_number,uid,r_type)
                                          VALUES(:tid, :rd, :ce, :cn, :uid, :rt)");
$insertReportQuery->execute(array(
    ":tid"              =>  $tid,
    ":rd"               =>  $desc,
    ":ce"               =>  $email,
    ":cn"               =>  $num,
    ":uid"              =>  $_SESSION['uid'],
    ":rt"               =>  1
));
$output['status']       =   2;
dj($output);