'use strict';

var signUp = angular.module('myApp.signUp', ['ui.router']);

signUp.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('signUp', {
    url: '/signUp'    ,
    templateUrl: 'modules/signUp/signUp.html',
    controller: 'signUpCtrl',
    controllerAs: 'vm'
  });

}]);


signUp.controller('signUpCtrl',signUpCtrl);
signUpCtrl.$inject = ['$scope' , '$http' , '$state'];

function signUpCtrl ($scope , $http , $state) {
  $scope.country = "1";
  $scope.init = function(){
      $scope.getProvinces();
  };
  
  $scope.changeProvincy = function(){
      $scope.getProvinces();
  };
  
  $("#contact_form").submit(function(event) {
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
                swal(
                    'Success',
                    'Please check your email for confirmation',
                    'success'
                );
            //  $state.go('reviews');
            }else if ($.trim(data) === "exist"){
                swal(
                   'Oops...',
                   'User exists before!',
                   'error'
               );              
            }
            
        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign up");
        }
    });   
     
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
  
  $scope.init();  


};





