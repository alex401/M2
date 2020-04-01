/**
 * Master Controller
 */

angular.module('PCIM2')
    .controller('MasterCtrl', ['$scope', '$translate', '$http', MasterCtrl]);

function MasterCtrl($scope, $translate, $http) {

  // ****************************
  // Initialise variables & scope
  // ****************************

 var Load = function () {
 }

 // ****************************
 // Load
 // ****************************

 Load();

  $scope.changeLanguage = function (langKey) {
    $translate.use(langKey);
  };

}
