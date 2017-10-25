
'use strict';

var landingNavbar = angular.module('myApp.landingNavbar', ['ui.router' , 'ngCookies']);

landingNavbar.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('landingNavbar', {
        templateUrl  : 'modules/navbar/landingNavbar.php',
        controller   : 'landingNavbarCtrl'
  });

}]);


landingNavbar.controller('landingNavbarCtrl',landingNavbarCtrl);
landingNavbarCtrl.$inject = ['$rootScope' , '$scope' , '$http' , '$state' , '$filter' , '$cookies'];

function landingNavbarCtrl ($rootScope , $scope , $http , $state , $filter , $cookies) {
    $scope.is_signed_in = $cookies.get("is_signed_in");
    $scope.user_name    = $cookies.get("user_name");
    $scope.redirectCommrcial = function(commercial_category_id , commercial_category_name){
        console.log("inside redirectCommrcial in navbar");
        $cookies.put("commercial_category_id" , commercial_category_id);
        $cookies.put("commercial_category_name" , commercial_category_name);

        if($state.current.name == 'commercial'){
            location.reload();
        }else{
            $state.go("commercial");
        }
        
    };
    
    $scope.signOut = function(){
        var cookies = $cookies.getAll();
        angular.forEach(cookies, function (v, k) {
            $cookies.remove(k);
        });
        location.reload();
        $state.go("landing");
    };
};

function signIn(){
    var params = {
        "email"         : $('#email').val(),
        "password"      : $('#Password').val(),
        "function_name" : "signIn"
    };  
    console.log("params inside signin");
    console.log(params);
    event.preventDefault();
    $.ajax({
        type        : "GET",
        url         : "handler/signInHandler.php", // Location of the service
        data        : params, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("sign in successfully");
            console.log("data " +data);
            if ($.trim(data) === "failed") {
                swal(
                    'Oops...',
                    'Wrong Email or Password!',
                    'error'
                );
            }else if($.trim(data) === "confirm"){
                swal(
                    'Oops...',
                    'Please confirm your email first!',
                    'error'
                );
            }else{
                swal(
                    'Signed In Successfully',
                    'Welcome '+data,
                    'success'
                );
               
            }
            location.reload();
          //  $('#nav-collapse2').slideToggle();

        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign in");
        }
    });  
      
      
  }



