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
      return '#6600CC';
    };
    if (commande.statut === config.waitingStatus){
      return '#CC0000';
    };
    if (commande.statut === config.deliveredStatus){
      return '#00CC00';
    } else {
      return '#FF8000';
    }
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
