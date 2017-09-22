<?php

    include_once "db.php";           /* including the database */

    $get_function_name  = $_GET['function_name'];
    if(isset($get_function_name) && $get_function_name == "getReviews")
    {       
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
        $sql = "select user.user_name , price , review , rating from review , user where review.user_id = user.id and"
                . " company_id = ".$company_id." and review.province_id = ".$province_id." and volume_id = ".$volume_id;
        $result = $conn->query($sql) or die($conn->error);

        // output data of each row
        while($row = $result->fetch_assoc()) {
            $review                = new \stdClass();
            $review->user_name     =  $row["user_name"];
            $review->price         =  $row["price"];
            $review->review        =  $row["review"];
            $review->rating        =  $row["rating"];
            $reviews[]             =  $review;
        }

//        $stmt     = $conn->prepare($sql);
//        $stmt->bind_param("sss", $company_id , $province_id , $volume_id);
//        $stmt->execute(); 
//        $stmt->bind_result($col1,$col2,$col3,$col4 );
//        while($stmt->fetch()){
//            $review                = new \stdClass();
//            $review->user_name     =  $col1;
//            $review->price         =  $col2;
//            $review->review        =  $col3;
//            $review->rating        =  $col4;
//            $reviews[]             =  $review;
//        }
        echo json_encode($reviews);
        
    }
    function postReview($conn){
        $sql = "insert into review (country_id,province_id,volume_id,company_id,user_id,price,review,rating)"
               . "values ( ? ,? ,? ,? ,? ,? ,? ,?)";
        $stmt     = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $_GET['country_id'] , $_GET['province_id'],$_GET['volume_id'],$_GET['company_id']
                ,$_GET['user_id'],$_GET['price'],$_GET['review'],$_GET['rating']);
        $stmt->execute(); 
        $stmt-> close();
        echo "success";

    }
    
    function getReviews($conn){
        
         $reviews     = array();
         $province_id = $_GET["province_id"];
         $volume_id   = $_GET["volume_id"];
         

         $sql = "select company.name , count(review.company_id)  , review.price ,"
                 . "user.user_name , review.rating , review.id , company.id from company , review , province , user , volume where "
                 . "review.company_id = company.id and review.user_id = user.id and review.province_id = province.id"
                 . " and review.volume_id = volume.id and province.id = ? and volume.id = ? and "
                 . "review.price = (select MIN(review.price) from review where review.company_id = company.id)"
                 . " group by company.name";
      
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $province_id, $volume_id);
            $stmt->execute(); 
            $stmt->bind_result($col1,$col2,$col3,$col4 ,$col5 , $col6 , $col7 );
            while($stmt->fetch()){
                $review                = new \stdClass();
                $review->company_name  =  $col1;
                $review->reviews_count =  $col2;
                $review->price         =  $col3;
                $review->user_name     =  $col4;
                $review->rating        =  $col5;
                $review->id            =  $col6;
                $review->company_id    =  $col7;
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


