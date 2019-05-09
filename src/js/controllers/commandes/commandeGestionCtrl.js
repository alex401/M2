angular.module('PCIM2')
    .controller('CommandeGestionCtrl', ['$scope','$stateParams', '$state', '$interval', '$window', '$http', 'config', CommandeGestionCtrl]);

function CommandeGestionCtrl($scope, $stateParams, $state, $interval, $window,$http, config) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commandes = {};
  $scope.t = $stateParams.type;
  $scope.config = config;
  $scope.autoReload = 'OFF';

  var reload;

  $scope.filterFn = function(cmd) {

    if(cmd.statut === config.deliveredStatus || cmd.statut === config.refusedStatus
        || cmd.statut === config.cancelledStatus) {
      return false;
    }

    // Put condition in db query ?
    if(($scope.t === 'aidecmdt' && cmd.statut === config.validationStatus)
        || ($scope.t === cmd.type && cmd.statut != config.validationStatus && cmd.statut != config.waitingTransportStatus && cmd.statut != config.transportStatus)
        || ($scope.t === 'transport' && cmd.statut === config.waitingTransportStatus)
        || ($scope.t === 'transport' && cmd.statut === config.treatmentStatus)
        || ($scope.t === 'transport' && cmd.statut === config.transportStatus)
      ) {
        return true;
    }

    return false;
  };

  $scope.$on('$destroy', function() {
    if (angular.isDefined(reload)) {
      $interval.cancel(reload);
      reload = undefined;
    }
  });

  $scope.onAutoReload = function() {
    reloadFunc();
  }


  $scope.getColor = function(commande) {
    if($scope.t === 'transport' && commande.statut === config.treatmentStatus && (commande.type !== 'transport')) {
      return '#FF9800';
    } else if(commande.statut === config.cancelledStatus || commande.statut === config.refusedStatus) {
      return '#F44336';
    } else {
      return '#4CAF50';
    }
  }

  $scope.sqlTimestampToLocal = function(sqlTimestamp) {
    var t = sqlTimestamp.split(/[- :]/);
    var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
    var options = {hour: "2-digit", minute: "2-digit", second: "2-digit", timeZone: "Europe/Zurich"};

    return d.toLocaleDateString('fr-CH', options);
  }

  var reloadFunc = function() {
    // Reload page every 1min to update commands list.
    if(!angular.isDefined(reload) && $scope.autoReload == 'ON') {
      reload = $interval(function() {
        $state.reload();
      }, 60000);
    } else {
      if (angular.isDefined(reload)) {
        $interval.cancel(reload);
        reload = undefined;
      }
    }
    $window.localStorage.setItem("autoReload", $scope.autoReload);
  }

  // ****************************
  // Load
  // ****************************
  var Load = function () {
    getAllCommands();
    if(!$window.localStorage.getItem("autoReload")) {
      $window.localStorage.setItem("autoReload", $scope.autoReload);
    } else {
      $scope.autoReload = $window.localStorage.getItem("autoReload");
    }
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
  reloadFunc();

}
