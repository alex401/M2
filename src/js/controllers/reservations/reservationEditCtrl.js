angular.module('PCIM2')
    .controller('ReservationEditCtrl', ['$scope','$stateParams', '$http', ReservationEditCtrl]);

function ReservationEditCtrl($scope, $stateParams, $http) {

  $scope.status = 0;
  $scope.reservation = {};
  $scope.reservationId = $stateParams.id;

  $scope.onSelectContact = function($item, $model, $label, $event) {
    $scope.reservation.contact = $scope.reservation.contact.nom;
  }

  $scope.onSelectProduct = function($item, $model, $label, $event) {
    $scope.reservation.product = $scope.reservation.product.ref + ' - ' + $scope.reservation.product.label;
  }

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

  var Load = function () {
    getReservation();
  }

  var getReservation = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/reservations/' + $scope.reservationId,
      }).then(function successCallback(response) {
        if(response.data.message === 'Not found') {
          $scope.status = 2;
        } else {
          $scope.id = response.data.id;
          $scope.reservation = response.data;
        }
      }, function errorCallback(response) {
        $scope.status = 2;
      });
  }

  $scope.submit = function () {
    $http({
      method: 'POST',
      url: 'api/index.php/v1/reservations/' + $scope.reservationId,
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

  Load();

}