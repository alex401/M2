angular.module('PCIM2')
    .controller('CommandeDetailsCtrl', ['$scope','$stateParams', '$http', CommandeDetailsCtrl]);
function CommandeDetailsCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commande = $stateParams.cmd;
  $scope.cmdData = JSON.parse($stateParams.cmd.data);

  // ****************************
  // Load
  // ****************************
  var Load = function () {
  }

  Load();

}
