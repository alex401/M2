angular.module('PCIM2')
    .controller('LogCtrl', ['$scope', '$http', LogCtrl]);

function LogCtrl($scope, $http) {

  $scope.data = {};
  $scope.status = 0;
  $scope.log = {};
  $scope.logs = {};
  $scope.errorMessage = "Unknown error";
  $scope.log.login = '';


  var Load = function() {
    loadLogins();
  }


  var loadLogins= function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/superadmin/getLogins',
    }).then(function successCallBack(response) {
      $scope.logs = response.data;
      console.log($scope.logs);
    }, function errorCallback(response) {
      console.log("error");
    });
  }

  $scope.submit = function () {

      $http({
        method: 'POST',
        url: 'api/index.php/v1/superadmin/login',
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

  Load();
}
