'use strict';

var policy = angular.module('myApp.policy', ['ui.router']);

policy.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('policy', {
    url: '/policy'    ,
    templateUrl: 'modules/policy/policy.html',
    controller: 'policyCtrl',
    controllerAs: 'vm'
  });

}]);


policy.controller('policyCtrl',policyCtrl);
policyCtrl.$inject = ['$scope' , '$http' , '$state'];

function policyCtrl ($scope , $http , $state) {
    
};
