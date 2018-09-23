<?php
    session_start();    //start the sesssion

    session_unset();    //Unset thE data

    session_destroy();  //destroy the session

    header('location:index.php');

    exit();