/**
 * PCIM2 API communication controller
 */

angular.module('PCIM2')
    .controller('RechercheCtrl', ['$scope', '$http', RechercheCtrl]);

function RechercheCtrl($scope, $http) {

// ****************************
// Initialise variables & scope
// ****************************

  $scope.form = {};
  $scope.status = 0;

// ****************************
// Load
// ****************************

  var Load = function () {
    loadCategories();
  }

  // ****************************
  // load from API
  // ****************************
  var loadCategories = function () {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/categories'
    }).then(function successCallback(response) {
      $scope.categories = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
  }

  $scope.loadTiers = function (nom) {
    if(nom != null && nom.length > 3){
    console.log(nom);

    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/tiers/'+nom
    }).then(function successCallback(response) {
      console.log(response.data);
      $scope.tiers = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }

  $scope.submit = function () {
    console.log($scope.form.categorie);
  //  console.log($scope.formRepas);
  }



Load();

}
