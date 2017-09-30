'use strict';


// Declare app level module which depends on views, and components
angular.module('myApp', [
    'ui.router',
    'ngRoute',
    'myApp.signUp',
    'myApp.reviews',
    'myApp.landing',
    'myApp.contactUs'

]).
config(['$stateProvider' , '$urlRouterProvider',function($stateProvider , $urlRouterProvider ) {
       
    $urlRouterProvider.otherwise('/landing');
}]);









