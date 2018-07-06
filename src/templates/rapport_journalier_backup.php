<?php
require("../login/config.php");

?>
<main class="col-sm-12  col-md-12 " ng-controller="RapportCtrl">


<h3 name="datejour">Rapport journalier <?php echo $date = date('m/d/Y - H:i', time());?></h3>
<form name="form_recherche" method="post" action="templates/mail_form.php" >


    <label for="jumpMenu" class="ui-hidden-accessible">Formation</label>
    <div class="form-group">


    <select class="form-control" name="formation" id="jumpMenu" >
        <option value="">Choisissez une formation</option>
        <?php
        $DatabaseAccessProvider = connectToDolibarrDB();


        $result = mysqli_query($DatabaseAccessProvider, "SELECT rowId, intitule FROM llx_agefodd_formation_catalogue WHERE archive=0 AND intitule != '' ORDER BY intitule");
        while ($rec = mysqli_fetch_array($result)) {
            $rowId = $rec["rowId"];
            $intitule = $rec["intitule"];
            $selected = "";
            if ($formation == $rowId) {
                $selected = "selected";
            }
            echo '<option value="'.$intitule.'">' . $intitule . '</option>';
        }
        ?>
    </select>
  </div>

      <script type="text/javascript">
          <!--
          var rangeValues = {
                  "1": "Averses / pluie forte",
                  "2": "Rare averses",
                  "3": "Orageux",
                  "4": "Nuageux/couvert",
                  "5": "Peu nuageux",
                  "6": "Ensoleillé"
          };

          $(function () {

              $('#rangeInput').on('input change', function () {
                  //for hidden
                  document.getElementById("rangeHiddenText").value = rangeValues[$(this).val()];
              });
          });

          var counterHommes = 1;
          function addHome(divName){
                    var newdiv = document.createElement('divVehicule');
                    newdiv.innerHTML = "<select class='form-control' name='homme["+counterHommes+"][grade]' id='jumpMenu'> <option value=''>Choisissez un grade</option>  <option value='Soldat'>Std - Soldat</option> <option value='Appointe'>App - Appointé</option> <option value='Caporal'>Cpl - Caporal</option> <option value='Sergent'>Sgt - Sergent</option> <option value='Sergent-major'>Sgtm - Sergent-major</option> <option value='Fourrier'>Four - Fourrier</option>  <option value='Lieutenant'>Lt - Lieutenant</option>  <option value='Premier-Lieutenant'>PLt - Premier-Lieutenant</option>  <option value='Capitaine'>Cap - Capitaine</option> <option value='Major'>Maj - Major</option>  </select>  <input class='form-control' type='text' name='homme["+counterHommes+"][prenom]' placeholder='Prenom'>  <input class='form-control'  type='text' name='homme["+counterHommes+"][nom]' placeholder='Nom'><input class='form-control' type='number' name='homme["+counterHommes+"][nbrH]' placeholder=' + nbr hommes '> <br>";
                    document.getElementById(divName).appendChild(newdiv);
                    counterHommes++;
          }

          var counterV = 1;
          function addVehicule(divName){
                    var newdiv = document.createElement('divVehicule');
                    newdiv.innerHTML = "<input class='form-control' type='number' placeholder='nombre vehicules' name='vehicules["+counterV+"][nbr]'> <input class='form-control' type='text' placeholder='description' name='vehicules["+counterV+"][desc]'> <br>";
                    document.getElementById(divName).appendChild(newdiv);
                    counterV++;
          }

          var counterMat = 1;
          function addMateriel(divName){
                    var newdiv = document.createElement('divMat');
                    newdiv.innerHTML = "<input class='form-control' type='number' placeholder='nombre' name='materiel["+counterMat+"][nbr]'> <input class='form-control' type='text' placeholder='description' name='materiel["+counterMat+"][desc]'> <br>";
                    document.getElementById(divName).appendChild(newdiv);
                    counterMat++;
          }

          var counterPlanning = 1;
          var d = new Date();
        //  d.setHours(07, 00, 0);
          function addHoraire(divName){
                    var newdiv = document.createElement('divMat');
                    newdiv.innerHTML = "<input class='form-control' type='text' placeholder='heure' name='planning["+counterPlanning+"][heure]' value=''>  <input type='text' placeholder='tache' name='planning["+counterPlanning+"][tache]'> <br>";
                    document.getElementById(divName).appendChild(newdiv);
                    counterPlanning++;
                  //  d.setHours(d.getHours()+1);
          }

          var counterMission = 1;
          function addMission(divName){
                    var newdiv = document.createElement('divMat');
                    newdiv.innerHTML = "<label for='mission' class='ui-hidden-accessible'>mission</label><select class='form-control' name=mission["+counterMission+"][resp] id='jumpMenu'> <option value=''>Réalisé par:</option><option value='Etat-Major'>Etat-Major</option>  <option value='Aide Commandement'>Aide Commandement</option><option value='Logistique - Subsistance'>Logistique - Subsistance</option><option value='Logistique - Materiel'>Logistique - Materiel</option><option value='Logistique - Transport'>Logistique - Transport</option>        <option value='assistance'>Assistance</option> <option value='Appui'>Appui</option> </select> <br> <input type='text' placeholder='location' name='mission["+counterMission+"][lieu]'>  <br> <textarea name='mission["+counterMission+"][desc]' id='mission' cols='30' rows='10' placeholder='description mission' data-theme='e'></textarea> <br>";
                    document.getElementById(divName).appendChild(newdiv);
                    counterMission++;
          }

          var counterMissionTransmises = 1;
          function addMissionTransmise(divName) {
                    var newdiv = document.createElement('divMissTrans');
                    newdiv.innerHTML = "<input class='form-control' type='text' placeholder='mission transmise' name='missionTrans["+counterMissionTransmises+"][desc]'> <br>";
                    document.getElementById(divName).appendChild(newdiv);
                    counterMissionTransmises++;
          }
  //-->
    </script>

    <label for="situationActuelle" class="ui-hidden-accessible">Situation actuelle</label>
    <textarea class="form-control" name="situationActuelle" id="situationActuelle" cols="30" rows="10" placeholder="Situation Actuelle" data-theme="e"></textarea>

    <h2>Moyens engagés </h2>

    <h3>hommes</h3>
    <div id="divHomme">  </div>
    <input class="form-control" type="button" value="+" onClick="addHome('divHomme');">

    <h3>vehicules</h3>
    <div id="divVehicule">  </div>
    <input class="form-control" type="button" value="+" onClick="addVehicule('divVehicule');">

    <h3>matériel</h3>
         <div id="divMat"> </div>
         <input class="form-control" type="button" value="+" onClick="addMateriel('divMat');">

   <h2> Missions </h2>
    <label>Missions effectuées ajd.</label>
    <div id="divMiss"> </div>
    <input class="form-control" type="button" value="+" onclick="addMission('divMiss');">

   <h2> Nouvelles missions </h2>
    <label> Missions à effectuer demain. </label>

      <div id="divMissTrans"> </div>
      <input class="form-control" type="button" value="+" onclick="addMissionTransmise('divMissTrans');">

   <h3>Planning</h3>
    <label> Planning du jour.</label>
    <div id="divHoraire"> </div>
    <input class="form-control" type="button" value="+" onClick="addHoraire('divHoraire');">

   <h2> Meteo </h2>
    <label> Meteo de la journée </label>
    <ul>
      <li>1 : Averses / pluie forte</li>
      <li>2 : Rare averses</li>
      <li>3 : Orageux</li>
      <li>4 : Nuageux/couvert</li>
      <li>5 : Peu nuageux</li>
      <li>6 : Ensoleillé</li>
    </ul>

    <input c  lass="form-control" type="range" id="rangeInput" name="rangeInput" step="1" min="1" max="6" >
    <input id="rangeHiddenText" name="rangeHiddenText" value="">

    <h2> Commentaires </h2>
    <label for="commentaire" class="ui-hidden-accessible">Commentaires</label>
    <textarea class="form-control" name="commentaire" id="commentaire" cols="30" rows="10" placeholder="Commentaires" data-theme="e"></textarea>
    <button class="btn btn-primary" id="submit" type="submit">Envoyer</button>
</form>
<?php
mysqli_close($DatabaseAccessProvider);
?>

</main>
