var details = angular.module('details', []).controller('detailsController', function($scope, $http){


  $scope.showModal = function(){
    $("#legende").modal('show');
  }
 });