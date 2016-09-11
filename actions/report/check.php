<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/19/2015
 * Time: 4:15 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params, array('id')) || !isset($_SESSION['loggedin'])){
    dj($output);
}

$id                     =   intval($params['id']);
$reportQuery            =   $db->prepare("SELECT `title` FROM tracks WHERE id = :id");
$reportQuery->execute(array(
    ":id"               =>  $id
));

if($reportQuery->rowCount() !== 1){
    dj($output);
}

$output['track']        =   $reportQuery->fetch(PDO::FETCH_ASSOC);
$output['status']       =   2;
dj($output);