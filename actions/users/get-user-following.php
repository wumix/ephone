<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/18/2015
 * Time: 4:51 PM
 */
require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1);

if(!isReady($params,array('username'))){
    dj($output);
}

$username               =   secure($params['username']);
$offset                 =   (isset($params['offset'])) ? intval($params['offset']) : 0;

$followingQuery         =   $db->prepare("
SELECT *,(
  SELECT `profile_img` FROM users WHERE username = f.following
) as `img` FROM followers f WHERE followee = :f
LIMIT " . $offset . ", " . $settings['friend_display_count'] . "
");
$followingQuery->execute(array(
    ":f"                =>  $username
));

$output['status']       =   2;
$output['following']    =   $followingQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);