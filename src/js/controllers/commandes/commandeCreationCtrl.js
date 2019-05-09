angular.module('PCIM2')
    .controller('CommandeCreationCtrl', ['$scope','$stateParams', '$http', CommandeCreationCtrl]);

function CommandeCreationCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.form = {};
  $scope.status = 0;
  $scope.date = new Date();

  // ****************************
  // Load
  // ****************************
  var Load = function () {
    loadChantiers();
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

  $scope.loadTiers = function (nom) {
    if(nom != null && nom.length > 2) {
      return $http({
        method: 'GET',
        url: 'api/index.php/v1/admin/tiers/'+nom
      }).then(function successCallback(response) {
        return response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }

  $scope.submit = function (type) {
    var options = {timeZone: "Europe/Zurich"};

    switch(type) {
      case "repas":
          var temp = $scope.form;
          var dataSent = {'type':type,'nom':temp.nom,'chantier':temp.chantier,'dateLivraison':temp.dateLivraison.toLocaleDateString('fr-CH', options), 'nbDej':temp.nbDej, 'nbDiner':temp.nbDiner, 'nbSouper':temp.nbSouper, 'nbCollationNuit':temp.nbCollationNuit, 'nbVegetariens':temp.nbVegetariens, 'commentaire':temp.commentaire};
          break;
      case "carburant":
          var temp = $scope.form;
          var dataSent = {'type':type,'nom':temp.nom, 'chantier':temp.chantier,'nbLitresDiesel':temp.nbLitresDiesel, 'nbLitresEssence':temp.nbLitresEssence, 'nbLitresEssence2T':temp.nbLitresEssence2T, 'commentaire':temp.commentaire};
          break;
      case "materiel":
          var temp = $scope.form;
          var dataSent = {'type':type,'nom':temp.nom,'chantier':temp.chantier,'dateLivraison':temp.dateLivraison.toLocaleDateString('fr-CH', options),'mat1':temp.mat1, 'mat2':temp.mat2, 'mat3':temp.mat3, 'commentaire':temp.commentaire};
          break;
      case "transport":
          var temp = $scope.form;
          var dataSent = {'type':type,'nom':temp.nom,'chantier':temp.chantier,'dateLivraison':temp.dateLivraison.toLocaleDateString('fr-CH', options), 'destination':temp.destination, 'heure':temp.heure, 'detailsHeure':temp.detailsHeure, 'nbHomme':temp.nbHomme,'matTransport':temp.matTransport, 'commentaire':temp.commentaire};
          break;
      default:
           console.log("do nothing");
    }

    $scope.status = 3;

    $http({
      method: 'POST',
      url: 'api/index.php/v1/commande/' + type,
      data : dataSent
      }).then(function successCallback(response) {
        //if API answers "Not found" quick workaround - API need to send correct code for not found
        if(response.data.message === 'Not found') {
          $scope.status = 2;
        } else {
          $scope.id = response.data.id;
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
