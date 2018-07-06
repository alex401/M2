/**
 * Master Controller
 */

angular.module('PCIM2')
    .controller('MasterCtrl', ['$scope','$http', MasterCtrl]);

function MasterCtrl($scope, $http) {

  // ****************************
  // Initialise variables & scope
  // ****************************

 var Load = function () {
 }

 // ****************************
 // Load
 // ****************************

 Load();

}
