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
        $volume_id   = $_GET['volume_id'];
        $city_id     = $_GET['city_id'];
        
        $sql = "select user.user_name , price , review , rating , time from review , user where review.user_id = user.id and"
                . " company_id = ? and review.province_id = ? and volume_id = ? and review.city_id = ?";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssss", $company_id , $province_id , $volume_id , $city_id);
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
        $sql = "insert into review (country_id,province_id,volume_id,company_id,user_id,price,review,rating,time,city_id)"
               . "values ( ? ,? ,? ,? ,? ,? ,? ,? ,? , ?)";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $_GET['country_id'] , $_GET['province_id'],$_GET['volume_id'],$_GET['company_id']
                ,$_GET['user_id'],$_GET['price'],$_GET['review'],$_GET['rating'],$time_stamp, $_GET['city_id'] );
        $stmt->execute(); 
        $stmt-> close();
        
        $users_sql = "select email , first_name from user , review where "
                . "review.user_id = user.id  and review.city_id = ? and user.id != ?";
        $users_stmt= $conn->prepare($users_sql);
        $users_stmt->bind_param("ss" , $_GET['city_id'] , $_GET['user_id'] );
        $users_stmt->execute(); 
        $users_stmt->store_result(); 
        $users_stmt->bind_result($col1,$col2 );
        while($users_stmt->fetch()){
            $msg = '

            Hello '.$col2.'
            A new Review has been added on propane companies in you region in the Resedential section

            Please check out the latest reviews.
            Thanks. '; // Our message above including the link

            // send email
            mail($col1,"New Gas Review",$msg);
        }
       
        
        $users_stmt-> close();
        echo "success";

    }
    
    function getReviews($conn){
        
         $reviews     = array();
         $province_id = $_GET["province_id"];
         $volume_id   = $_GET["volume_id"];
         $city_id     = $_GET["city_id"];

         $sql = "select company.name , count(review.company_id), MIN(price), company.id "
                 . " from company , review , province , volume where "
                 . "review.company_id = company.id  and review.province_id = province.id"
                 . " and review.volume_id = volume.id and province.id = ? and volume.id = ?"
                 . " and review.city_id = ?"
                 . " group by company.name";
         
        $price_sql = "select user.user_name , review.rating , review.id , review.review "
                . "from review , user  where company_id = ? and review.user_id = user.id and "
            . "review.province_id = ? and volume_id = ? and review.price = ? and review.city_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $province_id, $volume_id , $city_id);
            $stmt->execute(); 
            $stmt->store_result(); 
            $stmt->bind_result($col1,$col2,$col3, $col7   );
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
                    $price_stmt->bind_param("sssss", $col7 ,$province_id, $volume_id , $col3 , $city_id );
                    $price_stmt->execute();
                    $price_stmt->store_result();
                    $price_stmt->bind_result( $col4 ,$col5 , $col6 , $col8 );
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
        $sql          = "select id , country_id , name from company where province_id = ?  group by name";
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


