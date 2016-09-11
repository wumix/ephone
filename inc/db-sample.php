<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/7/2015
 * Time: 2:25 PM
 */
ob_start();
session_start();

try {
    $db = new PDO('mysql:host=PHOHOST;dbname=PHODBNAME', 'PHOUSER', 'PHOPASS');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$settings           =   $db->prepare("SELECT * FROM settings WHERE id='1'");
$settings->execute();
$settings           =   $settings->fetch(PDO::FETCH_ASSOC);