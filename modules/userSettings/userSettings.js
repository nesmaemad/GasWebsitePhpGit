'use strict';

var userSettings = angular.module('myApp.userSettings', ['ui.router' , 'ngCookies']);

userSettings.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('userSettings', {
    url: '/userSettings'    ,
    templateUrl: 'modules/userSettings/userSettings.php',
    controller: 'userSettingsCtrl',
    controllerAs: 'vm'
  });

}]);


userSettings.controller('userSettingsCtrl',userSettingsCtrl);
userSettingsCtrl.$inject = ['$scope' , '$http' , '$state' , '$cookies' , '$filter'];

function userSettingsCtrl ($scope , $http , $state , $cookies , $filter) {
  $scope.init = function(){
      $scope.getUserData();
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
            "user_id"       : $scope.user_id,
            "init_email"    : $scope.init_email,
            "init_user_name": $scope.init_user_name,
            "function_name" : "updateUserData"

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
                    $cookies.put("user_name" , $scope.user_name);
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
                      text :  'Data is Updated Successfully',
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
                }else if ($.trim(data) == "user_exist"){
                    $("#username_exists").show();  
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
   
   $scope.getUserData = function(){
     $.ajax({
        type        : "GET",
        url         : "handler/signUpHandler.php", // Location of the service
        data        : {"email" : $cookies.get("email") , "function_name" : "getUserData"}, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("dataaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
            console.log(data);
            var user = JSON.parse(data);
            $scope.user_id          = user["id"];
            $scope.email            = user["email"];
            $scope.first_name       = user["first_name" ];
            $scope.last_name        = user["last_name"];
            $scope.address          = user["address"];
            $scope.number           = parseFloat(user["phone"]);
            $scope.code             = user["postal_zip"];
            $scope.province_id      = user["province_id"];
            $scope.country          = user["country_id"] + "";
            $scope.password         = user["password"];
            $scope.user_name        = user["user_name"];
            $scope.city_id          = user["city_id"];
            $scope.confirm_password = user["password"];
            $scope.init_email       = $scope.email;
            $scope.init_user_name   = $scope.user_name;
            $scope.getProvinces();
            $scope.getCities();

        }
    });   
       
   };
  

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
            var province = $filter('filter')( $scope.provinces, function (d) {
                return d.id == $scope.province_id;
            })[0];
            if(province === undefined){
                $scope.selected_province = $scope.provinces[0];
            }else{
                console.log("get the user selected province");
                $scope.selected_province = province;
            }  
            
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
            var city = $filter('filter')($scope.cities, function (d) {
                return d.id == $scope.city_id;
            })[0];
            if(city === undefined){
                $scope.selected_city = $scope.cities[0];
            }else{
                $scope.selected_city = city;
            } 
            
        }
    });      
  };
  
  $scope.init();  


};





