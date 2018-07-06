/**
 * PCIM2 API communication controller
 */

angular.module('PCIM2')
    .controller('RapportCtrl', ['$scope', '$http', RapportCtrl]);

function RapportCtrl($scope, $http) {

// ****************************
// Initialise variables & scope
// ****************************

  $scope.form = {};
  $scope.status = 0;

  $scope.rapport = {};
  $scope.rapport.situationActuelle = "";
  $scope.rapport.hommes = [{id: 'h1'}];
  $scope.rapport.vehicules = [{id: 'v1'}];
  $scope.rapport.matos = [{id: 'mat1'}];
  $scope.rapport.missions = [{id: 'mission1'}];
  $scope.rapport.missionsTransmises = [{id: 'transmise1'}];


  $scope.addNewHomme = function() {
    var newItemNo = $scope.rapport.hommes.length+1;
    $scope.rapport.hommes.push({'id':'h'+newItemNo});
  };

  $scope.addNewVehicule = function() {
    var newItemNo = $scope.rapport.vehicules.length+1;
    $scope.rapport.vehicules.push({'id':'v'+newItemNo});
  };

  $scope.addNewMateriel = function() {
    var newItemNo = $scope.rapport.matos.length+1;
    $scope.rapport.matos.push({'id':'mat'+newItemNo});
  };

  $scope.addNewMission = function() {
    var newItemNo = $scope.rapport.missions.length+1;
    $scope.rapport.missions.push({'id':'mission'+newItemNo});
  };

  $scope.addNewMissionTransmise = function() {
    var newItemNo = $scope.rapport.missionsTransmises.length+1;
    $scope.rapport.missionsTransmises.push({'id':'transmise'+newItemNo});
  };

//unused but TODO
  $scope.removeChoice = function() {
    var lastItem = $scope.rapport.hommes.length-1;
    $scope.rapport.hommes.splice(lastItem);
  };

// ****************************
// Load
// ****************************

  var Load = function () {
    loadFormations();
  }

  // ****************************
  // load from API
  // ****************************
  var loadFormations = function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/formations'
    }).then(function successCallback(response) {
      $scope.formations = response.data;
      console.log($scope.formations);
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  $scope.submit = function () {
    console.log($scope.rapport);


    $http({
      method: 'POST',
      url: 'api/index.php/v1/rapport/journalier',
      data : $scope.rapport
      }).then(function successCallback(response) {
        console.log(response.data.message);
        //if API answers "Not found" quick workaround - API need to send correct code for not found
        if(response.data.message === 'Not found'){
          $scope.status = 2;
        } else {
          $scope.status = 1;
        }
        // this callback will be called asynchronously
        // when the response is available
      }, function errorCallback(response) {
        $scope.status = 2;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });

  }

Load();

}
