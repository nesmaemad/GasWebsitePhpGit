<?php

    include_once "db.php";           /* including the database */
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $get_function_name = $_GET['function_name'];
        if(isset($get_function_name) && $get_function_name == "signIn")
        {       
            signIn($conn);
        }
    }

    function signIn($conn){

            $email    = $_GET["email"];
            $password = $_GET["password"];
            $sql      = "select id , first_name , last_name , user_name , province_id , country_id , active"
                        . " from user where email = ? and password = ?";
            $stmt     = $conn->prepare($sql);
            $stmt->bind_param("ss", $email , $password);
            $stmt->execute(); 
            $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6 , $col7);
            $sigin_result             = new \stdClass();
            if($row = $stmt->fetch()){
                if($col7 == "0"){
                    echo "confirm";
                }else{
                    setcookie("id", $col1   , 0, '/');
                    setcookie("first_name"  , $col2, 0, '/');
                    setcookie("last_name"   , $col3, 0, '/');
                    setcookie("user_name"   , $col4, 0, '/');
                    setcookie("province_id" , $col5, 0, '/');
                    setcookie("country_id"  , $col6, 0, '/');
                    setcookie("email"       , $email, 0, '/');

                    echo $col2;
                }
            }else{
                echo "failed";
            }
            $stmt-> close();
         
    }
    
    

