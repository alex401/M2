angular.module('PCIM2')
    .controller('CommandeTrackingCtrl', ['$scope','$stateParams', '$http', CommandeTrackingCtrl]);

function CommandeTrackingCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.commandes = {};
  $scope.t = $stateParams.type;

  $scope.filterFn = function(cmd) {
    console.log(cmd.status);

    // Put condition in db queries.
    if($scope.t === 'aidecmdt' || ($scope.t === cmd.type)) {
        return true;
    }

    return false;
};
  // ****************************
  // Load
  // ****************************
  var Load = function () {
    getAllCommands();
  }

  var getAllCommands = function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/commandes'
    }).then(function successCallback(response) {
      $scope.commandes = response.data;
      console.log(response.data);
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  Load();

}
