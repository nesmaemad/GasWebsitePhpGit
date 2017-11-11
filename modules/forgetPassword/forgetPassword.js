'use strict';

var forgetPassword = angular.module('myApp.forgetPassword', ['ui.router']);

forgetPassword.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('forgetPassword', {
    url: '/forgetPassword'    ,
    templateUrl: 'modules/forgetPassword/forgetPassword.php',
    controller: 'forgetPasswordCtrl',
    controllerAs: 'vm'
  });

}]);


forgetPassword.controller('forgetPasswordCtrl',forgetPasswordCtrl);
forgetPasswordCtrl.$inject = ['$scope' , '$http' , '$state'];

function forgetPasswordCtrl ($scope , $http , $state) {

  $("#contact_form").submit(function(event) {
    var params = {
        "email"         : $scope.email,            
        "function_name" : "forgetPassword"
        
    };  

    event.preventDefault();
    $.ajax({
        type        : "GET",
        url         : "handler/signInHandler.php", // Location of the service
        data        : params, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("nameeeeeeeeeeeeee");
            console.log(data);
            if ($.trim(data) === "success") {
                swal(
                    'Success',
                    'Reset email is sent',
                    'success'
                );
            }else{
                swal(
                    'Oops!',
                    'This email has no account',
                    'error'
                );
            }
           
        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in contact us");
        }
    });   
     
   });
  



};





