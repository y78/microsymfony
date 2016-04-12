'use strict';

var app = angular
    .module('app', ['ngRoute', 'appController', 'appFilter'])
    .config(['$routeProvider',
        function ($route) {
            $route
                .when('/list', {
                    templateUrl: 'html/list.html',
                    controller: 'listController'
                })
                .otherwise({
                    redirectTo: '/list'
                })
            ;
        }
    ])
;
