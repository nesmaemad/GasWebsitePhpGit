'use strict';

var signUp = angular.module('myApp.signUp', ['ui.router' , 'ngCookies']);

signUp.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('signUp', {
    url: '/signUp'    ,
    templateUrl: 'modules/signUp/signUp.html',
    controller: 'signUpCtrl',
    controllerAs: 'vm'
  });

}]);


signUp.controller('signUpCtrl',signUpCtrl);
signUpCtrl.$inject = ['$scope' , '$http' , '$state' , '$cookies'];

function signUpCtrl ($scope , $http , $state , $cookies) {
  $scope.country = "1";
  $scope.init = function(){
      $scope.getProvinces();
      $scope.getCities();
  };
  
  $scope.changeCity = function(){
      $scope.getCities();
  };
  
  $scope.changeProvincy = function(){
      $scope.getProvinces();
  };
  
  $("#contact_form").submit(function(event) {
      console.log($scope.password);
      console.log($scope.confirm_password);
    if($scope.password == $scope.confirm_password){
        var params = {
            "email"         : $scope.email,
            "first_name"    : $scope.first_name,
            "last_name"     : $scope.last_name,
            "address"       : $scope.address,
            "phone"         : $scope.number,
            "postal"        : $scope.code,              
            "province"      : $scope.selected_province.id,
            "country"       : $scope.country,
            "password"      : $scope.password,
            "user_name"     : $scope.user_name,
            "city_id"       : $scope.selected_city.id,
            "function_name" : "signUp"

        };  
        console.log("params inside signup");
        console.log(params);
        event.preventDefault();
        $.ajax({
            type        : "GET",
            url         : "handler/signUpHandler.php", // Location of the service
            data        : params, //Data sent to server
            contentType : "application/json", // content type sent to server
            crossDomain : true,
            async       : false,
            success: function(data, success) {
                console.log("nameeeeeeeeeeeeee");
                console.log(data);
                if ($.trim(data) === "success") {

                    $scope.reviews_city = {"name" : $scope.selected_city.name,
                        "province_name" : $scope.selected_province.name , 
                        "province_id" : $scope.selected_province.id,
                        "id" : $scope.selected_city.id,
                        "country_id" : $scope.country};
                          if(! $cookies.get("has_reviews_city")){
                            $cookies.put("has_reviews_city" , "true");
                            $cookies.putObject("landing_reviews_city" , $scope.reviews_city);
                          }

                    swal({
                      title:  'Success',
                      text :  'Please check your email for confirmation',
                      type : 'success'
                    },function(){
                        var last_state = $cookies.get("last_state");
                        if(last_state){
                            $state.go(last_state);
                        }else{
                            $state.go("landing");
                        }

                    });

                }else if ($.trim(data) === "exist"){
                    $("#email_exists").show();
//                    swal(
//                       'Oops...',
//                       'Email exists before!',
//                       'error'
//                   );              
                }else if ($.trim(data) == "user_exist"){
                    $("#username_exists").show();
//                    swal(
//                       'Oops...',
//                       'User name exists before!',
//                       'error'
//                   );   
                }

            },
            error : function (jqXHR, textStatus, errorThrown) {
                console.log("error in sign up");
            }
        });   
    }else{
            swal(
               'Oops...',
               'Password does not match confirmed one',
               'error'
           );  
    }
   });
  

  $scope.getProvinces = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"country_id" : $scope.country , "function_name" : "getProvinces"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            $scope.provinces = JSON.parse(data);
            $scope.selected_province = $scope.provinces[0];
        }
    });      
  };
  
  $scope.getCities = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"province_id" : $scope.selected_province.id , "function_name" : "getCities"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            $scope.cities = JSON.parse(data);
            $scope.selected_city = $scope.cities[0];
        }
    });      
  };
  
  $scope.init();  


};





