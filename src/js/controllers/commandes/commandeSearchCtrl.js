angular.module('PCIM2')
    .controller('CommandeSearchCtrl', ['$scope','$stateParams', '$http', CommandeSearchCtrl]);

function CommandeSearchCtrl($scope, $stateParams, $http) {
  $scope.commandes = {};
  $scope.command = {id: "", type:"", client:"", date:""};

  $scope.search = function(command) {
    searchCommands(command);
  }

  var searchCommands = function(command) {
    $http({
      method: 'POST',
      url: 'api/index.php/v1/search/commandes',
      data: {command: command}
    }).then(function successCallback(response) {
      $scope.commandes = response.data;
      console.log(response.data);
      }, function errorCallback(response) {
        console.log(response);
      });
  }

}
