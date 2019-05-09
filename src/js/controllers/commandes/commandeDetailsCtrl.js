angular.module('PCIM2')
    .controller('CommandeDetailsCtrl', ['$scope','$location', '$state', '$uibModal', '$stateParams', '$http', 'config', CommandeDetailsCtrl]);

function CommandeDetailsCtrl($scope, $location, $state, $uibModal, $stateParams, $http, config) {
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
      $scope.command.timestampDate = sqlTimestampToLocal($scope.command.timestampDate);
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

  $scope.openModal = function (rowid) {
    var modalInstance = $uibModal.open({
      animation: false,
      ariaLabelledBy: 'modal-title',
      ariaDescribedBy: 'modal-body',
      templateUrl: 'templates/commandes/myModalContent.html',
      controller: 'ModalInstanceCtrl',
      controllerAs: 'pc',
      size: 'sm',
      resolve: {
        data: function () {
          return "Êtes-vous sûr de vouloir annuler la commande ?";
        },
        id: function() {
          return rowid;
        }
      }
    });

    modalInstance.result.then(function (id) {
      cancel(id);
    }, function() {
      // Do nothing.
    });
  };

  $scope.getDate = function(s) {
    let arrayLength = $scope.hist.length;
    for (var i = 0; i < arrayLength; i++) {
      let h = $scope.hist[i];
      if(h.statut == s) {
          return sqlTimestampToLocal(h.date);
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

  // The text displayed on the accept/refuse/validate... buttons.
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

  // Update status when refusing a command.
  $scope.updateStatusRefuse = function(id) {
    var newStatus = '';
    if($scope.currentStatus === config.validationStatus) {
      newStatus = config.refusedStatus;
    } else {
      newStatus = $scope.currentStatus === config.transportStatus ? config.waitingTransportStatus : config.waitingStatus;
    }

    updateDB(newStatus, id);
  }

  // Update status when accepting a command.
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

  $scope.updateRemark = function(id) {
    updateDB($scope.currentStatus, id);
  }

  // Update command status to cancelled.
  var cancel = function(id) {
    updateDB(config.cancelledStatus, id);
  }

  // Update command status.
  var updateDB = function(newStatus, id) {
    dat = {statut: newStatus, remark: $scope.command.remark};

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
      console.log(response);
      $scope.status = 1;
    });

  }

}

function sqlTimestampToLocal(sqlTimestamp) {
  var t = sqlTimestamp.split(/[- :]/);
  var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
  var options = {hour: "2-digit", minute: "2-digit", second: "2-digit", timeZone: "Europe/Zurich"};
  
  return d.toLocaleDateString('fr-CH', options);
}

// Confirmation modal when cancelling a command.
angular.module('PCIM2').controller('ModalInstanceCtrl', function ($uibModalInstance, data, id) {
  var pc = this;
  pc.data = data;
  pc.id = id;

  pc.ok = function () {
    $uibModalInstance.close(id);
  };

  pc.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});
