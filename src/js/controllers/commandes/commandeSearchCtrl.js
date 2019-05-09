angular.module('PCIM2')
    .controller('CommandeSearchCtrl', ['$scope','$stateParams', '$http', 'config', CommandeSearchCtrl]);

function CommandeSearchCtrl($scope, $stateParams, $http, config) {
  $scope.commandes = {};
  $scope.command = {id: "", type:"", client:"", date:"", chantier: ""};
  $scope.chantier = "";
  $scope.cmdDeliveredCheck = false;
  $scope.cmdRefusedCheck = false;
  $scope.cmdCancelledCheck = false;

  $scope.search = function(command) {
    searchCommands(command);
  }

  $scope.filterFn = function(cmd) {
    if(!$scope.cmdDeliveredCheck && (cmd.statut === config.deliveredStatus)) {
      return false;
    }
    if(!$scope.cmdRefusedCheck && (cmd.statut === config.refusedStatus)) {
      return false;
    }
    if(!$scope.cmdCancelledCheck && (cmd.statut === config.cancelledStatus)) {
      return false;
    }

    return true;
  };

  $scope.getColor = function(commande) {
    if(commande.statut === config.cancelledStatus || commande.statut === config.refusedStatus) {
      return '#F44336';
    } else {
      return '#0275D8';
    }
  }

  $scope.sqlTimestampToLocal = function(sqlTimestamp) {
    var t = sqlTimestamp.split(/[- :]/);
    var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
    var options = {hour: "2-digit", minute: "2-digit", second: "2-digit", timeZone: "Europe/Zurich"};

    return d.toLocaleDateString('fr-CH', options);
  }

  var Load = function () {
    loadChantiers();
  }

  var searchCommands = function(command) {
    if($scope.chantier && $scope.chantier != null) {
      command.chantier = $scope.chantier;
    } else {
      command.chantier = "";
    }
    // if($scope.command.date && $scope.command.date != null) {
    //   $scope.command.date = new Date().toISOString().slice(0, 10);
    // } else {
    //   $scope.command.date = "";
    // }
    $http({
      method: 'POST',
      url: 'api/index.php/v1/search/commandes',
      data: {command: command}
    }).then(function successCallback(response) {
      $scope.commandes = response.data;
    }, function errorCallback(response) {
      console.log(response);
    });
  }

  var loadChantiers = function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/chantiers'
    }).then(function successCallback(response) {
      $scope.chantiers = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  Load();

}
