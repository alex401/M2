/**
 * PCIM2 API communication controller
 */



angular.module('PCIM2')
    .controller('PisaCtrl', ['$scope', '$http', PisaCtrl]);

function PisaCtrl($scope, $http) {

  // ****************************
  // Initialise variables & scope
  // ****************************

  $scope.data = {};
  $scope.status = 0;
  $scope.personne = null;
  $scope.personnes = {};
  $scope.contacts = {};
  $scope.tiers = {};
  $scope.tags = {};
  $scope.form = {};
  $scope.form.tagtype = '';

  $scope.tagged = [];
  $scope.existingTags = {};
  $scope.langsInit = [];
  $scope.parentList = [];



  // ******
  // Load the Tiers / Persons based on input
  // ******
  $scope.loadContacts = function (nom) {
    if(nom != null && nom.length >= 2){

    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeopleTiers/mail/'+nom
    }).then(function successCallback(response) {
      $scope.contacts = response.data;
      console.log(response.data);
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }


console.log($scope.form.nom);



    }
