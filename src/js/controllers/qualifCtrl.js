angular.module('PCIM2')
    .controller('QualifCtrl', ['$scope', '$http', QualifCtrl]);

function QualifCtrl($scope, $http) {
  $http.defaults.headers.common.Authorization = 'Basic YmVlcDpib29w';

  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.data = {};
  $scope.status = 0;
  $scope.personnes = {};
  $scope.errorMessage = "Unknown error";


  $scope.submit = function () {
    var temp = $scope.data;
    var dataSent = {"Nom de l'astreint: ":$scope.personne.nom, 'Comportement: ':temp.personne.comportement, 'Motivation, engagement, entreprenant: ':temp.personne.motivation, 'Connaissances techniques: ':temp.personne.connaissances, "Faculté d'expression: ":temp.personne.expression, "Aptitude à la fonction: ":temp.personne.aptitude, "Appréciation globale:" :temp.personne.global, "Capacité d'appréciation de la situation: ":temp.personne.appreciation, "Capacité de décision: ": temp.personne.decision, "Capacité d'instruire: ":temp.personne.instruction, "Aptitude à conduire:" :temp.personne.conduite, "Appréciation globale de cadre" :temp.personne.globalCadre, "Commentaire": temp.commentaire};
    $scope.status = 3;

    $http({
     method: 'POST',
     url: 'api/index.php/v1/form/qualifications/'+$scope.personne.rowid,
     data: dataSent
    }).then(function successCallback(response){
     $scope.status = 1;
    }, function errorCallback(response) {
     $scope.status = 2;
    });

    $scope.data = {};
    $scope.form = {};
    $scope.contacts = {};
  }

  $scope.loadContacts = function (nom) {
    $scope.personne = null;

    if(nom != null && nom.length > 1) {
      console.log(nom);

      $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/'+nom
      }).then(function successCallback(response) {
        console.log(response.data);
        $scope.contacts = response.data;
        $scope.status = 0;
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }

  $scope.onClick = function (personne)  {
    $scope.contacts = [personne];
    $scope.personne = personne;
  }

}
