angular.module('PCIM2')
    .controller('CommandeDetailsCtrl', ['$scope','$stateParams', '$http', 'config', CommandeDetailsCtrl]);
function CommandeDetailsCtrl($scope, $stateParams, $http, config) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commande = $stateParams.cmd;
  $scope.cat = $stateParams.cat; // Gestion or tracking.
  $scope.t = $stateParams.t; // 4 types + aidecmdt.
  $scope.cmdData = JSON.parse($stateParams.cmd.data);
  $scope.currentStatus = $scope.commande.statut;

  $scope.config = config;
  $scope.hist = [];

  $http({
    method: 'GET',
    url: 'api/index.php/v1/commande/hist/' + $scope.commande.rowid
  }).then(function successCallback(response) {
    console.log("success");
    $scope.status = 1;
    $scope.hist = response.data;
  }, function errorCallback(response) {
    console.log(response.data.error);
    $scope.status = 1;
  });

  $scope.buttonText = function() {
    var text = 'test';
    if($scope.currentStatus === config.transportStatus) {
      text = 'Livrée';
    } else if($scope.currentStatus === config.treatmentStatus) {
      text = 'Traitée';
    } else {
      text = $scope.t === 'aidecmdt' ? 'Valider' : 'Accepter';
    }
     return text;
  }

  $scope.updateStatusRefuse = function(id) {
    var newStatus = '';
    if($scope.currentStatus === config.validationStatus) {
      newStatus = config.deliveredStatus;
    } else {
      newStatus = $scope.currentStatus === config.transportStatus ? config.waitingTransportStatus : config.waitingStatus;
    }

    updateDB(newStatus, id);
  }

  $scope.updateStatus = function(id) {
    var newStatus = '';
    var dat = {};

    if(($scope.currentStatus === config.transportStatus)) {
      newStatus = config.deliveredStatus;
    } else if($scope.currentStatus === config.treatmentStatus) {
      newStatus = config.waitingTransportStatus;
    } else if($scope.currentStatus === config.waitingTransportStatus) {
      newStatus = config.transportStatus;
    } else {
      newStatus = $scope.t === 'aidecmdt' ? config.waitingStatus : config.treatmentStatus;
    }

    updateDB(newStatus, id);
  }

  var updateDB = function(newStatus, id) {
    dat = {statut: newStatus};

    $http({
      method: 'POST',
      url: 'api/index.php/v1/commande/update/' + id,
      data: dat
    }).then(function successCallback(response) {
      console.log("success");
      $scope.status = 1;
      $scope.currentStatus = newStatus;
    }, function errorCallback(response) {
      console.log(response.data.error);
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
