'use strict';


// Declare app level module which depends on views, and components
angular.module('myApp', [
    'ui.router',
    'ngRoute',
    'myApp.signUp',
    'myApp.reviews'

]).
config(['$stateProvider' , '$urlRouterProvider',function($stateProvider , $urlRouterProvider ) {
    $urlRouterProvider.otherwise('/mainPage');
}]);









