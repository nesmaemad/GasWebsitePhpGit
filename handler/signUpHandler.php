<?php


    include_once "db.php";           /* including the database */
    
    $get_function_name = $_GET['function_name'];

    if(isset($get_function_name) && $get_function_name == "getProvinces")
    {       
        getProvinces($conn);
    }else if(isset($get_function_name) && $get_function_name == "signUp"){
        signUp($conn);
    }

  
    function signUp($conn){
        $sql = "insert into user (email,first_name,last_name,address,phone,postal_zip,province_id,"
                . "country_id,password,user_name) values ( ? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $_GET['email'], $_GET['first_name'] , $_GET['last_name'],
                $_GET['address'] , $_GET['phone'] , $_GET['postal'] , $_GET['province'],
                $_GET['country'] , $_GET['password'] , $_GET['user_name']);
        $stmt->execute(); 

        echo "success";

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
            $province            = new \stdClass();
            $province->id        = $col1;
            $province->name      = $col2;
            $provinces[]         = $province; 
           

        }
        echo json_encode($provinces);

    }
    
