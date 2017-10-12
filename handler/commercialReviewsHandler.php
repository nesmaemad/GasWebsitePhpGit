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
        $reviews                = array();
        $company_id             = $_GET['company_id'];
        $province_id            = $_GET['province_id'];
        $volume_id              = $_GET['volume_id'];
        $commercial_category_id = $_GET["commercial_category_id"];
        $sql = "select user.user_name , price , review , rating , time from commercial_review , user where commercial_review.user_id = user.id and"
                . " company_id = ? and commercial_review.province_id = ? and volume_id = ? and commercial_category_id = ?";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssss", $company_id , $province_id , $volume_id , $commercial_category_id);
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
        $date       = new DateTime();
        $time_stamp = $date->getTimestamp();
        
        $sql = "insert into commercial_review (country_id,province_id,volume_id,company_id,user_id,price,review,rating,time,commercial_category_id)"
               . "values ( ? ,? ,? ,? ,? ,? ,? ,? ,? , ?)";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $_GET['country_id'] , $_GET['province_id'],$_GET['volume_id'],$_GET['company_id']
                ,$_GET['user_id'],$_GET['price'],$_GET['review'],$_GET['rating'],$time_stamp , $_GET["commercial_category_id"] );
        $stmt->execute(); 
        $stmt-> close();
        echo "success";

    }
    
    function getReviews($conn){
        
         $reviews                = array();
         $province_id            = $_GET["province_id"];
         $volume_id              = $_GET["volume_id"];
         $commercial_category_id = $_GET["commercial_category_id"];

         $sql = "select company.name , count(commercial_review.company_id),"
                 . "user.user_name , commercial_review.rating , commercial_review.id , company.id , "
                 . "commercial_review.review from company , commercial_review , province , user , volume where "
                 . "commercial_review.company_id = company.id and commercial_review.user_id = user.id and commercial_review.province_id = province.id"
                 . " and commercial_review.volume_id = commercial_review.id and province.id = ? and commercial_review.id = ? and commercial_category_id = ?"
                 . " group by company.name";
         
        $price_sql = "select MIN(price) from commercial_review where company_id = ? and "
            . "province_id = ? and volume_id = ? and commercial_category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $province_id, $volume_id , $commercial_category_id);
            $stmt->execute(); 
            $stmt->store_result(); 
            $stmt->bind_result($col1,$col2,$col4 ,$col5 , $col6 , $col7 , $col8 );
            while($stmt->fetch()){
                $review                = new \stdClass();
                $review->company_name  =  $col1;
                $review->reviews_count =  $col2;
             //   $review->price         =  $col3;
                $review->user_name     =  $col4;
                $review->rating        =  $col5;
                $review->id            =  $col6;
                $review->company_id    =  $col7;
                $review->review        =  $col8;
                if($price_stmt = $conn->prepare($price_sql)){
                    $price_stmt->bind_param("ssss", $col7 ,$province_id, $volume_id , $commercial_category_id);
                    $price_stmt->execute();
                    $price_stmt->store_result();
                    $price_stmt->bind_result($price_col1);
                    while($price_stmt->fetch()){
                        $review->price = $price_col1;
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
        $sql          = "select id , country_id , name from company where province_id = ?";
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


