angular.module('PCIM2')
    .controller('CommandeDetailsCtrl', ['$scope','$stateParams', '$http', CommandeDetailsCtrl]);
function CommandeDetailsCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commande = $stateParams.cmd;
  $scope.cat = $stateParams.cat; // Gestion or tracking.
  $scope.t = $stateParams.t; // 4 types + aidecmdt.
  $scope.cmdData = JSON.parse($stateParams.cmd.data);
  $scope.currentStatus = $scope.commande.statut;

  $scope.buttonText = function() {
    var text = 'test';
    if($scope.currentStatus === 'en traitement' && $scope.commande.type === 'transport') {
      text = 'Livrée';
    }
    if($scope.currentStatus === 'en traitement') {
      text = 'Traitée';
    } else {
      text = $scope.t === 'aidecmdt' ? 'Valider' : 'Accepter';
    }
     return text;
  }

  $scope.updateStatus = function(id) {
    var newStatus = '';
    var dat = {};

    if($scope.currentStatus === 'en traitement') {
      newStatus = 'traitee';
    } else {
      newStatus = $scope.t === 'aidecmdt' ? 'attente de traitement' : 'en traitement';
    }
    dat = {statut: newStatus};
    $scope.currentStatus = newStatus;

    $http({
      method: 'POST',
      url: 'api/index.php/v1/commande/update/' + id,
      data: dat
      }).then(function successCallback() {
          console.log("success");
          $scope.status = 1;

            }, function errorCallback() {
              console.log("something went wrong but DB updated");
              $scope.status = 1;
            });
  }

  // ****************************
  // Load
  // ****************************
  var Load = function () {
  }

  Load();

}
