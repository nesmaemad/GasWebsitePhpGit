'use strict';

var commercial = angular.module('myApp.commercial', ['ui.router' , 'ngCookies']);

commercial.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('commercial', {
        url          : '/commercial',    
        templateUrl  : 'modules/commercial/commercial.php',
        controller   : 'commercialCtrl'
  });

}]);


commercial.controller('commercialCtrl',commercialCtrl);
commercialCtrl.$inject = ['$rootScope' , '$scope' , '$http' , '$state' , '$filter' , '$cookies'];

function commercialCtrl ($rootScope , $scope , $http , $state , $filter , $cookies) {
  $cookies.put("last_state" , "commercial"); 
  $scope.commercial_category_id       = $cookies.get("commercial_category_id");
  $scope.commercial_category_name     = $cookies.get("commercial_category_name");
  console.log("commerciaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaal");
  console.log($scope.commercial_category_id );
  console.log($scope.commercial_category_name );

  $scope.post_review_selected_volume  = "1"; 
  if($cookies.get("has_reviews_volume") == "true"){
     $scope.reviews_volume            = $cookies.get("landing_reviews_volume"); 
  }else{
      if($scope.commercial_category_id  == "1" || $scope.commercial_category_id  == "4"){
          $scope.reviews_volume = "1"; 
      }else if($scope.commercial_category_id  == "2"){
          $scope.reviews_volume = "6";
      }else if($scope.commercial_category_id  == "3"){
          $scope.reviews_volume = "12";
      }
     
  }
  
  $scope.rating2                      = "2";
  if($cookies.get("has_reviews_city") == "true"){
      console.log("root scope has landing reviews city");
      $scope.reviews_city = $cookies.getObject("landing_reviews_city");
  }else{
           //TODO change it to take this object from cookies
      $scope.reviews_city   =   {
                                    "province_id": "1",
                                    "name": "Airdrie",
                                    "id": "1",
                                    "region": "Canada-Alberta",
                                    "type": "city",
                                    "country_id": "1",
                                    "province_name": "Alberta"
                                  };
  }
  $scope.country_id                   = $scope.reviews_city.country_id;  
 
  $scope.post_review_selected_country = $scope.reviews_city.country_id;


  $scope.init = function(){
      $scope.getReviews();
      $scope.getProvinces();
      $scope.getCompanies();
      $scope.getCities();
      $scope.getQuickSearchProvinces();
       
  };
  
   $scope.changeCity = function(){
      $scope.getCities();
  };
  
   $scope.getCities = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"province_id" : $scope.post_review_selected_province.id , "function_name" : "getCities"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the provinces");
            $scope.cities = JSON.parse(data);
            var city = $filter('filter')( $scope.cities, function (d) {
                return d.id == $scope.reviews_city.id;
            })[0];
            if(city === undefined){
                $scope.post_review_selected_city = $scope.cities[0];
            }else{
                $scope.post_review_selected_city = city;
            }   
          //  $scope.post_review_selected_city = $scope.cities[0];
        }
    });      
  };
  
  $scope.loadCitiesTownsJson = function(callback) {   

    var xobj = new XMLHttpRequest();
        xobj.overrideMimeType("application/json");
        xobj.open('GET', 'resources/canada_america.json', true); // Replace 'my_data' with the path to your file
        xobj.onreadystatechange = function () {
              if (xobj.readyState == 4 && xobj.status == "200") {
                // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
                callback(xobj.responseText);
              }
        };
    xobj.send(null);  
  };
 
  
  $scope.getNumber = function(num) {
        var arr = [];
        for(var i = 1; i <= num; i++){
            arr.push(i);
        }
        
        return arr;   
  };
  
  $scope.getReviews = function(){
     var province_id            = $scope.reviews_city.province_id;
     var volume_id              = $scope.reviews_volume;
     var commercial_category_id = $scope.commercial_category_id;
     var city_id                = $scope.reviews_city.id;
     
     var params                 = { "province_id"            : province_id , 
                                    "volume_id"              : volume_id ,
                                    "commercial_category_id" : commercial_category_id,
                                    "city_id"                : city_id,
                                    "function_name"          : "getReviews"};
     console.log("inside getReviews");
     console.log(params);
     $.ajax({
        type        : "GET",
        url         : "handler/commercialReviewsHandler.php", // Location of the service
        data        : params, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the reviews");
            console.log(data);
            console.log(JSON.parse(data));
            $scope.reviews = JSON.parse(data);
        } ,
        error : function(error){
            console.log("error fetching companies");
        }
    });   
     
  };

  
  $("#post_form").submit(function(event) {
    var reviewBox              = $('#post-review-box');
    var newReview              = $('#new-review');
    var openReviewBtn          = $('#open-review-box');
    var closeReviewBtn         = $('#close-review-box');
    var ratingsField           = $('#ratings-hidden');
    var user_id                = $('#user_id');
    var commercial_category_id = $scope.commercial_category_id;
    
    var params = {
        "country_id"             : $scope.post_review_selected_country,
        "province_id"            : $scope.post_review_selected_province.id,
        "volume_id"              : $scope.post_review_selected_volume,
        "city_id"                : $scope.post_review_selected_city.id,
        "company_id"             : $scope.selected_post_review_company.id,
        "user_id"                : user_id.val(),
        "price"                  : $scope.post_review_price,              
        "review"                 : $scope.post_review_comment,
        "rating"                 : ratingsField.val(),
        "commercial_category_id" : commercial_category_id,
        "function_name"          : "postReview"
        
    }; 
    
    console.log("params inside post review");
    console.log(params);
    event.preventDefault();
    
    $.ajax({
        type        : "GET",
        url         : "handler/commercialReviewsHandler.php", // Location of the service
        data        : params, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("post review successfully");
            console.log(data);
            location.reload();
        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign up");
        }
    });   
     
   });
  
  $scope.changeReviewsVolume = function(volume_id){
      $scope.reviews_volume = volume_id;
      console.log("volume has changed");
      console.log($scope.reviews_volume);
      $scope.getReviews();
      
  };
  
  $scope.changeProvincy = function(){
      $scope.getProvinces();
      $scope.getCompanies();
      
  };
  
  

  var prev_company_id = "";
  $scope.getCompanyReviews = function(company_id){
      console.log("insid getCompanyReviews function");
     //optimization check the class before calling the backend, only call in case of the existance of class hidden
        $("#comapny_review_menu_"+prev_company_id).addClass('hidden-company-reviews');
        console.log(prev_company_id);
        console.log(company_id);
        var commercial_category_id = $scope.commercial_category_id;
        if(prev_company_id != company_id){
            $.ajax({
                type        : "GET",
                url         : "handler/commercialReviewsHandler.php", // Location of the service
                data        : {"company_id"              : company_id , 
                               "province_id"             : $scope.reviews_city.province_id ,
                               "city_id"                 : $scope.reviews_city.id ,
                               "volume_id"               : $scope.reviews_volume , 
                               "commercial_category_id"  : commercial_category_id,
                               "function_name"           : "getCompanyReviews"}, //Data sent to server
                contentType : "application/json", // content type sent to server
                crossDomain : true,
                async       : false,
                success: function(data, success) {
                    console.log("success getting the companies reviews");
                    $scope.company_reviews   =  JSON.parse(data);
                    console.log($scope.company_reviews);
                    $("#comapny_review_menu_"+company_id).toggleClass('hidden-company-reviews');
                    prev_company_id = company_id;
                } ,
                error : function(error){
                    console.log("error fetching companies");
                }
            }); 
        }else{
            console.log("reseting the prev_company_id");
            prev_company_id = "";
        }   
  };
  
  $scope.getCompanies = function(){
      console.log("insid getCompanies function");
      console.log($scope.post_review_selected_province);
     $.ajax({
        type        : "GET",
        url         : "handler/commercialReviewsHandler.php", // Location of the service
        data        : {"province_id" : $scope.post_review_selected_province.id , "function_name" : "getCompanies"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the companies");
            $scope.post_review_companies        =  JSON.parse(data);
            $scope.selected_post_review_company =  $scope.post_review_companies[0];
        } ,
        error : function(error){
            console.log("error fetching companies");
        }
    });      
  };
  
  $scope.getProvinces = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"country_id" : $scope.post_review_selected_country , "function_name" : "getProvinces"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the provinces");
            $scope.provinces = JSON.parse(data);
            var province = $filter('filter')( $scope.provinces, function (d) {
                return d.id == $scope.reviews_city.province_id;
            })[0];
             $scope.post_review_selected_province = province;
           // $scope.post_review_selected_province = $scope.provinces[0];
        }
    });      
  };
  
    $scope.getQuickSearchProvinces = function(){
     var country_id = $scope.country_id;
     if($rootScope.has_country_id){
         country_id        = $rootScope.country_id;
         $scope.country_id = $rootScope.country_id;
     }
     console.log("inside getQuickSearchProvinces");
     console.log(country_id);
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"country_id" : country_id , "function_name" : "getProvinces"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the quickSearchProvinces");
            $scope.quickSearchProvinces = JSON.parse(data);
        }
    });      
  };
  
  $scope.getProvinceReviews = function(province){
        console.log("inside getProvinceReviews");
        $scope.reviews_city = {"name" : province.name,"province_name" : province.name , "province_id" : province.id};
        $scope.getReviews();
        console.log($scope.reviews);
  };
  
  $scope.updateReviewsBySearch = function(){
        console.log("updaaaaaaaaaaaaaaaaaaaaaaaaaaaaate");
        console.log($('#search_input').val());
        $scope.loadCitiesTownsJson(function(response) {
        var actual_JSON = JSON.parse(response);
        var single_object = $filter('filter')(actual_JSON.Canada, function (d) {
            return d.name === $('#search_input').val();
        })[0];
        if(single_object === undefined){
            single_object = $filter('filter')(actual_JSON.America, function (d) {
                return d.name === $('#search_input').val();
            })[0];
        }
        
        if(single_object === undefined){
            swal(
                'Oops...',
                'City or town does not exist!',
                'error'
            );
        }else{
            console.log('single object is hereeee ');
            console.log(single_object);
            $scope.reviews_city = {"name" : single_object.name,
                "province_name" : single_object.province_name , 
                "province_id" : single_object.province_id,
                "id" : single_object.id,
                "country_id" : single_object.country_id};
            $scope.getProvinces();
            $scope.getCities();
            
            $cookies.put("has_reviews_city" , "true");
            $cookies.putObject("landing_reviews_city" , $scope.reviews_city);
            $scope.getReviews();
            console.log($scope.reviews);
            $scope.$apply();
        }

       });
  };
  
  
  $scope.init();

};

