<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/25/2015
 * Time: 2:19 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['alerts']       =   array();

if(!isset($_SESSION['loggedin'], $params['lastAlertId'])){
    dj($output);
}

$last_id                =   intval($params['lastAlertId']);

$alertsQuery            =   $db->prepare("
SELECT *,(
  SELECT `display_name` FROM users
  WHERE id = a.sender_uid
) as `display_name`,(
  SELECT `username` FROM users
  WHERE id = a.sender_uid
) as `username`, (
  SELECT `title` FROM tracks
  WHERE id = a.tid
) as `track_title`, (
  SELECT `profile_img` FROM users
  WHERE id = a.sender_uid
) as `profile_img`, (
  SELECT `track_url` FROM tracks
  WHERE id = a.tid
) as `track_url` FROM alerts a
WHERE id > :aid AND recipient_uid = :uid AND isRead='1'
LIMIT 50
");
$alertsQuery->execute(array(
    ":aid"              =>  $last_id,
    ":uid"              =>  $_SESSION['uid']
));

$updateAlertsQuery      =   $db->prepare("UPDATE alerts SET isRead='2' WHERE id > :aid AND recipient_uid = :uid");
$updateAlertsQuery->execute(array(
    ":aid"              =>  $last_id,
    ":uid"              =>  $_SESSION['uid']
));

$alertsRow              =   $alertsQuery->fetchAll(PDO::FETCH_ASSOC);
$last_id                =   end($alertsRow);
$last_id                =   $last_id['id'];

$output['last_id']      =   $last_id;
$output['alerts']       =   $alertsRow;
dj($output);