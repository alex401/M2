angular.module('PCIM2')
    .controller('CommandeGestionCtrl', ['$scope','$stateParams', '$http', CommandeGestionCtrl]);

function CommandeGestionCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commandes = {};
  $scope.t = $stateParams.type;

  $scope.filterFn = function(cmd) {

    // Put condition in db query ?
    if(($scope.t === 'aidecmdt' && cmd.statut === 'attente de validation')
        || ($scope.t === cmd.type && cmd.statut != 'attente de validation' && cmd.statut != 'attente de transport')
        || ($scope.t === 'transport' && cmd.statut === 'attente de transport')
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
      console.log(response.data);
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  Load();

}
