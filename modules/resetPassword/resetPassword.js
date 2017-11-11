'use strict';

var resetPassword = angular.module('myApp.resetPassword', ['ui.router']);

resetPassword.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('resetPassword', {
    url: '/resetPassword'    ,
    templateUrl: 'modules/resetPassword/resetPassword.php',
    controller: 'resetPasswordCtrl',
    controllerAs: 'vm'
  });

}]);


resetPassword.controller('resetPasswordCtrl',resetPasswordCtrl);
resetPasswordCtrl.$inject = ['$scope' , '$http' , '$state'];

function resetPasswordCtrl ($scope , $http , $state) {

  $("#contact_form").submit(function(event) {
      if( $scope.password == $scope.confirm_password){
        var params = {
            "email"         : $("#email").val(),  
            "password"      : $scope.password,
            "function_name" : "resetPassword"

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
                        'Password is reset successfully',
                        'success'
                    );
                  $state.go("signIn");
                }

            },
            error : function (jqXHR, textStatus, errorThrown) {
                console.log("error in contact us");
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
  



};





