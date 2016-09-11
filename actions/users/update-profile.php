<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/8/2015
 * Time: 2:12 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1, 'You must be logged in to perform this action.' );

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

if( !isReady($params,array("display_name")) ){
    $output['message']  =   "You must have a display name.";
    dj($output);
}

$userQuery              =   $db->prepare("SELECT * FROM users WHERE id = :id");
$userQuery->execute(array( ":id"    =>  $_SESSION['uid']));
if($userQuery->rowCount() == 0){
    dj($output);
}
$userRow                =   $userQuery->fetch();

$display_name           =   secure(substr($params['display_name'],0,255));
$intro_text             =   secure(substr($params['intro_text'],0,128));
$location               =   secure($params['location']);
$about                  =   secure(substr($params['about'],0,1000));
$website                =   secure($params['website']);
$facebook               =   secure($params['facebook']);
$twitter                =   secure($params['twitter']);
$gplus                  =   secure($params['gplus']);
$youtube                =   secure($params['youtube']);
$vk                     =   secure($params['vk']);
$soundcloud             =   secure($params['soundcloud']);

if( !empty($website) && !filter_var($website, FILTER_VALIDATE_URL) ){ // Check Purchase Link
    $output['message']  =   "The website URL you provided is invalid.";
    dj($output);
}

$updateUserQuery        =   $db->prepare("UPDATE users SET display_name = :dn, intro_text = :it,
                                                           location = :loc, about = :about,
                                                           website = :ws, facebook = :fb,
                                                           twitter = :twitter, gplus = :gp,
                                                           youtube = :yt, vk = :vk,
                                                           soundcloud = :sc
                                          WHERE id = :id");
$updateUserQuery->execute(array(
    ":dn"               =>  $display_name,
    ":it"               =>  $intro_text,
    ":loc"              =>  $location,
    ":about"            =>  $about,
    ":ws"               =>  $website,
    ":fb"               =>  $facebook,
    ":twitter"          =>  $twitter,
    ":gp"               =>  $gplus,
    ":yt"               =>  $youtube,
    ":vk"               =>  $vk,
    ":sc"               =>  $soundcloud,
    ":id"               =>  $_SESSION['uid']
));

$updateTracksQuery  =   $db->prepare("UPDATE tracks SET artist = :artist WHERE uid = :uid");
$updateTracksQuery->execute(array(
    ":artist"       =>  $display_name,
    ":uid"          =>  $_SESSION['uid']
));

$output['status']       =   2;
$output['message']      =   "Your profile has successfully been updated.";
dj($output);