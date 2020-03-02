angular.module('PCIM2')
    .controller('LogCtrl', ['$scope', '$http', LogCtrl]);

function LogCtrl($scope, $http) {

  $scope.data = {};
  $scope.status = 0;
  $scope.log = {};
  $scope.errorMessage = "Unknown error";
  $scope.log.login = '';

  $scope.submit = function () {

      $http({
        method: 'POST',
        url: 'api/index.php/v1/adminlogs/creation',
        data: { login: $scope.log.login, usertype: $scope.log.usertype, motdepasse: $scope.log.motdepasse, nom: $scope.log.nom, prenom: $scope.log.prenom, email: $scope.log.email}
      }).then(function successCallBack(response) {
        $scope.erreur = response.data;
        console.log("success");
        if ($scope.erreur != '') {
          $scope.status = 4;
        } else {

          $scope.status = 1;
        }

      }, function errorCallback() {
        $scope.status = 2;
      });

  }
}
