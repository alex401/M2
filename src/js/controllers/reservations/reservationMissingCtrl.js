angular.module('PCIM2')
    .controller('ReservationMissingCtrl', ['$scope','$stateParams', '$http', ReservationMissingCtrl]);

function ReservationMissingCtrl($scope, $stateParams, $http) {

  $scope.status = 0;

  var Load = function() {
    getMissingReservations();
  }

  var getMissingReservations = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/reservations/missing/',
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

  Load();

}