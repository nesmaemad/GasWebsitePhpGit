'use strict';

var aboutUs = angular.module('myApp.aboutUs', ['ui.router']);

aboutUs.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('aboutUs', {
    url: '/aboutUs'    ,
    templateUrl: 'modules/aboutUs/aboutUs.html',
    controller: 'aboutUsCtrl',
    controllerAs: 'vm'
  });

}]);


aboutUs.controller('aboutUsCtrl',aboutUsCtrl);
aboutUsCtrl.$inject = ['$scope' , '$http' , '$state'];

function aboutUsCtrl ($scope , $http , $state) {
    
};
