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
        setcookie("email" , $email, 0, '/');
       //  header("Location: http://localhost/GasWebsitePhpGit/index.php#!/confirmationPage");
        header("Location: http://superiorchoicemarketing.com/Gas/index.php#!/confirmationPage");
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
        }else if(isset($get_function_name) && $get_function_name == "getUserData"){
            getUserData($conn);
        }else if(isset($get_function_name) && $get_function_name == "updateUserData"){
            updateUserData($conn);
        }
    }

    function updateUserData($conn){
        $check_sql = "select id from user where email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $_GET['email']);
        $check_stmt->execute(); 
        $check_stmt->store_result(); 
        if($check_stmt->fetch() && $_GET['email'] != $_GET['init_email']){
            echo "exist";
        }else{
            $check_user_sql = "select id from user where user_name = ?";
            $check_user_stmt = $conn->prepare($check_user_sql);
            $check_user_stmt->bind_param("s", $_GET['user_name']);
            $check_user_stmt->execute(); 
            $check_user_stmt->store_result();
            if($check_user_stmt->fetch() && $_GET['user_name'] != $_GET['init_user_name']){
                echo "user_exist";
            }else{
                $sql = "update user set email = ?,first_name = ?,last_name = ?,address = ?,phone = ?,"
                        . "postal_zip = ?,province_id = ?,"
                 . "country_id = ?,password = ?,user_name = ?,city_id = ? where id = ?";
                $stmt = $conn->prepare($sql);
                if(! $stmt){
                    echo $conn->error;
                }
                $stmt->bind_param("ssssssssssss", $_GET['email'], $_GET['first_name'] , $_GET['last_name'],
                        $_GET['address'] , $_GET['phone'] , $_GET['postal'] , $_GET['province'],
                        $_GET['country'] , $_GET['password'] , $_GET['user_name'] , $_GET['city_id'] , $_GET['user_id']);
                if(! $stmt){
                    echo $stmt->error;
                }
                if( ! $stmt->execute()){
                    echo $stmt->error;
                }
                $stmt-> close();
                echo "success"; 
            }
        }
        
    }

  
    function signUp($conn){
        $hash = md5( rand(0,1000) );
        $check_sql = "select id from user where email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $_GET['email']);
        $check_stmt->execute(); 
        $check_stmt->store_result(); 
        if($check_stmt->fetch()){
            echo "exist";
        }else{
            $check_user_sql = "select id from user where user_name = ?";
            $check_user_stmt = $conn->prepare($check_user_sql);
            $check_user_stmt->bind_param("s", $_GET['user_name']);
            $check_user_stmt->execute(); 
            $check_user_stmt->store_result();
            if($check_user_stmt->fetch()){
                echo "user_exist";
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

                To finish setting up your Local Propane Prices Account, we just need to make sure this email address is yours.

                To verify your email address click this link:
                http://superiorchoicemarketing.com/Gas/handler/signUpHandler.php?email='.$_GET['email'].'&hash='.$hash.'

                If you didn\'t request this verification, you can safely ignore this email. Someone else might have typed your email address by mistake.
                Thanks,
                Local Propane Prices team
                '; // Our message above including the link

                // send email
    //            $headers   = 'MIME-Version: 1.0' . "\r\n";
    //            $headers  .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //            mail($_GET['email'],"Confirmation",$msg , $headers);
                mail($_GET['email'],"Verify your email address",$msg );
                $stmt-> close();
                echo "success"; 
            }
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
    
    function getUserData($conn){
        $email              = $_GET["email"];
        $sql                = "select id , first_name , last_name , user_name , address , phone , postal_zip"
                            . ", province_id , country_id , password , city_id"
                            . " from user where email = ?";
        $stmt               = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute(); 
        $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11);
        $user  = new \stdClass();
        if($row = $stmt->fetch()){            
            $user->id          = $col1;
            $user->first_name  = $col2;
            $user->last_name   = $col3;
            $user->user_name   = $col4;
            $user->address     = $col5;
            $user->phone       = $col6;
            $user->postal_zip  = $col7;
            $user->province_id = $col8;
            $user->country_id  = $col9;
            $user->password    = $col10;
            $user->city_id     = $col11;
            $user->email       = $email;
           
        }
        $stmt-> close();
        echo json_encode($user);

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
    
