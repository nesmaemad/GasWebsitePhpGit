<?php

    include_once "db.php";           /* including the database */
    session_start();       /* starting the session */

    
    $var = $_GET['function_name'];

    if(isset($var))
    {       
        getReviews($conn);
    }

    function postReview(){
        echo "inside postReview in ReviewsHandler";
        $sql = "insert into review (";
        $parameterIndex = 1;
        foreach($_POST as $k => $v) {
            if(strpos($k, 'function_name') !== 0) {
                 echo "$k = $v";
                 $sql.= $k;
                 $parameterIndex++;
                 if($parameterIndex <= 8){
                     $sql.= ",";
                 }
            }
        }

        $sql .= ") values ( ? ,? ,? ,? ,? ,? ,? ,?)";

        $parameterIndex = 1;
        $stmt = $conn->prepare($sql);
        $a_params[] = "ssssssss";
        foreach($_POST as $k => $v) {
            if(strpos($k, 'function_name') !== 0) {
                $a_params[] = &$v;

            }
        }
        call_user_func_array(array($stmt, 'bind_param'), $a_params);
        $stmt->execute(); 
        return "success";

    }
    
    function getReviews($conn){
        
         $reviews     = array();
         $province_id = $_GET["province_id"];
         $volume_id   = $_GET["volume_id"];
         

         $sql = "select company.name , count(review.company_id)  , MIN(review.price) ,"
                 . "user.user_name , review.rating , review.id from company , review , province , user , volume where "
                 . "review.company_id = company.id and review.user_id = user.id and review.province_id = province.id"
                 . " and review.volume_id = volume.id and province.id = ? and volume.id = ?"
                 . " group by company.name";
      
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $province_id, $volume_id);
            $stmt->execute(); 
            $stmt->bind_result($col1,$col2,$col3,$col4 ,$col5 , $col6 );
            while($stmt->fetch()){
                $review                = new \stdClass();
                $review->company_name  =  $col1;
                $review->reviews_count =  $col2;
                $review->price         =  $col3;
                $review->user_name     =  $col4;
                $review->rating        =  $col5;
                $review->id            =  $col6;
                $reviews[]             =  $review;
            }
         echo json_encode($reviews);
         
    }
    
    function getCompanies(){
        $companies    = array();
        $sql          = "select id , country_id , name from company where province_id = ?";
        $province_id  = $_GET["province_id"];
        $stmt         = $conn->prepare($sql);
        $stmt->bind_param("s", $province_id);
        $stmt->execute(); 
        $stmt->execute(); 
        while($row = $stmt->fetch()){
            array_push($companies, $row);

        }
        return $companies;
    }


