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
        header("Location: http://superiorchoicemarketing.com/Gas/index.php#!/mainPage");
        exit;
    }else{
        $get_function_name = $_GET['function_name'];
        if(isset($get_function_name) && $get_function_name == "getProvinces")
        {       
            getProvinces($conn);
        }else if(isset($get_function_name) && $get_function_name == "signUp"){
            signUp($conn);
        }else if(isset($get_function_name) && $get_function_name == "getCities"){
            getCities($conn);
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
             . "country_id,password,user_name,hash,city_id) values ( ? ,? ,? ,? ,? ,? ,? ,? ,? ,?,? , ?)";
            $stmt = $conn->prepare($sql);
            if(! $stmt){
                echo $conn->error;
            }
            $stmt->bind_param("ssssssssssss", $_GET['email'], $_GET['first_name'] , $_GET['last_name'],
                    $_GET['address'] , $_GET['phone'] , $_GET['postal'] , $_GET['province'],
                    $_GET['country'] , $_GET['password'] , $_GET['user_name'],$hash , $_GET['city_id']);
            if(! $stmt){
                echo $stmt->error;
            }
            if( ! $stmt->execute()){
                echo $stmt->error;
            }
            $msg = '

            Thanks for signing up!
            Your account has been created, you can login after you have activated your account by pressing the url below.

            Please click this link to activate your account:
            http://superiorchoicemarketing.com/Gas/handler/signUpHandler.php?email='.$_GET['email'].'&hash='.$hash.'

            '; // Our message above including the link

            // send email
//            $headers   = 'MIME-Version: 1.0' . "\r\n";
//            $headers  .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//            mail($_GET['email'],"Confirmation",$msg , $headers);
            mail($_GET['email'],"Confirmation",$msg );
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
    
    function getCities($conn){
        $province_id        = $_GET["province_id"];
        $cities             = array();
        $sql                = "select id , name , type , country_id from "
                . "city where province_id = ?";
        $stmt               = $conn->prepare($sql);
        $stmt->bind_param("s", $province_id);
        $stmt->execute(); 
        $stmt->bind_result($col1,$col2,$col3,$col4);
        while($row = $stmt->fetch()){
            $city              = new \stdClass();
            $city->id          = $col1;
            $city->name        = $col2;
            $city->type        = $col3;
            $city->country_id  = $col4;
            $city->province_id = $province_id;
            $cities[]          = $city; 
          
        }
        $stmt-> close();
        echo json_encode($cities);

    }
    
