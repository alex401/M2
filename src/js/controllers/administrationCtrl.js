angular.module('PCIM2')
    .controller('AdministrationCtrl', ['$scope','$stateParams', '$http', AdministrationCtrl]);

    function AdministrationCtrl($scope, $stateParams, $http) {
      $scope.commandes = {};
      $scope.t = $stateParams.type;
      
      var Load = function () {
        $http({
          method: 'GET',
          url: 'api/index.php/v1/select/commandes'
        }).then(function successCallback(response) {
          $scope.commandes = response.data;
          console.log(response.data);
          }, function errorCallback(response) {
            console.log("error");
          });
      }


      Load();
    }
