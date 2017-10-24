'use strict';

var signIn = angular.module('myApp.signIn', ['ui.router' ,  'ngCookies']);

signIn.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('signIn', {
    url: '/signIn'    ,
    templateUrl: 'modules/signIn/signIn.php',
    controller: 'signInCtrl',
    controllerAs: 'vm'
  });

}]);


signIn.controller('signInCtrl',signInCtrl);
signInCtrl.$inject = ['$scope' , '$http' , '$state' , '$cookies'];

function signInCtrl ($scope , $http , $state , $cookies) {
  $("#contact_form").submit(function(event) {
    var params = {
        "email"         : $scope.email,
        "password"      : $scope.password,
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
                $cookies.put("is_signed_in" , 'true');
                $cookies.put("user_name" , data);
                swal({
                    title: 'Signed In Successfully',
                    text: 'Welcome '+data,
                    type: 'success'
                },function(){
                    location.reload();
                });
               
            }

        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign in");
        }
    });  
       
     
   });
};





