angular.module('PCIM2')
    .controller('CommandeDetailsCtrl', ['$scope','$location', '$state', '$stateParams', '$http', 'config', CommandeDetailsCtrl]);

function CommandeDetailsCtrl($scope, $location, $state, $stateParams, $http, config) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.command = {};
  $scope.cmdData = {};
  $scope.commandId = $stateParams.id;
  $scope.currentStatus = '';
  $scope.config = config;
  $scope.hist = [];
  $scope.cat = $location.path().indexOf("gestion") !== -1 ? "gestion" : "";
  $scope.t = $stateParams.t;
  $scope.histStatus = {
    validationStatus: config.validationStatus,
    waitingStatus: config.waitingStatus,
    treatmentStatus: config.treatmentStatus,
    waitingTransportStatus: config.waitingTransportStatus,
    transportStatus: config.transportStatus,
    deliveredStatus: config.deliveredStatus
  };
  $scope.activeIndex = -1;


  var Load = function () {
    loadCommand();
  }

  var loadCommand = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/commandes/' + $scope.commandId
    }).then(function successCallback(response) {
      console.log("success");

      $scope.status = 1;
      $scope.command = response.data;
      $scope.currentStatus = $scope.command.statut;
      $scope.cmdData = JSON.parse($scope.command.data);

      loadHist();

    }, function errorCallback(response) {
      console.log(response.data.error);
      $scope.status = 1;
    });
  }

  Load();


  var loadHist = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/commande/hist/' + $scope.command.rowid
    }).then(function successCallback(response) {
      console.log("success");
      $scope.status = 1;
      $scope.hist = response.data;
    }, function errorCallback(response) {
      console.log(response.data.error);
      $scope.status = 1;
    });
  }

  $scope.getDate = function(s) {
    let arrayLength = $scope.hist.length;
    for (var i = 0; i < arrayLength; i++) {
      let h = $scope.hist[i];
      if(h.statut == s) {
          return h.date;
      }
    }
    return "";
  }

  $scope.getActive = function(s, index) {
    if(s == $scope.hist[$scope.hist.length-1].statut) {
      $scope.indexActive = index;
      return 'list-group-item active';
    } else {
      return 'list-group-item';
    }
  }

  $scope.filterFn = function() {

    // Put condition in db query ?
    if(($scope.t === 'aidecmdt' && $scope.currentStatus === config.validationStatus)
        || ($scope.t === $scope.command.type && $scope.currentStatus != config.validationStatus && $scope.currentStatus != config.waitingTransportStatus)
        || ($scope.t === 'transport' && $scope.currentStatus === config.waitingTransportStatus)
        // || ($scope.t === 'transport' && $scope.currentStatus === config.treatmentStatus)
        || ($scope.t === 'transport' && $scope.currentStatus === config.transportStatus)
      ) {
        return true;
    }
    return false;
  };

  $scope.buttonText = function() {
    var text = 'test';
    if($scope.currentStatus === config.transportStatus) {
      text = 'Livrée';
    } else if($scope.currentStatus === config.treatmentStatus) {
      text = 'Traitée';
    } else {
      text = $scope.currentStatus === config.validationStatus ? 'Valider' : 'Accepter';
    }
     return text;
  }

  $scope.updateStatusRefuse = function(id) {
    var newStatus = '';
    if($scope.currentStatus === config.validationStatus) {
      newStatus = config.refusedStatus;
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
      newStatus = $scope.currentStatus === config.validationStatus ? config.waitingStatus : config.treatmentStatus;
    }

    updateDB(newStatus, id);
  }

  $scope.cancel = function(id) {
    updateDB(config.cancelledStatus, id);
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
      $state.reload();
    }, function errorCallback(response) {
      console.log(response.data.error);
      $scope.status = 1;
    });

  }

}
