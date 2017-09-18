'use strict';

var reviews = angular.module('myApp.reviews', ['ui.router']);
signUp.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('reviews', {
        url          : '/mainPage',    
        templateUrl  : 'modules/reviews/reviews.php',
        controller   : 'reviewsCtrl'
  });

}]);


reviews.controller('reviewsCtrl',reviewsCtrl);
reviewsCtrl.$inject = ['$scope' , '$http' , '$state'];

function reviewsCtrl ($scope , $http , $state) {
  $scope.post_review_selected_volume  = "1";  
  $scope.post_review_selected_country = "1";
  $scope.reviews_volume               = "1";
  $scope.reviews_city                 = {"name" : "Airdrie","id" : "1",
                                         "province_name" : "Alberta" , "province_id" : "1"};
  $scope.init = function(){
      $scope.getReviews();
     // $scope.getProvinces();
     //  $scope.getCompanies();
      
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
            console.log(JSON.parse(data));
            $scope.reviews = JSON.parse(data);
        } ,
        error : function(error){
            console.log("error fetching companies");
        }
    });   
     
  };
//  
//  $scope.viewPrice = function(review_id){
//      var first_name = $('check_first_name').val();
//      console.log("inside viewPrice first_name ");
//      console.log(first_name);
//      console.log("review_id " + review_id);
//      if(first_name !== null){
//          $('#view_price_'+review_id).hide();
//          $('#show_price_'+review_id).show();
//          
//      }else{
//        swal(
//            'Oops...',
//            'Please signin before viewing price!',
//            'error'
//        );
//      }
//  };
//  
//  $("#post_form").submit(function(event) {
//    var reviewBox      = $('#post-review-box');
//    var newReview      = $('#new-review');
//    var openReviewBtn  = $('#open-review-box');
//    var closeReviewBtn = $('#close-review-box');
//    var ratingsField   = $('#ratings-hidden');
//    var user_id        = $('#user_id');
//    
//    var params = {
//        "country_id"      : $scope.post_review_selected_country,
//        "province_id"     : $scope.post_review_selected_province.id,
//        "volume_id"       : $scope.post_review_selected_volume,
//        "company_id"      : $scope.selected_post_review_company.id,
//        "user_id"         : user_id.val(),
//        "price"           : $scope.post_review_price,              
//        "review"          : $scope.post_review_comment,
//        "rating"          : ratingsField.val()
//        
//    }; 
//    
//    console.log("params inside post review");
//    console.log(params);
//    event.preventDefault();
//    
//    $.ajax({
//        type        : "POST",
//        url         : "PostReview", // Location of the service
//        data        : JSON.stringify(params), //Data sent to server
//        contentType : "application/json", // content type sent to server
//        crossDomain : true,
//        async       : false,
//        success: function(data, success) {
//            console.log("post review successfully");
//            console.log(data);
//  
//            location.reload()
//        },
//        error : function (jqXHR, textStatus, errorThrown) {
//            console.log("error in sign up");
//        }
//    });   
//     
//   });
//  
//  $scope.changeReviewsVolume = function(volume_id){
//      $scope.reviews_volume = volume_id;
//      console.log("volume has changed");
//      console.log($scope.reviews_volume);
//      
//  };
//  
//  $scope.changeProvincy = function(){
//      $scope.getProvinces();
//      $scope.getCompanies();
//      
//  };
//  
//  
//  $scope.getCompanies = function(){
//      console.log("insid getCompanies function");
//      console.log($scope.post_review_selected_province);
//     $.ajax({
//        type        : "GET",
//        url         : "GetCompanies", // Location of the service
//        data        : {"province_id" : $scope.post_review_selected_province.id}, //Data sent to server
//        contentType : "application/json", // content type sent to server
//        crossDomain : true,
//        async       : false,
//        success: function(data, success) {
//            console.log("success getting the companies");
//            $scope.post_review_companies = data;
//            $scope.selected_post_review_company = data[0];
//        } ,
//        error : function(error){
//            console.log("error fetching companies");
//        }
//    });      
//  };
//  
//  $scope.getProvinces = function(){
//     $.ajax({
//        type        : "GET",
//        url         : "GetProvinces", // Location of the service
//        data        : {"country_id" : $scope.post_review_selected_country}, //Data sent to server
//        contentType : "application/json", // content type sent to server
//        crossDomain : true,
//        async       : false,
//        success: function(data, success) {
//            console.log("success getting the provinces");
//            $scope.provinces = data;
//            $scope.post_review_selected_province = data[0];
//        }
//    });      
//  };
  
  $scope.init();

};





