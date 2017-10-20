'use strict';

var careers = angular.module('myApp.careers', ['ui.router']);

careers.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('careers', {
    url: '/careers'    ,
    templateUrl: 'modules/careers/careers.html',
    controller: 'careersCtrl',
    controllerAs: 'vm'
  });

}]);


careers.controller('careersCtrl',careersCtrl);
careersCtrl.$inject = ['$scope' , '$http' , '$state'];

function careersCtrl ($scope , $http , $state) {
    
};
