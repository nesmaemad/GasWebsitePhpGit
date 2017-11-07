<?php

    include_once "db.php";           /* including the database */

    $get_function_name  = $_GET['function_name'];
    if(isset($get_function_name) && $get_function_name == "getReviews"){       
        getReviews($conn);
    }else if(isset($get_function_name) && $get_function_name == "getCompanies"){
        getCompanies($conn);
    }else if (isset($get_function_name) && $get_function_name === "postReview"){
        postReview($conn);
    }else if(isset($get_function_name) && $get_function_name === "getCompanyReviews"){
        getCompanyReviews($conn);
    }
    
    
    function getCompanyReviews($conn){
        $reviews     = array();
        $company_id  = $_GET['company_id'];
        $province_id = $_GET['province_id'];
        $tank_id     = $_GET['tank_id'];
        $city_id     = $_GET['city_id'];
        $sql = "select user.user_name , price , review , rating , time from bbq_review , user where bbq_review.user_id = user.id and"
                . " company_id = ? and bbq_review.province_id = ? and tank_id = ? and bbq_review.city_id = ?";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssss", $company_id , $province_id , $tank_id , $city_id);
        $stmt->execute(); 
        $stmt->bind_result($col1,$col2,$col3,$col4,$col5 );
        while($stmt->fetch()){
            $review                = new \stdClass();
            $review->user_name     =  $col1;
            $review->price         =  $col2;
            $review->review        =  $col3;
            $review->rating        =  $col4;
            $review->time          =  $col5;
            $reviews[]             =  $review;
        }
        echo json_encode($reviews);
        
    }

    
    function postReview($conn){
        $custome_company_check = $_GET['check_custome_company'];
        $company               = $_GET['company'];
        $country_id            = $_GET['country_id'];
        $province_id           = $_GET['province_id'];
        $city_id               = $_GET['city_id'];
        if($custome_company_check == "1"){
            //check if the company exists in the database if it is then continue else add ot to the database
            //then get its id and continue
            $check_company_sql  = "select id from bbq_company where name = ? and country_id = ? and province_id = ?";
            $check_company_stmt = $conn->prepare($check_company_sql);
            $check_company_stmt->bind_param("sss",$company , $country_id , $province_id );
            $check_company_stmt->execute();
            $check_company_stmt->store_result(); 
            if(!$check_company_stmt->fetch()){                
                $add_company_sql  = "insert into bbq_company (country_id , province_id , name) values (? , ? , ?)";
                $add_company_stmt = $conn->prepare($add_company_sql);
                $add_company_stmt->bind_param("sss",  $country_id , $province_id , $company);
                $add_company_stmt->execute();
                $add_company_stmt->store_result();
                $company = $conn->insert_id;
                echo "hereeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee no company exist ".$company; 
               // $add_company_stmt-> close();
            }
            
            
            $check_company_stmt-> close();
        }
        
        $date       = new DateTime();
        $time_stamp = $date->getTimestamp();
        $sql = "insert into bbq_review (country_id,province_id,tank_id,company_id,user_id,price,review,rating,time,city_id)"
               . "values ( ? ,? ,? ,? ,? ,? ,? ,? ,?,?)";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $country_id , $province_id,$_GET['tank_id'],$company
                ,$_GET['user_id'],$_GET['price'],$_GET['review'],$_GET['rating'],$time_stamp,$_GET['city_id']);
        $stmt->execute();
        $stmt->store_result(); 
        $stmt-> close();
        
        
        $users_sql = "select email , first_name from user , bbq_review where "
                . "bbq_review.user_id = user.id and bbq_review.city_id = ? and user.id != ?";
        $users_stmt     = $conn->prepare($users_sql);
        $users_stmt->bind_param("ss",$_GET['city_id'] , $_GET['user_id']);
        $users_stmt->execute(); 
        $users_stmt->store_result(); 
        $users_stmt->bind_result($col1,$col2 );
        while($users_stmt->fetch()){
            $msg = '

            Hello '.$col2.'
            A new Review has been added on propane companies in you region in the BBQ section

            Please check out the latest reviews.
            Thanks. '; // Our message above including the link

            // send email
            mail($col1,"New Gas Review",$msg);
        }
        echo "success";

    }
    
    function getReviews($conn){
        
         $reviews     = array();
         $province_id = $_GET["province_id"];
         $tank_id     = $_GET["tank_id"];
         $city_id     = $_GET["city_id"];

         $sql = "select bbq_company.name , count(bbq_review.company_id), MIN(price), bbq_company.id"
                 . " from bbq_company , bbq_review , province  , bbq_tank where "
                 . "bbq_review.company_id = bbq_company.id  and bbq_review.province_id = province.id"
                 . " and bbq_review.tank_id = bbq_tank.id and province.id = ? and bbq_tank.id = ?"
                 . " and bbq_review.city_id = ?"
                 . " group by bbq_company.name";
         
        $price_sql = "select user.user_name , bbq_review.rating , bbq_review.id , bbq_review.review"
                . " from bbq_review , user where bbq_review.user_id = user.id and company_id = ? and "
            . "bbq_review.province_id = ? and tank_id = ?  and bbq_review.price = ? and bbq_review.city_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $province_id, $tank_id , $city_id);
            $stmt->execute(); 
            $stmt->store_result(); 
            $stmt->bind_result($col1,$col2,$col3 ,$col7  );
            while($stmt->fetch()){
                $review                = new \stdClass();
                $review->company_name  =  $col1;
                $review->reviews_count =  $col2;
             //   $review->price         =  $col3;
             //  $review->user_name     =  $col4;
             //   $review->rating        =  $col5;
             //   $review->id            =  $col6;
                $review->company_id    =  $col7;
               // $review->review        =  $col8;
                if($price_stmt = $conn->prepare($price_sql)){
                    $price_stmt->bind_param("sssss", $col7 ,$province_id, $tank_id , $col3 , $city_id);
                    $price_stmt->execute();
                    $price_stmt->store_result();
                    $price_stmt->bind_result($col4 ,$col5 , $col6 , $col8);
                    while($price_stmt->fetch()){
                        $review->price         =  $col3;
                        $review->user_name     =  $col4;
                        $review->rating        =  $col5;
                        $review->id            =  $col6;
                        $review->review        =  $col8;
                    }

                    $price_stmt->close();
                }else{
                    echo $conn->error;
                }
                $reviews[]             =  $review;
                        
            }
            $stmt-> close();
         echo json_encode($reviews);
         
    }
    
    function getCompanies($conn){
        $companies    = array();
        $sql          = "select id , country_id , name from bbq_company where province_id = ? group by name";
        $province_id  = $_GET["province_id"];
        $stmt         = $conn->prepare($sql);
        $stmt->bind_param("s", $province_id);
        $stmt->execute(); 
         $stmt->bind_result($col1,$col2,$col3);
        while($row = $stmt->fetch()){
            $company             = new \stdClass();
            $company->id         = $col1;
            $company->country_id = $col2;
            $company->name       = $col3;
            $companies[]         = $company; 
           

        }
        $stmt-> close();
        echo json_encode($companies);
    }


