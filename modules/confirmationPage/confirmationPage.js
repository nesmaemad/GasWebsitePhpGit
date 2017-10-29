'use strict';

var confirmationPage = angular.module('myApp.confirmationPage', ['ui.router' ,  'ngCookies']);

confirmationPage.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('confirmationPage', {
    url: '/confirmationPage'    ,
    templateUrl: 'modules/confirmationPage/confirmationPage.php',
    controller: 'confirmationPageCtrl',
    controllerAs: 'vm'
  });

}]);


confirmationPage.controller('confirmationPageCtrl',confirmationPageCtrl);
confirmationPageCtrl.$inject = ['$scope' , '$http' , '$state' , '$cookies' , '$filter'];

function confirmationPageCtrl ($scope , $http , $state , $cookies , $filter) {
    
 $scope.loadCitiesTownsJson = function(callback) {   


    
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
                var user =  JSON.parse(data);
                $cookies.put("is_signed_in" , 'true');
                $cookies.put("user_name" , user["user_name"]);
                console.log("ussssssssssssser city");
                console.log(user["city_id"]);
                
                $scope.loadCitiesTownsJson(function(response) {
                    var actual_JSON = JSON.parse(response);
                    var single_object = $filter('filter')(actual_JSON.Canada, function (d) {
                        return d.id == user["city_id"];
                    })[0];
                    if(single_object === undefined){
                        single_object = $filter('filter')(actual_JSON.America, function (d) {
                            return d.id == user["city_id"];
                        })[0];
                    }

                    console.log('single object is hereeee ');
                    console.log(single_object);
                    $scope.reviews_city = {"name" : single_object.name,
                        "province_name" : single_object.province_name , 
                        "province_id" : single_object.province_id,
                        "id" : single_object.id,
                        "country_id" : single_object.country_id};
                    if(! $cookies.get("has_reviews_city")){
                        $cookies.put("has_reviews_city" , "true");
                        $cookies.putObject("landing_reviews_city" , $scope.reviews_city); 
                    }

              
                   });
                
                    swal({
                        title: 'Signed In Successfully',
                        text: 'Welcome '+user["user_name"],
                        type: 'success'
                    },function(){
                        //location.reload();
                        var last_state = $cookies.get("last_state");
                        if(last_state){
                            $state.go(last_state);
                        }else{
                            $state.go("landing");
                        }
                   
                    });
                
               
            }

        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign in");
        }
    });  
       
     
   });
};





