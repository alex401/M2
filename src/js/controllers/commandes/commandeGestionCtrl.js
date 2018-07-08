angular.module('PCIM2')
    .controller('CommandeGestionCtrl', ['$scope','$stateParams', '$http', CommandeGestionCtrl]);

function CommandeGestionCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commandes = {};
  $scope.t = $stateParams.type;

  // ****************************
  // Load
  // ****************************
  var Load = function () {
    getAllCommands();
  }

  var getAllCommands = function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/commandes'
    }).then(function successCallback(response) {
      $scope.commandes = response.data;
      console.log(response.data);
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  Load();

}
