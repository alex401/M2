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
      $scope.form.mode;



      var Load = function() {
        loadTemplates();
      }


      var loadTemplates = function () {
       $http({
         method: 'GET',
         url: 'api/index.php/v1/mail/gettemplates'
       }).then(function successCallback(response) {
         $scope.templates = response.data;
         var mode = 0;
         for (var i = 0; i < $scope.templates.length; i++) {
           mode = mode + $scope.templates[i].mode;
         }
         mode = mode / $scope.templates.length;
         console.log(mode);
         if (mode < 0.5) {
           $scope.form.mode = 0;
         } else {
           $scope.form.mode = 1;
         }

       }, function errorCallback(response) {
         console.log("error");
       });
     }



      $scope.submit = function () {
        console.log("Mode: " +  $scope.form.mode)
        $http({
         method: 'POST',
         url: 'api/index.php/v1/mail/attributionMail',
         data: {templates: $scope.templates, mode: $scope.form.mode}
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
