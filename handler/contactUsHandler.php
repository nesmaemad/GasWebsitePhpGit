<?php


    include_once "db.php";           /* including the database */

    $get_function_name = $_GET['function_name'];
    if(isset($get_function_name) && $get_function_name == "contactUs"){
        contactUs($conn);
    }
    

  
    function contactUs($conn){

        $msg = '

        A Contact Request Has Received!
        '.$_GET['name'].' has sent a message saying:
        '.$_GET['message'].'
        He/She has provided these contact information to reach him/her:
        Email : '.$_GET['email'].'
        Phone Number : '.$_GET['phone'].''
        . '';
        // send email
        mail("nesma.emad45@gmail.com",$_GET['subject'],$msg);
        echo "success";

    }
    

    
