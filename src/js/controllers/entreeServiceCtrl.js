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
  $scope.personne = null;
  $scope.personnes = {};
  $scope.contacts = {};
  $scope.tiers = {};
  $scope.tags = {};
  $scope.form = {};
  $scope.form.tagtype = '';
  // $scope.tags.permit = [];
  // $scope.tags.hobby = [];
  // $scope.tags.language = [];
  // $scope.tags.rank = [];
  // $scope.tags.section = [];
  // $scope.tags.function = [];
  // $scope.tags.job = [];
  // $scope.tags.secondary = [];
  $scope.tagged = [];
  $scope.existingTags = {};
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
    $scope.contacts = null;
    $scope.personnes = null;
    $scope.personne = personne;
    $scope.personne.tier = null;
    $scope.personne.form = {};
    $scope.personne.form.tier = $scope.personne.tier_nom;
    $scope.tiers = {};
    // $scope.tags.permit = [];
    // $scope.tags.hobby = [];
    // $scope.tags.language = [];
    // $scope.tags.rank = [];
    // $scope.tags.section = [];
    // $scope.tags.function = [];
    // $scope.tags.job = [];
    // $scope.tags.secondary = [];
    $scope.existingTags = null;
    $scope.langsInit = [];
    $scope.tagged = [];
    loadParent();

    // First get all tags (to display them).
    $http({
      method: 'GET',
      url: 'api/index.php/v1/select/entreeservice/tags'
    }).then(function successCallback(response) {
        $scope.tags = response.data;
      // var temp = response.data;
      // temp.forEach((item) => {
      //
      //   switch(item.description) {
      //     case "Permis":
      //         $scope.tags.permit.push(item);
      //       break;
      //     case "Hobby":
      //          $scope.tags.hobby.push(item);
      //       break;
      //     case "Langue":
      //         $scope.tags.language.push(item);
      //       break;
      //     case "Section Pci":
      //         $scope.tags.section.push(item);
      //       break;
      //     case "Grade":
      //         $scope.tags.rank.push(item);
      //       break;
      //      case "Fonction Pci":
      //          $scope.tags.function.push(item);
      //        break;
      //     case "Metier":
      //         $scope.tags.job.push(item);
      //       break;
      //     case "activite secondaire":
      //         $scope.tags.secondary.push(item);
      //     break;
      //   }
      // });
      console.log($scope.tags);
      // console.log($scope.tags.permit);

      // Get the tags for the current person. TODO put this elswhere maybe.
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
        }, function errorCallback(response) {
          console.log("error");
        });

      }, function errorCallback(response) {
        console.log("error");
      });
      $scope.loadTiers(personne.tier_nom);
      // Load the emergency information which are in llx_socpeople_extrafield.
      loadExtrafields(personne.rowid);
  }

  $scope.onClickTier = function (tier)  {
    $scope.personne.tier = tier;
    $scope.tiers = null;
  }
  $scope.goTopTags = function() {
    $location.hash('topTags');
    $anchorScroll();
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
  $scope.loadContacts = function (nom) {
    if(nom != null && nom.length >= 2){

    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeopleTiers/'+nom
    }).then(function successCallback(response) {
      $scope.contacts = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });
    }
  }

  $scope.loadTiers = function (nom) {
    if ($scope.personne.tier !== null) {
        $scope.personne.tier.rowid = null;
    }
    if(nom != null && nom.length > 2) {
      $http({
        method: 'GET',
        url: 'api/index.php/v1/admin/tiers/'+nom
      }).then(function successCallback(response) {
        console.log("Response data:" + response.data);
        $scope.tiers = response.data;
      }, function errorCallback(response) {
        console.log("error");
      });

    };

  }
  var loadExtrafields = function(rowid) {
    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/socpeople/extra/' + rowid
    }).then(function successCallback(response) {
      $scope.personne.extra = response.data;
    }, function errorCallback(response) {
      console.log(response);
    });
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

    var tagList = $scope.tagged;
    var compagnie = [];
    var grade = [];
    var section = [];
    var fonction = [];
    var metier = [];
    var activite = [];
    var maternelle = [];
    var langues = [];
    var permis = [];
    var hobby = [];

    tagList.forEach((item) => {
      switch(item.description) {
           case "Permis":
               permis.push(item);
             break;
           case "Hobby":
                hobby.push(item);
             break;
           case "Langue":
               langues.push(item);
             break;
           case "Section Pci":
              section.push(item);
            break;
          case "Grade":
              grade.push(item);
            break;
           case "Fonction Pci":
               fonction.push(item);
             break;
          case "Metier":
              metier.push(item);
            break;
          case "activite secondaire":
              activite.push(item);
          break;
          case "Langue maternelle":
            maternelle.push(item);
          break;
          case "Compagnie":
            compagnie.push(item);
          break;
        }
      });


       compagnieMsg = '';
      for (var i = 0; i < compagnie.length; i++) {
        compagnieMsg+= compagnie[i].label + '  ---  ';
      }

      gradeMsg = '';
      for (var i = 0; i < grade.length; i++) {
      gradeMsg+= grade[i].label + '  ---  ' ;
      }

      sectionMsg = '';
      for (var i = 0; i < section.length; i++) {
        sectionMsg+= section[i].label + '  ---  ' ;
      }

       fonctionMsg = '';
      for (var i = 0; i < fonction.length; i++) {
        fonctionMsg+= fonction[i].label + '  ---  ' ;
      }

      metierMsg = '';
      for (var i = 0; i < metier.length; i++) {
        metierMsg+= metier[i].label + '  ---  ' ;
      }

      activiteMsg = '';
      for (var i = 0; i < activite.length; i++) {
        activiteMsg+= activite[i].label + '  ---  ' ;
      }

      maternelleMsg = '';
      for (var i = 0; i < maternelle.length; i++) {
        maternelleMsg+= maternelle[i].label + '  ---  ' ;
      }

      langueMsg = '';
      for (var i = 0; i < langues.length; i++) {
        langueMsg+= langues[i].label + '  ---  ' ;
      }

      permisMsg = '';
      for (var i = 0; i < permis.length; i++) {
        permisMsg+= permis[i].label + '  ---  ' ;
      }

      hobbyMsg = '';
      for (var i = 0; i < hobby.length; i++) {
        hobbyMsg += hobby[i].label + '  ---  ' ;
      }


    var parent = $scope.parentList[$scope.personne.extra.lp-1].label;
    var dataSent = {'Nom': $scope.personne.nom, 'Adresse': $scope.personne.address, 'Zip': $scope.personne.zip, 'Ville': $scope.personne.town, 'Mail': $scope.personne.email, 'Téléphone': $scope.personne.phone, 'Numéro d\'urgence': $scope.personne.extra.nb, 'Lien de parenté': parent,
    'Allergie?' : $scope.personne.allergie, 'Allergie (s\'il y en a)': $scope.personne.selectAllergie, 'IBAN': $scope.personne.iban,
    'Employeur':$scope.personne.tier.nom, 'Adresse de l\'employeur' :$scope.personne.tier.address, 'Zip de l\'employeur' :$scope.personne.tier.zip, 'Ville de l\'employeur':$scope.personne.tier.town, 'Téléphone de l\'employeur' :$scope.personne.tier.phone, 'Mail de l\'employeur':$scope.personne.tier.email,
    'Compagnie': compagnieMsg, 'Grade': gradeMsg, 'Section':sectionMsg , 'Fonction': fonctionMsg, 'Métiers': metierMsg, 'Activité secondaire':activiteMsg , 'Langue maternelle':maternelleMsg , 'Autres langues':langueMsg , 'Permis':permisMsg , 'Hobbies': hobbyMsg}
    console.log(JSON.stringify(dataSent));

    //upload
    $http({
      method: 'POST',
      url: 'api/index.php/v1/admin/entreeservice/tags/'+ Number(personne.rowid),
      //15.01.2019
      data: {
        nom: $scope.personne.nom,
        lieu: $scope.personne.town, adresse: $scope.personne.address, zip: $scope.personne.zip,
        tagged: $scope.tagged, mail: $scope.personne.email, phone: $scope.personne.phone,
        urgence: $scope.personne.extra.nb, parent: $scope.personne.extra.lp, message: dataSent,
        employeur: $scope.personne.tier.nom, emplAdresse: $scope.personne.tier.address, emplZip: $scope.personne.tier.zip,
        emplVille: $scope.personne.tier.town, emplPhone: $scope.personne.tier.phone, emplMail: $scope.personne.tier.email, emplID: $scope.personne.tier.rowid
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
