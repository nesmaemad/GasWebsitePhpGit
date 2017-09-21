'use strict';

var reviews = angular.module('myApp.reviews', ['ui.router']);

reviews.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('reviews', {
        url          : '/mainPage',    
        templateUrl  : 'modules/reviews/reviews.php',
        controller   : 'reviewsCtrl'
  });

}]);


reviews.controller('reviewsCtrl',reviewsCtrl);
reviewsCtrl.$inject = ['$scope' , '$http' , '$state' , '$filter'];

function reviewsCtrl ($scope , $http , $state , $filter) {
  $scope.post_review_selected_volume  = "1";  
  $scope.post_review_selected_country = "1";
  $scope.reviews_volume               = "1";
  $scope.rating2                      = "2";
  $scope.reviews_city                 = {"name" : "Airdrie","province_name" : "Alberta" , "province_id" : "1"};


  $scope.init = function(){
      $scope.getReviews();
      $scope.getProvinces();
      $scope.getCompanies();
       
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
        console.log("inside getNumber "+num);
        var arr = [];
        for(var i = 1; i <= num; i++){
            arr.push(i);
        }
        console.log(arr);
        return arr;   
  };
  
  $scope.getReviews = function(){
     var province_id = $scope.reviews_city.province_id;
     var volume_id   = $scope.reviews_volume;
     $.ajax({
        type        : "GET",
        url         : "handler/reviewsHandler.php", // Location of the service
        data        : {"province_id" : province_id , "volume_id" : volume_id , "function_name" : "getReviews"}, //Data sent to server
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
    var reviewBox      = $('#post-review-box');
    var newReview      = $('#new-review');
    var openReviewBtn  = $('#open-review-box');
    var closeReviewBtn = $('#close-review-box');
    var ratingsField   = $('#ratings-hidden');
    var user_id        = $('#user_id');
    
    var params = {
        "country_id"      : $scope.post_review_selected_country,
        "province_id"     : $scope.post_review_selected_province.id,
        "volume_id"       : $scope.post_review_selected_volume,
        "company_id"      : $scope.selected_post_review_company.id,
        "user_id"         : user_id.val(),
        "price"           : $scope.post_review_price,              
        "review"          : $scope.post_review_comment,
        "rating"          : ratingsField.val(),
        "function_name"   : "postReview"
        
    }; 
    
    console.log("params inside post review");
    console.log(params);
    event.preventDefault();
    
    $.ajax({
        type        : "GET",
        url         : "handler/reviewsHandler.php", // Location of the service
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
      
  };
  
  $scope.changeProvincy = function(){
      $scope.getProvinces();
      $scope.getCompanies();
      
  };
  
  
  $scope.getCompanies = function(){
      console.log("insid getCompanies function");
      console.log($scope.post_review_selected_province);
     $.ajax({
        type        : "GET",
        url         : "handler/reviewsHandler.php", // Location of the service
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
            $scope.post_review_selected_province = $scope.provinces[0];
        }
    });      
  };
  
  $scope.updateReviews = function(){
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
            $scope.reviews_city = {"name" : single_object.name,"province_name" : single_object.province_name , "province_id" : single_object.province_id};
            $scope.getReviews();
            console.log($scope.reviews);
            $scope.$apply();
        }

       });
  };
  
  
  $scope.init();

};

