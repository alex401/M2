
angular.module('PCIM2')
    .controller('WarningsCtrl', ['$scope', '$http', WarningsCtrl]);

function WarningsCtrl($scope, $http) {

  var Load = function () {
    loadWarnings();
  }

  var loadWarnings = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/warnings'
    }).then(function successCallback(response) {
      $scope.warnings = response.data;
      }, function errorCallback() {
        console.log("error");
    });
  }

  $scope.save = function(warning) {
    if(!warning.row_id) {
      $http({
        method: 'POST',
        url: 'api/index.php/v1/superadmin/warning',
        data: warning
      }).then(function successCallback() {
        loadWarnings();
        }, function errorCallback() {
          console.log("error while creating new warning.");
      });
    } else {
      $http({
        method: 'PUT',
        url: 'api/index.php/v1/superadmin/warning/' + warning.row_id,
        data: warning
      }).then(function successCallback() {
        loadWarnings();
        }, function errorCallback() {
          console.log("error while updating warning.");
      });
    }
  }

  $scope.delete = function(warningId) {
    if(!warningId) {
      $scope.warnings.pop();
    } else {
      $http({
        method: 'DELETE',
        url: 'api/index.php/v1/superadmin/warning/' + warningId
      }).then(function successCallback() {
        loadWarnings();
        }, function errorCallback() {
          console.log("error while deleting warning.");
      });
    }
  }

  $scope.add = function() {
    $scope.warnings.push({});
  }

  Load();

}
