
<main class="col-sm-12  col-md-12 " ng-controller="RapportCtrl">

  <div ng-if="status==1"> Rapport créé, mail envoyé  {{ url }}</div>
  <div ng-if="status==2"> Erreur de traitement, veuillez réessayer dans un moment</div>
  <div ng-if="status==3"> Chargement en cours </div>


<form ng-if="status==0" name="formRapport" >
  <h3 name="datejour">{{'daily_report.title' | translate}} <?php echo $date = date('m/d/Y - H:i', time());?></h3>


    <label for="jumpMenu" class="ui-hidden-accessible">{{'daily_report.formation' | translate}}</label>

    <div class="form-group">
      <label for="formGroupChantier">{{'daily_report.formation' | translate}}</label>
      <select name="formation" class="form-control" id="formGroupChantier" ng-model="rapport.formation" ng-options="formation.intitule as formation.intitule for formation in formations" >
        <option value="">{{'daily_report.selectFormation' | translate}}</option>
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

    <label for="situationActuelle" class="ui-hidden-accessible">{{'daily_report.situation' | translate}}</label>
    <textarea ng-model="rapport.situationActuelle" class="form-control" name="situationActuelle" id="situationActuelle" cols="30" rows="10" placeholder="{{'daily_report.situation' | translate}}" data-theme="e"></textarea>

    <h2> {{'daily_report.meteo.title' | translate}} </h2>

    <fieldset>
      <select ng-model="rapport.meteo.court">
        <option value='Averses / pluie forte'>{{'daily_report.meteo.showers' | translate}}</option>
        <option value='Rare averses'>{{'daily_report.meteo.lightshowers' | translate}}</option>
        <option value='Orageux'>{{'daily_report.meteo.stormy' | translate}}</option>
        <option value='Nuageux/couvert'>{{'daily_report.meteo.cloudy' | translate}}</option>
        <option value='Peu nuageux'>{{'daily_report.meteo.cloudsunny' | translate}}</option>
        <option value='Ensoleillé'>{{'daily_report.meteo.sunny' | translate}}</option>
      </select>
       <input type="text" ng-model="rapport.meteo.desc" name="" placeholder="{{'daily_report.meteo.description' | translate}}">
       <input type="text" ng-model="rapport.meteo.ville" name="" placeholder="{{'daily_report.meteo.city' | translate}}">

    </fieldset>

    <h2>{{'daily_report.means.title' | translate}}</h2>

    <h3> {{'daily_report.means.men' | translate}} </h3>
    <fieldset data-ng-repeat="homme in rapport.hommes">
       <select ng-model="homme.grade">
         <option value=''>{{'daily_report.means.rank' | translate}}</option>
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
       <input type="text" ng-model="homme.name" name="" placeholder="{{'daily_report.means.resp' | translate}}">
       <input type="text" ng-model="homme.nombre" name="" placeholder="{{'daily_report.means.amount' | translate}}">
    </fieldset>
    <button class="btn" ng-click="addNewHomme()">{{'daily_report.means.add_field' | translate}}</button>


        <h3> {{'daily_report.vehicles.title' | translate}} </h3>
        <fieldset data-ng-repeat="vehicule in rapport.vehicules">
           <input type="text" ng-model="vehicule.nombre" name="" placeholder="{{'daily_report.vehicles.amount' | translate}}">
           <input type="text" ng-model="vehicule.modele" name="" placeholder="{{'daily_report.vehicles.type' | translate}}">

        </fieldset>
        <button class="btn" ng-click="addNewVehicule()">{{'daily_report.vehicles.add_field' | translate}}</button>



        <h3> {{'daily_report.material.title' | translate}} </h3>
        <fieldset data-ng-repeat="mat in rapport.matos">
           <input type="text" ng-model="mat.nombre" name="" placeholder="{{'daily_report.material.amount' | translate}}">
           <input type="text" ng-model="mat.modele" name="" placeholder="{{'daily_report.material.description' | translate}}">
        </fieldset>
        <br>
        <button class="btn" ng-click="addNewMateriel()">{{'daily_report.material.add_field' | translate}}</button>



        <h3> {{'daily_report.missions.title' | translate}} </h3>
        <fieldset data-ng-repeat="mission in rapport.missions">
          <select ng-model="mission.section">
            <option value=''>{{'daily_report.missions.by' | translate}}</option>
            <option value='Etat-Major'>Etat-Major</option>
            <option value='AIC 1 - Renseignement'>AIC 1 - Renseignement</option>
            <option value='AIC 1 - Média'>AIC 1 - Média</option>
            <option value='AIC 1 - Chancellerie'>AIC 1 - Chancellerie</option>
            <option value='AIC 2 - Télématique'>AIC 2 - Télématique</option>
            <option value='AIC 2 - Informatique'>AIC 2 - Informatique</option>
            <option value='Circulation'>Circulation</option>
            <option value='Logistique - Fourrier'>Logistique - Fourrier</option>
            <option value='Logistique - Infrastructure'>Logistique - Infrastructure</option>
            <option value='Logistique - Subsistance'>Logistique - Subsistance</option>
            <option value='Logistique - Materiel'>Logistique - Materiel</option>
            <option value='Logistique - Transport'>Logistique - Transport</option>
            <option value='Assistance 1'>Assistance 1</option>
            <option value='Assistance 2'>Assistance 2</option>
            <option value='Assistance 3'>Assistance 3</option>
            <option value='Appui 1'>Appui 1</option>
            <option value='Appui 2'>Appui 2</option>
            <option value='Appui 3'>Appui 3</option>
          </select>

          <select ng-model="mission.avancement">
            <option value="">{{'daily_report.missions.progress' | translate}}</option>
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
           <input type="text" ng-model="mission.description" name="" placeholder="{{'daily_report.missions.description' | translate}}">
           <input type="text" ng-model="mission.lieu" name="" placeholder="{{'daily_report.missions.location' | translate}}">
        </fieldset>
        <button class="btn" ng-click="addNewMission()">{{'daily_report.missions.add_field' | translate}}</button>


        <h3>{{'daily_report.missionsTransmises.title' | translate}}</h3>
        <fieldset data-ng-repeat="missionsTransmise in rapport.missionsTransmises">
           <input type="text" ng-model="missionsTransmise.description" name="" placeholder="{{'daily_report.missionsTransmises.description' | translate}}">
           <input type="text" ng-model="missionsTransmise.lieu" name="" placeholder="{{'daily_report.missionsTransmises.location' | translate}}">
        </fieldset>

        <button class="btn" ng-click="addNewMissionTransmise()">{{'daily_report.missionsTransmises.add_field' | translate}}</button>

        <button ng-click="submit()" type="submit" class="btn btn-primary" >{{'daily_report.send' | translate}}</button>

</form>

</main>
