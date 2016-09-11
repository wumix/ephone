<!DOCTYPE html>
<html lang="en" ng-app="euphonizeApp">
<head>
    <base href="<?php echo $settings['site_dir']; ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $settings['site_name']; ?></title>
    <meta name="description" content="<?php echo $settings['site_desc']; ?>">
    <link rel="shortcut icon" href="assets/main/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/main/img/favicon.ico" type="image/x-icon">

    <!-- 3rd Party Libraries -->
    <link rel="stylesheet" type='text/css' href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:100,500,900,300,700,400'>
    <link rel="stylesheet" type='text/css' href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

    <!-- Libraries -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="assets/nprogress/ngprogress-lite.css">
    <link rel="stylesheet" type="text/css" href="assets/tagsinput/bootstrap-tagsinput.css">
    <link rel="stylesheet" type="text/css" href="assets/soundmanager/demo/bar-ui/css/bar-ui.css">
    <link rel="stylesheet" type="text/css" href="assets/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="assets/datepicker/angular-datepicker.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="assets/main/css/main.css">

    <?php
    if($settings['page_fade_animation'] == 1){
        ?><link rel="stylesheet" type="text/css" href="assets/main/css/animation.css"><?php
    }
    ?>
</head>
<body>
<div id="fb-root"></div>
<header>
    <?php include( 'top-nav.inc.php' ); ?>
</header>