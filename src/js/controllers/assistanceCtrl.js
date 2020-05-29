angular.module('PCIM2')
    .controller('AssistanceCtrl', ['$scope', '$http', AssistanceCtrl]);

function AssistanceCtrl($scope, $http) {

    $scope.data = {};
    $scope.status = 0;
    $scope.submit = function () {
      var temp = $scope.data;
      var datasent = {'Nom du chef de groupe':temp.nomLieut, 'Nom du demandeur':temp.nomPers, 'Date souhaitée de rendez-vous':temp.date, 'Raison de la demande':temp.raison, 'Commentaires':temp.commentaire}
      $http({
        method: 'POST',
        url: 'api/index.php/v1/form/demandeassistance',
        data: datasent

      }).then(function successCallback() {
      console.log("success");
      $scope.status = 1;

    //    $scope.personnes = response.data;
        }, function errorCallback() {
          console.log("something went wrong but DB updated");
          $scope.status = 2;
        });


    }
    $scope.loadTiers = function (nom) {
      if(nom != null && nom.length > 2) {
        return $http({
          method: 'GET',
          url: 'api/index.php/v1/admin/socpeople/'+nom
        }).then(function successCallback(response) {
          return response.data;
        }, function errorCallback(response) {
          console.log("error");
        });
      }
    }

}
