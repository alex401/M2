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


      var email = response.data;
      $http({
        method: 'GET',
        url: 'api/index.php//v1/admin/socpeopleTiers/mail/'+email
      }).then(function successCallback(response) {
        $scope.personne = response.data[0];
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


        console.log($scope.personne);
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





















var load = function(){
  var test = loadMail();
  console.log(test);
  console.log($scope.email);
  $scope.loadContacts();
}

Load();




}
