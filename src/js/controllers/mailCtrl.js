/**
 * PCIM2 API communication controller
 */

angular.module('PCIM2')
    .controller('MailCtrl', ['$scope', '$http', MailCtrl]);

    function MailCtrl($scope, $http) {


      // ****************************
      // Initialise variables & scope
      // ****************************

      $scope.form = {};
      $scope.status = 0;
      $scope.templates = {};

      var Load = function() {
        loadTemplates();
      }


      var loadTemplates = function () {
       $http({
         method: 'GET',
         url: 'api/index.php/v1/mail/gettemplates'
       }).then(function successCallback(response) {
         $scope.templates = response.data;
       }, function errorCallback(response) {
         console.log("error");
       });
     }



      $scope.submit = function () {
        $http({
         method: 'POST',
         url: 'api/index.php/v1/mail/attributionMail',
         data: $scope.templates
       }).then(function successCallback() {

       console.log("success");
       $scope.status = 1;

         }, function errorCallback() {
           console.log("something went wrong but DB updated");
           $scope.status = 1;
         });
     }





     Load();

}
