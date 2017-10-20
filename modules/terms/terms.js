'use strict';

var terms = angular.module('myApp.terms', ['ui.router']);

terms.config(['$stateProvider', function($stateProvider) {

    $stateProvider.state('terms', {
    url: '/terms'    ,
    templateUrl: 'modules/terms/terms.html',
    controller: 'termsCtrl',
    controllerAs: 'vm'
  });

}]);


terms.controller('termsCtrl',termsCtrl);
termsCtrl.$inject = ['$scope' , '$http' , '$state'];

function termsCtrl ($scope , $http , $state) {
    
};