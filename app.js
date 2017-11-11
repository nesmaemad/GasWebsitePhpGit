'use strict';


// Declare app level module which depends on views, and components
angular.module('myApp', [
    'ui.router',
    'ngCookies',
    'ngRoute',
    'myApp.signUp',
    'myApp.reviews',
    'myApp.landing',
    'myApp.contactUs',
    'myApp.navbar',
    'myApp.commercial',
    'myApp.bbq',
    'myApp.terms',
    'myApp.policy',
    'myApp.careers',
    'myApp.aboutUs',
    'myApp.advertiseWithUs',
    'myApp.footer',
    'myApp.signIn',
    'myApp.landingNavbar',
    'myApp.confirmationPage',
    'myApp.userSettings',
    'myApp.resetPassword',
    'myApp.forgetPassword'

]).
config(['$stateProvider' , '$urlRouterProvider',function($stateProvider , $urlRouterProvider ) {
       
    $urlRouterProvider.otherwise('/landing');
}]);









