'use strict';

var contactUs = angular.module('myApp.contactUs', ['ui.router']);

contactUs.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('contactUs', {
    url: '/contactUs'    ,
    templateUrl: 'modules/contactUs/contactUs.php',
    controller: 'contactUsCtrl',
    controllerAs: 'vm'
  });

}]);


contactUs.controller('contactUsCtrl',contactUsCtrl);
contactUsCtrl.$inject = ['$scope' , '$http' , '$state'];

function contactUsCtrl ($scope , $http , $state) {

  $("#contact_form").submit(function(event) {
    var params = {
        "email"         : $scope.email,
        "name"          : $scope.name,
        "subject"       : $scope.subject,
        "phone"         : $scope.number,
        "message"       : $scope.message,              
        "function_name" : "contactUs"
        
    };  
    console.log("params inside contactUs");
    console.log(params);
    event.preventDefault();
    $.ajax({
        type        : "GET",
        url         : "handler/contactUsHandler.php", // Location of the service
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
                    'Message Sent Successfully',
                    'success'
                );
              $state.go("landing");
            }
           
        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in contact us");
        }
    });   
     
   });
  



};





