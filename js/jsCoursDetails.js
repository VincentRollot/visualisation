var GymSuedoise = angular.module('GymSuedoise', []).controller('coursDetailController', function($scope, $http){
  $scope.cours = [];
  $http.get('/visualisation/recuperer_info_cours.php').
    success(function(data, status, headers, config) {   
            $scope.cours = data;
    }).
    error(function(data, status, headers, config) {
      console.log('ca marche pas');
  });
  
});