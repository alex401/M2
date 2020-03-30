angular.module('PCIM2')
    .controller('GroupCtrl', ['$scope', '$http', GroupCtrl]);

function GroupCtrl($scope, $http) {

    $scope.data = {};
    $scope.status = 0;
    $scope.submit = function () {
      var temp = $scope.data;
      var datasent = {'Nom du chef de groupe':temp.nomChef, 'Fatigue':temp.fatigue, 'Stress':temp.stress, 'Moral':temp.moral, 'Commentaires':temp.commentaire}
      $http({
        method: 'POST',
        url: 'api/index.php/v1/admin/groupreport',
        data: $scope.data

      }).then(function successCallback() {
      console.log("success");
      $scope.status = 1;

    //    $scope.personnes = response.data;
        }, function errorCallback() {
          console.log("something went wrong but DB updated");
          $scope.status = 2;
        });


    }


}
