var myApp = angular.module("myApp", []);

myApp.controller("SalleCtrl", ['$scope','$http', function($scope, $http, $filter){
	
	$scope.error = false;
	
	$scope.salles=[];
	
	//Récupération des musées
	function getSalles(){
		$http.get("http://localhost/visualisation1/encode_salle.php")
			.success(function(data, status){
				$scope.salles = data;
				alert(data);
			})
			.error(function(data, status){
				$scope.salles = data;
				$scope.status = status;
				$scope.error = true;
				alert('Erreur');				
			})
	}
	
	getSalles();
}]);