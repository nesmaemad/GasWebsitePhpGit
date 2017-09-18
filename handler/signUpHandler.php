<?php


    include_once "db.php";           /* including the database */
    
    $get_function_name = $_GET['function_name'];

    if(isset($get_function_name) && $get_function_name == "getProvinces")
    {       
        getProvinces($conn);
    }

  
//    function signUp(){
//
//            $sql = "insert into user (";
//            
//            $parameterIndex = 1;
//            for (String key : params.keySet()) {
//                 String value = String.valueOf(params.get(key));
//                 System.out.println("key: "+ key + " value: " + value);
//                 sql+= sign_up_colunms_names.get(key);
//                 parameterIndex++;
//                 if(parameterIndex <= 10){
//                     sql+= ",";
//                 }
//             }
//            sql += ") values ( ? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
//            System.out.println(sql);
//            parameterIndex = 1;
//            PreparedStatement stmt = connection.prepareStatement(sql);
//            for (String key : params.keySet()) {
//                 String value = String.valueOf(params.get(key));
//                 System.out.println("key: "+ key + " value: " + value);
//                 stmt.setString(parameterIndex, value);
//                 parameterIndex++;
//             }
//
//    }
    
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
    
