<?php 
    include 'includes/connection.php';
    include 'check_min.php';
    date_default_timezone_set("Asia/Taipei");
    session_start();
    if(empty($_SESSION)) echo "<script>alert('You are not logged in. Please login to continue.'); window.location='index.php';</script>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>eTLB -Electronic Trading Logbook</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->  
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href='assets/css/dataTables.bootstrap.min.css' rel='stylesheet' type='text/css'>
    <!--  Material Dashboard CSS    -->
    <link href="assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="assets/css/font-awesome.min" rel="stylesheet">
    <link href='assets/css/fonts.css' rel='stylesheet' type='text/css'>    

</head>
<style type="text/css">
    .hr_nomarg{
        margin: 0px;
    }
    .hr_nomarg2{
        margin: 5px 0px 0px 0px!important ;
    }
    .thead-primary{
        background: #9c27b0;
        color: #fff;
        
    }
    .thead-primary th{
        font-weight: bold!important;
    }
    .wrapper{
        background: linear-gradient(#ffe7e7f7, #f9dfb9);
    }
    .modal .modal-dialog {
        margin-top: 50px!important; 
    }
    .modal-color{
        background-color:orange;
        color:white;
        border-radius:5px 5px 0px 0px;
        padding-bottom:10px!important;
    }
    #hase , #hase1 {
        border-radius: 5px!important;
        cursor: pointer;
        transition: 0.3s;
    
    }

    #hase:hover, #hase1:hover {
        background-color: white;
        box-shadow: -1px 1px 20px 0px rgb(255, 255, 255), 0 6px 20px 0 rgba(0, 0, 0, 0.19)}

    /* The Modal (background) */
    .modal1 {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content1 {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Add Animation */
    .modal-content1 {    
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }
    

    * {
      box-sizing: border-box;

    }

    .row > .column {
      padding: 0 8px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    .column {
      float: left;
      width: 10%;
    }

    .mySlides, .mySlides1 {
      display: none;
    }

    .cursor {
      cursor: pointer
    }

    /* nextxen & previous buttons */
    .prev,
    .nextxen {
      display: block;
      z-index: 3;
      color: white;
      background-color: rgba(72, 72, 72, 0.47);
      font-size: 6vmin;
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -50px;
      color: white;
      font-weight: bold;
      font-size: 20px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
      -webkit-user-select: none;
    }


    /* Position the "nextxen button" to the right */
    .nextxen {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .nextxen:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      top: 60;
      background-color: #0000008f;

    }

    img {
      margin-bottom: -4px;
    }    

    img.hover-shadow {
      transition: 0.3s
    }

    .hover-shadow:hover {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
    }
    .sd{
      margin-bottom:10px; 
      box-shadow: 0 1px 10px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(115, 115, 115, 0.1);
      border:1px solid darkgrey;
    }
</style>
