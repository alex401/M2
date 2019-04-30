angular.module('PCIM2')
    .controller('CommandeGestionCtrl', ['$scope','$stateParams', '$http', 'config', CommandeGestionCtrl]);

function CommandeGestionCtrl($scope, $stateParams, $http, config) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commandes = {};
  $scope.t = $stateParams.type;

  $scope.config = config;

  $scope.filterFn = function(cmd) {

    // Put condition in db query ?
    if(($scope.t === 'aidecmdt' && cmd.statut === config.validationStatus)
        || ($scope.t === cmd.type && cmd.statut != config.validationStatus && cmd.statut != config.waitingTransportStatus && cmd.statut != config.transportStatus)
        || ($scope.t === 'transport' && cmd.statut === config.waitingTransportStatus) //TODO
        || ($scope.t === 'transport' && cmd.statut === config.treatmentStatus)
        || ($scope.t === 'transport' && cmd.statut === config.transportStatus)
      ) {
        return true;
    }

    return false;
};

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
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  Load();

}
