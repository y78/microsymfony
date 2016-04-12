'use strict';

var appController = angular.module('appController', []);

appController
    .controller('listController', ['$scope', '$routeParams', '$http',
        function ($scope, $routeParams, $http) {
            $http.get('http://yd.ru').success(function (data) {
                for (var key in data.items) {
                    $scope.items[key].name = data.items[key].name;
                }
            });

            $scope.items = [{id: 1, name: 'item1'}, {id: 2, name: 'item2'}];
        }
    ])
;
