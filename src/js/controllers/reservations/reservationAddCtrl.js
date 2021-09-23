angular.module('PCIM2')
    .controller('ReservationAddCtrl', ['$scope','$stateParams', '$http', ReservationAddCtrl]);

function ReservationAddCtrl($scope, $stateParams, $http) {
  // ****************************
  // Initialise variables & scope
  // ****************************
  $scope.reservation = {};
  $scope.status = 0;

  // ****************************
  // load from API
  // ****************************
  $scope.getContact = function (nom) {
    return $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/'+nom
    }).then(function successCallback(response) {
      return response.data;
    }, function errorCallback(response) {
      console.log("error");
    });
  }

  $scope.getProduct = function (name) {
    return $http({
      method: 'GET',
      url: 'api/index.php/v1/reservations/products/'+name
    }).then(function successCallback(response) {
      return response.data;
    }, function errorCallback(response) {
      console.log("error");
    });
  }


  $scope.submit = function () {
    // Maybe make the api return this already formatted (like the CONCAT in contacts).
    $scope.reservation.product = $scope.reservation.product.ref + ' - ' + $scope.reservation.product.label;
    $scope.reservation.contact = $scope.reservation.contact.nom;
    $http({
      method: 'POST',
      url: 'api/index.php/v1/reservations/',
      data : $scope.reservation
      }).then(function successCallback(response) {
        if(response.data.message === 'Not found') {
          $scope.status = 2;
        } else {
          $scope.id = response.data.id;
          $scope.status = 1;
        }
      }, function errorCallback(response) {
        $scope.status = 2;
      });
  }

}