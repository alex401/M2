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
    if($scope.currentStatus === 'en transport') {
      text = 'Livrée';
    } else if($scope.currentStatus === 'en traitement') {
      text = 'Traitée';
    } else {
      text = $scope.t === 'aidecmdt' ? 'Valider' : 'Accepter';
    }
     return text;
  }

  $scope.updateStatusRefuse = function(id) {
    var newStatus = '';
    if($scope.currentStatus === 'attente de validation') {
      newStatus = 'livree';
    } else {
      newStatus = $scope.currentStatus === 'en transport' ? 'attente de transport' : 'attente de traitement';
    }  

    updateDB(newStatus, id);
  }

  $scope.updateStatus = function(id) {
    var newStatus = '';
    var dat = {};

    if(($scope.currentStatus === 'en transport')) {
      newStatus = 'livree';
    } else if($scope.currentStatus === 'en traitement') {
      newStatus = 'attente de transport';
    } else if($scope.currentStatus === 'attente de transport') {
      newStatus = 'en transport';
    } else {
      newStatus = $scope.t === 'aidecmdt' ? 'attente de traitement' : 'en traitement';
    }

    updateDB(newStatus, id);
  }

  var updateDB = function(newStatus, id) {
    dat = {statut: newStatus};

    $http({
      method: 'POST',
      url: 'api/index.php/v1/commande/update/' + id,
      data: dat
      }).then(function successCallback() {
          console.log("success");
          $scope.status = 1;
          $scope.currentStatus = newStatus;

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
