/**
 * PCIM2 API communication controller
 */



angular.module('PCIM2')
    .controller('PisaCtrl', ['$scope', '$http', PisaCtrl]);

function PisaCtrl($scope, $http) {


  // ****************************
  // Initialise variables & scope
  // ****************************

  $scope.data = {};
  $scope.status = 0;
  $scope.personne = null;
  $scope.tags = {};
  $scope.form = {};
  $scope.form.tagtype = '';
  $scope.tagged = [];
  $scope.existingTags = {};
  $scope.langsInit = [];
  $scope.parentList = [];


  var Load = function () {
    loadMail();
    loadParent();
  }


  // ******
  // Load the Tiers / Persons based on input
  // ******


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


  var loadMail = function () {



    $http({
      method: 'GET',
      url: 'api/index.php/v1/admin/connected'
    }).then(function successCallback(response) {


      $scope.login = response.data;
      console.log($scope.login);

      $scope.login.nom = $scope.login.nom.replace(/\?/g, '+');
      $scope.login.prenom = $scope.login.prenom.replace(/\?/g, '+');
      console.log($scope.login.nom);
      console.log($scope.login.prenom);

      $http({
        method: 'GET',
        url: 'api/index.php//v1/admin/socpeopleTiers/mail/'+ $scope.login.prenom + '/' + $scope.login.nom
      }).then(function successCallback(response) {
        $scope.personne = response.data[0];
        console.log($scope.personne);
        $scope.personne.tier = {};
        rowid = $scope.personne.rowid;

        $http({
          method: 'GET',
          url: 'api/index.php/v1/select/entreeservice/tags'
        }).then(function successCallback(response) {
            $scope.tags = response.data;

          console.log($scope.tags);
          // console.log($scope.tags.permit);

          // Get the tags for the current person. TODO put this elswhere maybe.
          $http({
            method: 'GET',
            url: 'api/index.php/v1/admin/tags/' + rowid
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

        $http({
          method: 'GET',
          url: 'api/index.php/v1/admin/socpeople/extra/' + rowid
        }).then(function successCallback(response) {
          $scope.personne.extra = response.data;
        }, function errorCallback(response) {
          console.log(response);
        });

        }, function errorCallback(response) {
          console.log("error");
        });



      }, function errorCallback(response) {
        console.log("error");
      });



  }


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
  $scope.onClick = function ()  {

    loadParent();

    // First get all tags (to display them).

      $scope.loadTiers(personne.tier_nom);
      // Load the emergency information which are in llx_socpeople_extrafield.
      loadExtrafields(personne.rowid);
  }

  $scope.onClickTier = function (tier)  {
    $scope.personne.tier = tier;
    $scope.tiers = null;
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
      var dataSent = {'Nom': $scope.personne.lastname, 'Prénom': $scope.personne.firstname, 'Adresse': $scope.personne.address, 'Zip': $scope.personne.zip, 'Ville': $scope.personne.town, 'Mail': $scope.personne.email, 'Téléphone': $scope.personne.phone, 'Numéro d\'urgence': $scope.personne.extra.nb, 'Lien de parenté': parent,
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
          lastname: $scope.personne.lastname, firstname: $scope.personne.firstname,
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








var load = function(){
  var test = loadMail();
  console.log(test);
  console.log($scope.email);
  $scope.loadContacts();
}

Load();




}
