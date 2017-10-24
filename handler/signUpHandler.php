<?php


    include_once "db.php";           /* including the database */
    
    
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

    // Verify data
        $email = $_GET['email']; // Set email variable
        $hash = $_GET['hash']; // Set hash variable


        $sql      = "SELECT email, hash, active FROM user WHERE email= ? AND hash= ? AND active=0";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ss", $email , $hash);
        $stmt->execute(); 
        
        if($row = $stmt->fetch()){
            $stmt->close();

            $stmt_update   = $conn->prepare("UPDATE user SET active= 1 WHERE email= ? AND hash= ? AND active= 0");
            $stmt_update->bind_param("ss", $email , $hash);
            $stmt_update->execute(); 
   
           
        }
        header("Location: http://localhost/GasWebsitePhpGit/index.php");
        exit;
    }else{
        $get_function_name = $_GET['function_name'];
        if(isset($get_function_name) && $get_function_name == "getProvinces")
        {       
            getProvinces($conn);
        }else if(isset($get_function_name) && $get_function_name == "signUp"){
            signUp($conn);
        }
    }



  
    function signUp($conn){
        $hash = md5( rand(0,1000) );
        $check_sql = "select id from user where email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $_GET['email']);
        $check_stmt->execute(); 
        if($check_stmt->fetch()){
            echo "exist";
        }else{
            $sql = "insert into user (email,first_name,last_name,address,phone,postal_zip,province_id,"
             . "country_id,password,user_name,hash) values ( ? ,? ,? ,? ,? ,? ,? ,? ,? ,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $_GET['email'], $_GET['first_name'] , $_GET['last_name'],
                    $_GET['address'] , $_GET['phone'] , $_GET['postal'] , $_GET['province'],
                    $_GET['country'] , $_GET['password'] , $_GET['user_name'],$hash);
            $stmt->execute(); 
            $msg = '

            Thanks for signing up!
            Your account has been created, you can login after you have activated your account by pressing the url below.

            Please click this link to activate your account:
            http://superiorchoicemarketing.com/Gas/handler/signUpHandler.php?email='.$_GET['email'].'&hash='.$hash.'

            '; // Our message above including the link

            // send email
            mail($_GET['email'],"Confirmation",$msg);
            $stmt-> close();
            echo "success"; 
        }
        


    }
    
    function getProvinces($conn){
        $country_id         = $_GET["country_id"];
        $provinces          = array();
        $sql                = "select id , name from province where country_id = ?";
        $stmt               = $conn->prepare($sql);
        $stmt->bind_param("s", $country_id);
        $stmt->execute(); 
        $stmt->bind_result($col1,$col2);
        while($row = $stmt->fetch()){
            $province             = new \stdClass();
            $province->id         = $col1;
            $province->name       = $col2;
            $province->country_id = $country_id;
            $provinces[]          = $province; 
           

        }
        $stmt-> close();
        echo json_encode($provinces);

    }
    
