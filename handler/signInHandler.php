<?php

    include_once "db.php";           /* including the database */
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['type']) && !empty($_GET['type'])){

    // Verify data
        $email = $_GET['email']; // Set email variable

        setcookie("email" , $email, 0, '/');
         header("Location: http://localhost/GasWebsitePhpGit/index.php#!/resetPassword");
       // header("Location: http://superiorchoicemarketing.com/Gas/index.php#!/resetPassword");
        exit;
    }else{
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $get_function_name = $_GET['function_name'];
            if(isset($get_function_name) && $get_function_name == "signIn")
            {       
                signIn($conn);
            }else if(isset($get_function_name) && $get_function_name == "signInConfirmation"){
                signInConfirmation($conn);
            }else if(isset($get_function_name) && $get_function_name == "forgetPassword"){
                forgetPassword($conn);
            }else if(isset($get_function_name) && $get_function_name == "resetPassword"){
                resetPassword($conn);
            }
        }
    }
    
    function resetPassword($conn){
        $email    = $_GET["email"];
        $password = $_GET["password"];
        $sql      = "update user set password = ? where email = ?";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ss",$password , $email);
        $stmt->execute(); 
        echo 'success';
    }
    
    function forgetPassword($conn){
        $email    = $_GET["email"];

        $sql      = "select first_name from user where email = ?";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute(); 
        $stmt->bind_result($col1);
        if($row = $stmt->fetch()){
            $msg = '
             Hello '.$col1.'
             To reset your password click the link below and you will be redirected to a secure site from which you can set a new password.

             http://superiorchoicemarketing.com/Gas/handler/signInHandler.php?email='.$_GET['email'].'&type=reset

             Thanks,
             Local Propane Prices team
             '; // Our message above including the link

             mail($_GET['email'],"Reset Your Password",$msg );
            echo 'success';
        }else{
            echo 'failed';
        }
    }
    
    function signInConfirmation($conn){

            $email    = $_GET["email"];
     
            $sql      = "select id , first_name , last_name , user_name , province_id , country_id , active , city_id"
                        . " from user where email = ?";
            $stmt     = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6 , $col7 , $col8);
            $sigin_result             = new \stdClass();
            if($row = $stmt->fetch()){
                    setcookie("id", $col1   , 0, '/');
                    setcookie("first_name"  , $col2, 0, '/');
                    setcookie("last_name"   , $col3, 0, '/');
                    setcookie("user_name"   , $col4, 0, '/');
                    setcookie("province_id" , $col5, 0, '/');
                    setcookie("country_id"  , $col6, 0, '/');
                    setcookie("email"       , $email, 0, '/');
                    setcookie("city_id"     , $col8, 0, '/');
                    $user                = new \stdClass();
                    $user->user_name     =  $col4;
                    $user->city_id       =  $col8;      
                    echo json_encode($user);

            }else{
                echo "failed";
            }
            $stmt-> close();
         
    }

    function signIn($conn){

            $email    = $_GET["email"];
            $password = $_GET["password"];
            $sql      = "select id , first_name , last_name , user_name , province_id , country_id , active , city_id , closed"
                        . " from user where email = ? and password = ?";
            $stmt     = $conn->prepare($sql);
            $stmt->bind_param("ss", $email , $password);
            $stmt->execute(); 
            $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6 , $col7 , $col8 , $col9);
            $sigin_result             = new \stdClass();
            if($row = $stmt->fetch()){
                if($col7 == "0"){
                    echo "confirm";
                }else if($col9 == "1"){
                    echo "closed";
                }else{
                    setcookie("id", $col1   , 0, '/');
                    setcookie("first_name"  , $col2, 0, '/');
                    setcookie("last_name"   , $col3, 0, '/');
                    setcookie("user_name"   , $col4, 0, '/');
                    setcookie("province_id" , $col5, 0, '/');
                    setcookie("country_id"  , $col6, 0, '/');
                    setcookie("email"       , $email, 0, '/');
                    setcookie("city_id"     , $col8, 0, '/');
                    $user                = new \stdClass();
                    $user->user_name     =  $col4;
                    $user->city_id       =  $col8;      
                    echo json_encode($user);
                  //  echo $col4;
                }
            }else{
                echo "failed";
            }
            $stmt-> close();
         
    }
    
    

