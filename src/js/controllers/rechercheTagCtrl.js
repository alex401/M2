/**
 * PCIM2 API communication controller
 */

angular.module('PCIM2')
    .controller('RechercheContactsCtrl', ['$scope', '$http', RechercheContactsCtrl]);

function RechercheContactsCtrl($scope, $http) {

  // ****************************
  // Initialise variables & scope
  // ****************************

    $scope.form = {};
    $scope.status = 0;

  // ****************************
  // Load
  // ****************************

    var Load = function () {
    }

      $scope.loadSocPeople = function(tag) {
        if(tag != null && tag.length > 3){
        console.log(tag);
        $http({
          method: 'GET',
          url: 'api/index.php/v1/admin/socpeople/tags/'+tag
        }).then(function successCallback(response) {
          $scope.tiers = response.data;
        }, function errorCallback(response) {
          console.log("error");
        });
      }
    }
    // ****************************
    // load from API
    // ****************************


    $scope.submit = function () {
      console.log($scope.form.categorie);
    //  console.log($scope.formRepas);
    }



  Load();

  }
