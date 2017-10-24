
'use strict';

var footer = angular.module('myApp.footer', ['ui.router' , 'ngCookies']);

footer.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('footer', {
        templateUrl  : 'footer.html',
        controller   : 'footerCtrl'
  });

}]);


footer.controller('footerCtrl',footerCtrl);
footerCtrl.$inject = ['$rootScope' , '$scope' , '$http' , '$state' , '$filter' , '$cookies'];

function footerCtrl ($rootScope , $scope , $http , $state , $filter , $cookies) {
    $scope.state_name = $state.current.name;
    console.log("stateeeeeeeeeeeeee "+$state.current.name);
    $scope.redirectCommrcial = function(commercial_category_id , commercial_category_name){
        console.log("inside redirectCommrcial in footer");
        $cookies.put("commercial_category_id" , commercial_category_id);
        $cookies.put("commercial_category_name" , commercial_category_name);
        if($state.current.name == 'commercial'){
            location.reload();
        }else{
            $state.go("commercial");
        }
    };
};





