<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/15/2015
 * Time: 9:56 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array(
    'status'            =>  1,
    'playlists'         => array()
);

if(!isset($_SESSION['uid'], $_SESSION['loggedin'])){
    dj($output);
}

$playlistQuery          =   $db->prepare("SELECT * FROM playlists WHERE uid = :uid");
$playlistQuery->execute(array(
    ":uid"              =>  $_SESSION['uid']
));
$output['status']       =   2;
$output['playlists']    =   $playlistQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);