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
  $scope.existingTags = {};
  $scope.langsInit = [];

// ****************************
// Load
// ****************************

  var Load = function () {

  }

  // ****************************
  // load from API
  // ****************************

  $scope.actionTag = function (tag, ind) {
    if ($scope.tagged.indexOf(tag) === -1) {
      console.log(tag);
      //update the tags array with checked=true and push to tagged array.
      $scope.tags[ind].checked="true";
      $scope.tagged.push(tag);
    } else {
      var index = $scope.tagged.indexOf(tag);
      if (index !== -1) {
        //when the tag is clicked again, remove it from the tagged array and set checked=false in the tags array.
        //console.log(tag);
        $scope.tagged.splice(index, 1);
        $scope.tags[ind].checked="false";
      }
    }
    //console.log($scope.tagged);
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
  $scope.existingTags = null;
  $scope.langsInit = [];
  $scope.tagged = [];

        $http({
          method: 'GET',
          url: 'api/index.php/v1/select/entreeservice/tags'
        }).then(function successCallback(response) {
          console.log(response.data);
          $scope.tags = response.data;
          }, function errorCallback(response) {
            console.log("error");
          });


        $http({
          method: 'GET',
          url: 'api/index.php/v1/admin/tags/' + personne.rowid
        }).then(function successCallback(response) {
          $scope.existingTags = response.data;
          // TODO: do this another way...
          for (var i = 0; i < $scope.tags.length; i++) {
            for (var j = 0; j < $scope.existingTags.length; j++) {
              if($scope.tags[i].label === $scope.existingTags[j].label){
                var t = $scope.tags[i];
                t.checked = "true";
                $scope.tagged.push(t);
              }
              //break;
            }
          }
          $scope.langsInit = getLangs($scope.tagged);
          // console.log("tlangs agged init");
          // console.log($scope.langsInit);
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
          $scope.personnes = response.data;
          }, function errorCallback(response) {
            console.log("error");
          });
      }


  $scope.submit = function (personne) {

    //upload
    $http({
      method: 'POST',
      url: 'api/index.php/v1/admin/entreeservice/tags/'+ Number(personne.rowid),
      //15.01.2019
      data: { lieu: $scope.personne.town, adresse: $scope.personne.address, zip: $scope.personne.zip, tagged: $scope.tagged, mail: $scope.personne.email, phone: $scope.personne.phone }
    }).then(function successCallback() {
      console.log("success");
      $scope.status = 1;

    }, function errorCallback() {
      console.log("something went wrong but DB updated-");
      $scope.status = 1;
    });


    // Mapping tags languages to ECV languages.
    var langs = getLangs($scope.tagged);
    if(langs.length > 0 && !compareArray(langs, $scope.langsInit)) {
      $http({
        method: 'POST',
        url: 'api/index.php/v1/admin/entreeservice/tags/ecv/'+ Number(personne.rowid),
        data: {langs: langs}
      }).then(function successCallback(response) {
        $scope.status = 0;
      }, function errorCallback(response) {
        console.log(response.data.error);
        $scope.status = 1;
      });
    }

  }

// Unused
// Load();

}

function compareArray(array1, array2) {
  return array1.length === array2.length && array1.sort().every(function(value, index) { return value === array2.sort()[index]});
}

function getLangs(tagged) {
  var arrayLength = tagged.length;
  var langs = [];
  for (var i = 0; i < arrayLength; i++) {
      var lang = mapLang(tagged[i].label);
      if(lang != "") {
        langs.push(lang);
      }
  }

  return langs;
}

function mapLang(lang) {
  switch(lang) {
  case "LANGUE FRANCAIS":
    return "fr_FR";
  case "LANGUE ALLEMAND":
    return "de_DE";
  case "LANGUE ANGLAIS":
    return "en_GB";
  case "LANGUE ITALIEN":
    return "it_IT";
  case "LANGUE ESPAGNOL":
    return "es_ES";
  case "LANGUE PORTUGAIS":
    return "pt_PT";
  case "LANGUE TURC":
    return "tr_TR";
  case "LANGUE POLONAIS":
    return "pl_PL";
  case "LANGUE RUSSE":
    return "ru_RU";
  case "LANGUE HOLLANDAIS":
    return "nl_NL";
  case "LANGUE ALBANAIS":
    return "sq_AL";
  case "LANGUE BOSNIAQUE":
    return "bs_BA";
  default:
    return "";
  }
}
