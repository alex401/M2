angular.module('PCIM2')
    .controller('CommandeSearchCtrl', ['$scope','$stateParams', '$http', CommandeSearchCtrl]);

function CommandeSearchCtrl($scope, $stateParams, $http) {
  $scope.commandes = {};
  $scope.command = {id: "", type:"", client:"", date:"", chantier: ""};
  $scope.chantier = "";

  $scope.search = function(command) {
    searchCommands(command);
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
