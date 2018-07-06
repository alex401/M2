/**
 * PCIM2 API communication controller
 */

 //TODO When only one person is is in the search, automatically select it. (BUG)

angular.module('PCIM2')
    .controller('EntreeServiceCtrl', ['$scope', '$http', EntreeServiceCtrl]);

function EntreeServiceCtrl($scope, $http) {

// ****************************
// Initialise variables & scope
// ****************************

  $scope.data = {};
  $scope.status = 0;
  $scope.personnes = {};
  $scope.tiers = {};
  $scope.tags = {};
  $scope.tagged = [];

// ****************************
// Load
// ****************************

  var Load = function () {

  }

  // ****************************
  // load from API
  // ****************************

  $scope.actionTag = function (tag, ind) {
    console.log(tag);
    if ($scope.tagged.indexOf(tag) === -1) {
      console.log(tag);
      //update the tags array with checked=true and push to tagged array.
      $scope.tags[ind].checked="true";
      $scope.tagged.push(tag);
    } else {
      var index = $scope.tagged.indexOf(tag);
   if (index !== -1) {
     //when the tag is clicked again, remove it from the tagged array and set checked=false in the tags array.
     console.log(tag);
     $scope.tagged.splice(index, 1);
     $scope.tags[ind].checked="false";
    }
  }
    console.log($scope.tagged);
  }

// *****
// When user click on a tier/person. Will resest some arrays to null which will then reorganize the interface based on data on $scope.
//
$scope.onClick = function (personne)  {
  console.log(personne);
  $scope.personnes = null;
  $scope.tiers = null;
  $scope.personne = personne;
  $scope.tags = null;

        $http({
          method: 'GET',
          url: 'api/index.php/v1/select/entreeservice/tags'
        }).then(function successCallback(response) {
          console.log(response.data);
          $scope.tags = response.data;
          }, function errorCallback(response) {
            console.log("error");
          });
  }

  // ******
  // Load the Tiers / Persons based on input
  // ******
  $scope.loadTiers = function (nom) {
    if(nom != null && nom.length > 3){
    console.log(nom);

    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/'+nom
    }).then(function successCallback(response) {
      console.log(response.data);
      $scope.tiers = response.data;
      $scope.status = 0;
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }

    $scope.onSelectFormation = function () {
      loadSessions($scope.data.formation);
    }

    $scope.selectSession = function () {
        loadDates($scope.data.session);
      }

      $scope.onSelectDate = function () {
        session = $scope.data.session.rowid;
        $http({
          method: 'GET',
          url: 'api/index.php/v1/admin/personnes/'+Number(session)
        }).then(function successCallback(response) {
          console.log(response.data);
          $scope.personnes = response.data;
          }, function errorCallback(response) {
            console.log("error");
          });
      }


  $scope.submit = function (personne) {
    //
    console.log(personne);
    console.log(personne.rowid);
    //upload
    $http({
      method: 'POST',
      url: 'api/index.php/v1/admin/entreeservice/tags/'+ Number(personne.rowid),
      data: { tagged: $scope.tagged }

    }).then(function successCallback() {
    //  console.log(response.data);
    console.log("success");
    $scope.status = 1;

  //    $scope.personnes = response.data;
      }, function errorCallback() {
        console.log("something went wrong but DB updated");
        $scope.status = 1;
      });
  }

// Unused
// Load();

}
