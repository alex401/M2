/**
 * PCIM2 API communication controller
 */

angular.module('PCIM2')
    .controller('FormCtrl', ['$scope', '$http', FormCtrl]);

function FormCtrl($scope, $http) {

// ****************************
// Initialise variables & scope
// ****************************

  $scope.form = {};
  $scope.status = 0;
  $scope.form.hommes = [{id: 'h1'}];



  // ****************************
  // Ajoute une radio
  // ****************************


  $scope.addNewHomme = function() {
    var newItemNo = $scope.form.hommes.length+1;
    $scope.form.hommes.push({'id':'h'+newItemNo});
  };


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

  $scope.submit = function (type) {
    switch(type) {
            case "repas":
                var temp = $scope.form;
                var dataSent = {'type':type,'nom':temp.nom,'chantier':temp.chantier,'dateLivraison':temp.dateLivraison, 'nbDej':temp.nbDej, 'nbDiner':temp.nbDiner, 'nbSouper':temp.nbSouper, 'nbCollationNuit':temp.nbCollationNuit, 'nbVegetariens':temp.nbVegetariens, 'commentaire':temp.commentaire};
//                sendCommand(dataSent);
                break;
            case "carburant":
                var temp = $scope.form;
                var dataSent = {'type':type,'nom':temp.nom, 'chantier':temp.chantier,'nbLitresDiesel':temp.nbLitresDiesel, 'nbLitresEssence':temp.nbLitresEssence, 'nbLitresEssence2T':temp.nbLitresEssence2T, 'commentaire':temp.commentaire};
//                sendCommand(dataSent);
                break;
            case "materiel":
                var temp = $scope.form;
                var dataSent = {'type':type,'nom':temp.nom,'chantier':temp.chantier,'dateLivraison':temp.dateLivraison,'mat1':temp.mat1, 'mat2':temp.mat2, 'mat3':temp.mat3, 'commentaire':temp.commentaire};
//                sendCommand(dataSent);
                break;
            case "demandeconge":
                var temp = $scope.form;
                var dataSent = {'nomLieut':temp.nomLieut, 'nomPers':temp.nomPers,'dateEnvoi':new Date().toLocaleString(),'date':temp.date, 'raison':temp.raison, 'commentaire':temp.commentaire};
                break;
            case "transport":
                var temp = $scope.form;
                var dataSent = {'type':type,'nom':temp.nom,'chantier':temp.chantier,'dateLivraison':temp.dateLivraison, 'destination':temp.destination, 'heure':temp.heure, 'detailsHeure':temp.detailsHeure, 'nbHomme':temp.nbHomme,'matTransport':temp.matTransport, 'commentaire':temp.commentaire};
//                sendCommand(dataSent);
                break;
            case "suivichantier":
                var temp = $scope.form;
                var dataSent = {'nom':temp.nom,'chantier':temp.chantier,'dateEnvoi':new Date().toLocaleString(),'avancement':temp.avancement, 'tempsRestant':temp.tempsRestant, 'tachesRestantes':temp.tachesRestantes, 'commentaire':temp.commentaire};
                break;
            case "suivimachine":
                var temp = $scope.form;
                var dataSent = {'nom':temp.nom,'chantier':temp.chantier,'dateEnvoi':new Date().toLocaleString(),'telContact':temp.telContact, 'typeDemande':temp.typeDemande, 'machine':temp.machine, 'numSerie':temp.numSerie, 'chantierDest':temp.chantierDest, 'heuresMachine': temp.heuresMachine, 'commentaire':temp.commentaire};
                break;
            case "demandeavance":
                var temp = $scope.form;
                var dataSent = {'nomLieut':temp.nomLieut, 'nomPers':temp.nomPers,'dateEnvoi':new Date().toLocaleString(),'fonctAct':temp.fonctAct, 'fonctPrevue':temp.fonctPrevue, 'commentaire':temp.commentaire};
                break;
            case "rapportparking":
                var temp = $scope.form;
                console.log($scope.form);
                var dataSent = {'nom':temp.nom,'parking':temp.parking,'dateEnvoi':new Date().toLocaleString(),'etat':temp.etat, 'detailEtat':temp.detailEtat, 'remplissage':temp.remplissage, 'detailRemplissage':temp.detailRemplissage, 'eclairage':temp.eclairage, 'commentaire':temp.commentaire};
                break;
            case "etatcirculation":
                var temp = $scope.form;
                var dataSent = {'nom':temp.nom,'chantier':temp.chantier,'dateEnvoi':new Date().toLocaleString(),'etat':temp.etat, 'detail':temp.detail};
                break;
            case "radios":
                var dataSent = $scope.form;
                break;
            case "ctrlequipement":
                var dataSent = $scope.form;
                console.log(dataSent);
                break;
            default:
                 console.log("do nothing");
        }

        $scope.status = 3;

    $http({
      method: 'POST',
      url: 'api/index.php/v1/form/'+type,
      data : dataSent
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
        console.log(response);
        $scope.status = 2;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });
//    console.log($scope.formRepas);
  }



Load();

}
