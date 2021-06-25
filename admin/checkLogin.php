<?php
    session_start();
    if(!$_SESSION['userid']){
        header("Location:./index.php");
        exit();
    }