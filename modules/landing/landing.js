'use strict';

var landing = angular.module('myApp.landing', ['ui.router']);

landing.config(['$stateProvider', function($stateProvider) {
    $stateProvider.state('landing', {
        url          : '/landing',    
        templateUrl  : 'modules/landing/landing.php',
        controller   : 'landingCtrl'
  });

}]);


landing.controller('landingCtrl',landingCtrl);
landingCtrl.$inject = ['$rootScope' , '$scope' , '$http' , '$state' , '$filter'];

function landingCtrl ($rootScope ,$scope , $http , $state , $filter) {
  $scope.landing_selected_volume = "1";
  
  $scope.getProvinces = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"country_id" : "1" , "function_name" : "getProvinces"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the provinces");
            $scope.provinces = JSON.parse(data);
        }
    });      
  };
  
    $scope.getStates = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"country_id" : "2" , "function_name" : "getProvinces"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("success getting the provinces");
            $scope.states = JSON.parse(data);
        }
    });      
  };
  
  $scope.getProvinceReviews = function(provice){
    $rootScope.has_reviews_city = true;
    $rootScope.has_country_id   = true;
    $rootScope.country_id       = provice.country_id;
    $rootScope.landing_reviews_city = {"name" : provice.name,"province_name" : provice.name , "province_id" : provice.id};
    $state.go("reviews");
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
  
  $scope.loadPostalCodesJson = function(callback) {   

    var xobj = new XMLHttpRequest();
    xobj.overrideMimeType("application/json");
    xobj.open('GET', 'resources/postal_codes.json', true); // Replace 'my_data' with the path to your file
    xobj.onreadystatechange = function () {
        if (xobj.readyState == 4 && xobj.status == "200") {
          // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
          callback(xobj.responseText);
        }
    };
    xobj.send(null);  
  };
  
  $scope.updateReviewsByLandingSearch = function(){
      //TODO check for country_id and seand it in the rootScope has_country_id = true and country_id
      
      console.log($scope.zip_city);
      //check if its length is 3 and has numeric value then its canada
      if($scope.zip_city.length === 3 && $scope.zip_city.match(/\d+/g) != null){
          console.log("here1");
          //we got canada postal code to search with
        $scope.loadPostalCodesJson(function(response) {
            var actual_JSON = JSON.parse(response);
            var single_object = $filter('filter')(actual_JSON.postal_codes, function (d) {
                return d.postal_letter === $('#search_input').val().charAt(0).toUpperCase();
            })[0];

            if(single_object === undefined){
                swal(
                    'Oops...',
                    'Postal Code does not exist!',
                    'error'
                );
            }else{
                console.log('single object is hereeee ');
                console.log(single_object);
                $rootScope.has_reviews_city       = true; 
                $rootScope.has_reviews_volume     = true; 
                $rootScope.landing_reviews_volume = $scope.landing_selected_volume; 
                $rootScope.landing_reviews_city   = {"name" : single_object.name,"province_name" : single_object.province_name , "province_id" : single_object.province_id};
                $state.go("reviews");
            }

           });
      }else if ($.isNumeric($scope.zip_city)){
          console.log("here2");
          // we got america zup code to search with
      }else{
          // we got a city or state to search with
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
                $rootScope.has_reviews_city       = true; 
                $rootScope.has_reviews_volume     = true; 
                $rootScope.landing_reviews_volume = $scope.landing_selected_volume; 
                $rootScope.landing_reviews_city = {"name" : single_object.name,"province_name" : single_object.province_name , "province_id" : single_object.province_id};
                $state.go("reviews");
            }

           });
      }
  };
  
  $scope.getProvinces();
  $scope.getStates();
};

