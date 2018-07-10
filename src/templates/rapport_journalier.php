
<main class="col-sm-12  col-md-12 " ng-controller="RapportCtrl">

  <div ng-if="status==1"> Rapport créé, mail envoyé  {{ url }}</div>
  <div ng-if="status==2"> Erreur de traitement, veuillez réessayer dans un moment</div>
  <div ng-if="status==3"> Chargement en cours </div>


<form ng-if="status==0" name="formRapport" >
  <h3 name="datejour">Rapport journalier <?php echo $date = date('m/d/Y - H:i', time());?></h3>


    <label for="jumpMenu" class="ui-hidden-accessible">Formation</label>

    <div class="form-group">
      <label for="formGroupChantier">Formation</label>
      <select name="formation" class="form-control" id="formGroupChantier" ng-model="rapport.formation" ng-options="formation.intitule as formation.intitule for formation in formations" >
        <option value="">-- Selection formation --</option>
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

      </script>

    <label for="situationActuelle" class="ui-hidden-accessible">Situation actuelle</label>
    <textarea ng-model="rapport.situationActuelle" class="form-control" name="situationActuelle" id="situationActuelle" cols="30" rows="10" placeholder="Situation Actuelle" data-theme="e"></textarea>

    <h2> Meteo </h2>

    <fieldset>
       <select ng-model="rapport.meteo.court">
         <option value='Averses / pluie forte'>Averses / pluie forte</option>
         <option value='Rare averses'>Rare averses</option>
         <option value='Orageux'>Orageux</option>
         <option value='Nuageux/couvert'>Nuageux/couvert</option>
         <option value='Peu nuageux'>Peu nuageux</option>
         <option value='Ensoleillé'>Ensoleillé</option>
       </select>
       <input type="text" ng-model="rapport.meteo.desc" name="" placeholder="Description météo">
       <input type="text" ng-model="rapport.meteo.ville" name="" placeholder="Ville">

    </fieldset>

    <h2>Moyens engagés </h2>

    <h3> Hommes </h3>
    <fieldset data-ng-repeat="homme in rapport.hommes">
       <select ng-model="homme.grade">
         <option value=''>Choisissez un grade</option>
         <option value='Soldat'>Std - Soldat</option>
         <option value='Appointe'>App - Appointé</option>
         <option value='Caporal'>Cpl - Caporal</option>
         <option value='Sergent'>Sgt - Sergent</option>
         <option value='Sergent-major'>Sgtm - Sergent-major</option>
         <option value='Fourrier'>Four - Fourrier</option>
         <option value='Lieutenant'>Lt - Lieutenant</option>
         <option value='Premier-Lieutenant'>PLt - Premier-Lieutenant</option>
         <option value='Capitaine'>Cap - Capitaine</option>
         <option value='Major'>Maj - Major</option>
       </select>
       <input type="text" ng-model="homme.name" name="" placeholder="Nom responsable">
       <input type="text" ng-model="homme.nombre" name="" placeholder="Nombre de soldats">
    </fieldset>
    <button class="btn" ng-click="addNewHomme()">Add fields</button>


        <h3> Vehicules </h3>
        <fieldset data-ng-repeat="vehicule in rapport.vehicules">
           <input type="text" ng-model="vehicule.nombre" name="" placeholder="Nombre">
           <input type="text" ng-model="vehicule.modele" name="" placeholder="Type de vehicule (modèle)">

        </fieldset>
        <button class="btn" ng-click="addNewVehicule()">Add fields</button>



        <h3> Matériel </h3>
        <fieldset data-ng-repeat="mat in rapport.matos">
           <input type="text" ng-model="mat.nombre" name="" placeholder="Nombre">
           <input type="text" ng-model="mat.modele" name="" placeholder="Description / nom">
        </fieldset>
        <br>
        <button class="btn" ng-click="addNewMateriel()">Add fields</button>



        <h3> Missions </h3>
        <fieldset data-ng-repeat="mission in rapport.missions">
          <select ng-model="mission.section">
            <option value=''>Réalisé par:</option>
            <option value='Etat-Major'>Etat-Major</option>
            <option value='Aide Commandement'>Aide Commandement</option>
            <option value='Logistique - Subsistance'>Logistique - Subsistance</option>
            <option value='Logistique - Materiel'>Logistique - Materiel</option>
            <option value='Logistique - Transport'>Logistique - Transport</option>
            <option value='assistance'>Assistance</option>
            <option value='Appui'>Appui</option>
          </select>

          <select ng-model="mission.avancement">
            <option value="">--AVANCEMENT --</option>
            <option value="100%">100%</option>
            <option value="90%">90%</option>
            <option value="80%">80%</option>
            <option value="70%">70%</option>
            <option value="60%">60%</option>
            <option value="50%">50%</option>
            <option value="40%">40%</option>
            <option value="30%">30%</option>
            <option value="20%">20%</option>
            <option value="10%">10%</option>
            <option value="0%">0%</option>
          </select>
           <input type="text" ng-model="mission.description" name="" placeholder="Description mission">
           <input type="text" ng-model="mission.lieu" name="" placeholder="Lieu">
        </fieldset>
        <button class="btn" ng-click="addNewMission()">Add fields</button>


        <h3> Missions transmises </h3>
        <fieldset data-ng-repeat="missionsTransmise in rapport.missionsTransmises">
           <input type="text" ng-model="missionsTransmise.description" name="" placeholder="Description mission">
           <input type="text" ng-model="missionsTransmise.lieu" name="" placeholder="Lieu">
        </fieldset>

        <button class="btn" ng-click="addNewMissionTransmise()">Add fields</button>

        <button ng-click="submit()" type="submit" class="btn btn-primary" >Envoyer</button>

</form>

</main>
