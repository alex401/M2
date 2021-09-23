angular.module('PCIM2')
    .controller('ReservationListCtrl', ['$scope','$stateParams', '$http', ReservationListCtrl]);

function ReservationListCtrl($scope, $stateParams, $http) {

  $scope.status = 0;

  var Load = function() {
    getReservations();
  }

  var getReservations = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/reservations/',
      }).then(function successCallback(response) {
        if(response.data.message === 'Not found') {
          $scope.status = 2;
        } else {
          $scope.id = response.data.id;
          $scope.reservations = response.data;
        }
      }, function errorCallback(response) {
        $scope.status = 2;
      });
  }

  $scope.deleteReservation = function(id) {
    $http({
      method: 'DELETE',
      url: 'api/index.php/v1/reservations/'+id,
      }).then(function successCallback(response) {
        if(response.data.message === 'Not found') {
          $scope.status = 2;
        } else {
          $scope.id = response.data.id;
          getReservations();
        }
      }, function errorCallback(response) {
        $scope.status = 2;
      });
  }

  $scope.editReservation = function(id) {
    $http({
      method: 'DELETE',
      url: 'api/index.php/v1/reservations/'+id,
      }).then(function successCallback(response) {
        if(response.data.message === 'Not found') {
          $scope.status = 2;
        } else {
          $scope.id = response.data.id;
          getReservations();
        }
      }, function errorCallback(response) {
        $scope.status = 2;
      });
  }

  Load();

}