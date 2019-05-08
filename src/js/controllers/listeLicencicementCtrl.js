/**
 * PCIM2 API communication controller
 */

 //TODO When only one person is is in the search, automatically select it. (BUG)

angular.module('PCIM2')
    .controller('ListeLicenciementCtrl', ['$scope', '$http', ListeLicenciementCtrl]);

function ListeLicenciementCtrl($scope, $http) {

// ****************************
// Initialise variables & scope
// ****************************

  $scope.data = {};
  $scope.formations = {};
  $scope.status = 0;
  $scope.personnes = {};
  $scope.sessions = {};

// ****************************
// Load
// ****************************

  var Load = function () {
    loadFormations();
    }

  // ****************************
  // load from API
  // ****************************
  /*
    Load formation
  */

  var loadFormations = function () {

    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/formations'
    }).then(function successCallback(response) {
      $scope.formations = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
  }

/*
   Get sessions into $scope.sessions
*/


var loadSessions = function (formation) {
  $scope.status = 4;
  $http({
    method: 'GET',
    url: 'api/index.php/v1/admin/sessions/'+formation.rowId
  }).then(function successCallback(response) {
    $scope.sessions = response.data;
    $scope.status = 0;
    }, function errorCallback(response) {
      console.log("error");
      $scope.status = 2;
    });
}

var loadDates = function () {
    session = $scope.data.session;
    dateDebut = new Date(session.dateDebut);
    dateFin = new Date(session.dateFin);
    var dates = betweenDate(dateDebut, dateFin);
    $scope.dates = dates;
}

  // $scope.onChange = function (index) {
  //   console.log($scope.personnes[index])
  // }

    $scope.onSelectFormation = function () {
      $scope.personnes = {};
      $scope.sessions = {};
      $scope.data.session = null;
      $scope.data.jour = null;
      $scope.dates = {};

      loadSessions($scope.data.formation);
    }

    $scope.selectSession = function () {
      $scope.personnes = {};
      $scope.dates = {};
        loadDates($scope.data.session);
      }

      $scope.onSelectDate = function () {
        $scope.personnes = {};
        session = $scope.data.session.rowid;
        $http({
          method: 'GET',
          url: 'api/index.php/v1/admin/personnes/'+Number(session)
        }).then(function successCallback(response) {
          $scope.personnes = response.data;
          }, function errorCallback(response) {
            console.log("error");
          });
      }


  $scope.submit = function () {
  $scope.status = 3;
    $http({
      method: 'POST',
      url: 'api/index.php/v1/admin/listeLicenciement',
      data: $scope.personnes

    }).then(function successCallback() {
    console.log("success");
    $scope.status = 1;

  //    $scope.personnes = response.data;
      }, function errorCallback() {
        console.log("something went wrong but DB updated");
        $scope.status = 2;
      });
  }

// *************
// UTILS
// *************

  function isDate(dateArg) {
      var t = (dateArg instanceof Date) ? dateArg : (new Date(dateArg));
      return !isNaN(t.valueOf());
  }

  function isValidRange(minDate, maxDate) {
      return (new Date(minDate) <= new Date(maxDate));
  }

  function betweenDate(startDt, endDt) {
      var error = ((isDate(endDt)) && (isDate(startDt)) && isValidRange(startDt, endDt)) ? false : true;
      var between = [];
      var dateOptions = {weekday: "long", year: "numeric", month: "long", day: "numeric"};

      if (error) console.log('error occured!!!... Please Enter Valid Dates');
      else {
          var currentDate = new Date(startDt),
              end = new Date(endDt);
          while (currentDate <= end) {

              between.push((new Date(currentDate)).toLocaleDateString([], dateOptions));
              currentDate.setDate(currentDate.getDate() + 1);
          }
      }
      return between;
  }

Load();

}
