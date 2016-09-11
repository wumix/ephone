<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/7/2015
 * Time: 11:04 AM
 */
require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array();
$output['status']       =   2;

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    $output['status']   =   1;
}

dj($output);