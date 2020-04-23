/**
 * PCIM2 API communication controller
 */

angular.module('PCIM2')
    .controller('RapportAssistanceCtrl', ['$scope', '$http', RapportAssistanceCtrl]);

function RapportAssistanceCtrl($scope, $http) {

// ****************************
// Initialise variables & scope
// ****************************

  $scope.form = {};
  $scope.status = 0;
  $scope.url = "";

  $scope.rapport = {};
  $scope.rapport.chantier = "";
  $scope.rapport.situationActuelle = "";
  $scope.rapport.hommes = [{id: 'h1'}];
  $scope.rapport.vehicules = [{id: 'v1'}];
  $scope.rapport.matos = [{id: 'mat1'}];
  $scope.rapport.missions = [{id: 'mission1'}];
  $scope.rapport.meteo = {};
  $scope.rapport.sanitaryStatus = {};
  $scope.rapport.troopStatus = {};
  $scope.rapport.comment = "";


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

//unused but TODO
  $scope.removeChoice = function() {
    var lastItem = $scope.rapport.hommes.length-1;
    $scope.rapport.hommes.splice(lastItem);
  };

// ****************************
// Load
// ****************************

  var Load = function () {
    loadChantiers();
    loadTasks();
    loadZoneEmails();
  }

  // ****************************
  // load from API
  // ****************************
  var loadChantiers = function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/chantiers'
    }).then(function successCallback(response) {
      $scope.chantiers = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  // TODO get this list from dolibarr (llx_project_extrafields).
  var loadTasks = function () {
    $scope.tasks = [
      {"id": 0, "label": "Animation"},
      {"id": 1, "label": "Désinfection"},
      {"id": 2, "label": "Intendance"},
      {"id": 3, "label": "Accompagnement"},
      {"id": 4, "label": "Logistique"},
      {"id": 5, "label": "Cuisine"}
    ];
  }

  var loadZoneEmails = function() {
    $scope.zoneEmails = [
      {"id": 0, "label": "Zone A", "addr": "zone_a@pci-fr.ch"},
      {"id": 1, "label": "Zone B", "addr": "zone_b@pci-fr.ch"},
      {"id": 2, "label": "Zone C", "addr": "zone_c@pci-fr.ch"}
    ]
  }

  $scope.submit = function () {
    $scope.status = 3;
    console.log($scope.rapport);

    $http({
      method: 'POST',
      url: 'api/index.php/v1/rapport/journalier/assistance',
      data : $scope.rapport
      }).then(function successCallback(response) {
        $scope.url = response.data.url;
        //if API answers "Not found" quick workaround - API need to send correct code for not found
        if(response.data.message === 'Not found') {
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
