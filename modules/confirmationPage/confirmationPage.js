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
 console.log("yeeeeeeeeeeeeeeeeeees we are hereeeeeeeeeeeeeee");
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
  
  $scope.auto_signin = function(){
      console.log("emaaaaaaaaaaaaaaaaaaaaaaaaaail "+$("#email").val());
        var params = {
            "email"         : $("#email").val(),
            "function_name" : "signInConfirmation"
        };  
    
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


                var last_state = $cookies.get("last_state");
                if(last_state){
                    $state.go(last_state);
                }else{
                    $state.go("landing");
                }


        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign in");
        }
    });  
  };

 
};



