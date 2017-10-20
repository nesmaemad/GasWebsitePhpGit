'use strict';

var advertiseWithUs = angular.module('myApp.advertiseWithUs', ['ui.router']);

advertiseWithUs.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('advertiseWithUs', {
    url: '/advertiseWithUs'    ,
    templateUrl: 'modules/advertiseWithUs/advertiseWithUs.html',
    controller: 'advertiseWithUsCtrl',
    controllerAs: 'vm'
  });

}]);


advertiseWithUs.controller('advertiseWithUsCtrl',advertiseWithUsCtrl);
advertiseWithUsCtrl.$inject = ['$scope' , '$http' , '$state'];

function advertiseWithUsCtrl ($scope , $http , $state) {
    
};
