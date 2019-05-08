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
  $scope.tiers = {};
  $scope.tags = [];
  $scope.tagged = [];
  $scope.existingTags = [];
  $scope.langsInit = [];
  $scope.parentList = [];

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
      //update the tags array with checked=true and push to tagged array.
      $scope.tags[ind].checked="true";
      $scope.tagged.push(tag);
    } else {
      var index = $scope.tagged.indexOf(tag);
      if (index !== -1) {
        //when the tag is clicked again, remove it from the tagged array and set checked=false in the tags array.
        $scope.tagged.splice(index, 1);
        $scope.tags[ind].checked="false";
      }
    }
  }

  // *****
  // When user click on a tier/person. Will resest some arrays to null which will then reorganize the interface based on data on $scope.
  //
  $scope.onClick = function (personne)  {
    $scope.tiers = null;
    $scope.personne = personne;
    $scope.tags = [];
    $scope.existingTags = [];
    $scope.langsInit = [];
    $scope.tagged = [];

    loadParent();

    // First get all tags (to display them).
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/entreeservice/tags'
    }).then(function successCallback(response) {
      $scope.tags = response.data;
      console.log("All tags: ", $scope.tags);

      // Get the tags for the current person. TODO put this elswhere maybe.
      $http({
        method: 'GET',
        url: 'api/index.php/v1/admin/tags/' + personne.rowid
      }).then(function successCallback(response) {
        $scope.existingTags = response.data;
        console.log("Existing: ", $scope.existingTags);
        // TODO: do this another way...
        for (var i = 0; i < $scope.tags.length; i++) {
          for (var j = 0; j < $scope.existingTags.length; j++) {
            if($scope.tags[i].label === $scope.existingTags[j].label){
              var t = $scope.tags[i]; //TODO copy
              t.checked = "true";
              $scope.tagged.push(t);
            }
            //break;
          }
        }
        $scope.langsInit = getLangs($scope.tagged);
        }, function errorCallback(response) {
          console.log("error");
        });

      }, function errorCallback(response) {
        console.log("error");
      });

      // Load the emergency information which are in llx_socpeople_extrafield.
      loadExtrafields(personne.rowid);
  }

  var loadParent = function() {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/extra/parent'
    }).then(function successCallback(response) {
      $scope.parentList = response.data;
      }, function errorCallback(response) {
        console.log("error");
    });
  }

  // ******
  // Load the Tiers / Persons based on input
  // ******
  $scope.loadTiers = function (nom) {
    if(nom != null && nom.length >= 3){

    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/'+nom
    }).then(function successCallback(response) {
      $scope.tiers = response.data;
      $scope.status = 0;
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }

  var loadExtrafields = function(rowid) {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/extra/' + rowid
    }).then(function successCallback(response) {
      $scope.personne.extra = response.data;
      $scope.status = 0;
    }, function errorCallback(response) {
      console.log(response);
    });
  }

  $scope.submit = function (personne) {

    //upload
    $http({
      method: 'POST',
      url: 'api/index.php/v1/admin/entreeservice/tags/'+ Number(personne.rowid),
      //15.01.2019
      data: {
        lieu: $scope.personne.town, adresse: $scope.personne.address, zip: $scope.personne.zip,
        tagged: $scope.tagged, mail: $scope.personne.email, phone: $scope.personne.phone,
        urgence: $scope.personne.extra.nb, parent: $scope.personne.extra.lp
      }
    }).then(function successCallback() {
      $scope.status = 1;
    }, function errorCallback(response) {
      console.log(response.data.error);
      $scope.status = 2;
    });


    // Mapping tags languages to ECV languages.
    var langs = getLangs($scope.tagged);
    if(langs.length > 0 && !compareArray(langs, $scope.langsInit)) {
      $http({
        method: 'POST',
        url: 'api/index.php/v1/admin/entreeservice/tags/ecv/'+ Number(personne.rowid),
        data: {langs: langs}
      }).then(function successCallback(response) {
        $scope.status = 1;
      }, function errorCallback(response) {
        console.log(response.data.error);
        $scope.status = 2;
      });
    }

  }

Load();

}


// =============================================================================
// Check if two arrays contain the same values (order not important).
// =============================================================================
function compareArray(array1, array2) {
  return array1.length === array2.length && array1.sort().every(function(value, index) { return value === array2.sort()[index]});
}

// =============================================================================
// Convert tags to array of names matching ecv languages name.
// =============================================================================
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

// =============================================================================
// Map a language tag to a ecv language name.
// =============================================================================
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
