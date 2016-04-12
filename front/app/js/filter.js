'use strict';

var filter = angular
    .module('appFilter', [])
    .filter('uppe', function () {
        return function (value) {
            return angular.uppercase(value);
        }
    })
    .filter('json', function () {
        return function (value, k) {
            return value * k;
        }
    })
;
