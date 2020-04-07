
angular.module('PCIM2')
    .controller('ParametersCtrl', ['$scope', '$http', ParametersCtrl]);

function ParametersCtrl($scope, $http) {

  var Load = function () {
    loadParams();
  }

  var loadParams = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/superadmin/params'
    }).then(function successCallback(response) {
      $scope.params = response.data;
      $scope.autoValidateParam = $scope.params.find(element => element.key == 'auto_validate');
      }, function errorCallback() {
        console.log("error");
    });
  }

  $scope.save = function() {
    $http({
      method: 'PUT',
      url: 'api/index.php/v1/superadmin/param',
      data: $scope.autoValidateParam
    }).then(function successCallback() {
      loadWarnings();
      }, function errorCallback() {
        console.log("error while updating param.");
    });
  }

  Load();

}
