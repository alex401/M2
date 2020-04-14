
<main class="col-sm-12  col-md-12 " ng-controller="RapportAssistanceCtrl">

  <div ng-if="status==1"> Rapport créé, mail envoyé  {{ url }}</div>
  <div ng-if="status==2"> Erreur de traitement, veuillez réessayer dans un moment</div>
  <div ng-if="status==3"> Chargement en cours </div>


<form ng-if="status==0" name="formRapport" >
  <h3 name="datejour">{{'daily_report_assist.title' | translate}} <?php echo $date = date('m/d/Y - H:i', time());?></h3>

    <div class="form-group">
      <label for="chantier">{{'daily_report_assist.site.title' | translate}}</label>
      <select class="form-control" id="chantier" ng-model="rapport.chantier" ng-options="chantier.title as chantier.title for chantier in chantiers">
        <option value="">{{'daily_report_assist.site.selection' | translate}}</option>
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

      </script>

    <label for="situationActuelle" class="ui-hidden-accessible">{{'daily_report_assist.situation' | translate}}</label>
    <textarea ng-model="rapport.situationActuelle" class="form-control" name="situationActuelle" id="situationActuelle" cols="30" rows="10" placeholder="{{'daily_report_assist.situation' | translate}}" data-theme="e"></textarea>

    <h2>{{'daily_report_assist.meteo.title' | translate}}</h2>

    <fieldset>
       <select ng-model="rapport.meteo.court">
         <option value='Averses / pluie forte'>{{'daily_report_assist.meteo.showers' | translate}}</option>
         <option value='Rare averses'>{{'daily_report_assist.meteo.lightshowers' | translate}}</option>
         <option value='Orageux'>{{'daily_report_assist.meteo.stormy' | translate}}</option>
         <option value='Nuageux/couvert'>{{'daily_report_assist.meteo.cloudy' | translate}}</option>
         <option value='Peu nuageux'>{{'daily_report_assist.meteo.cloudsunny' | translate}}</option>
         <option value='Ensoleillé'>{{'daily_report_assist.meteo.sunny' | translate}}</option>
       </select>
       <input type="text" ng-model="rapport.meteo.desc" name="" placeholder="{{'daily_report_assist.meteo.description' | translate}}">
       <input type="text" ng-model="rapport.meteo.ville" name="" placeholder="{{'daily_report_assist.meteo.city' | translate}}">

    </fieldset>

    <h2>{{'daily_report_assist.means.title' | translate}}</h2>

    <h3>{{'daily_report_assist.means.men' | translate}}</h3>
    <fieldset data-ng-repeat="homme in rapport.hommes">
       <select ng-model="homme.grade">
         <option value=''>{{'daily_report_assist.means.rank' | translate}}</option>
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
       <input type="text" ng-model="homme.name" name="" placeholder="{{'daily_report_assist.means.resp' | translate}}">
       <input type="text" ng-model="homme.nombre" name="" placeholder="{{'daily_report_assist.means.amount' | translate}}">
    </fieldset>
    <button class="btn" ng-click="addNewHomme()">{{'daily_report_assist.means.add_field' | translate}}</button>


        <h3>{{'daily_report_assist.vehicles.title' | translate}}</h3>
        <fieldset data-ng-repeat="vehicule in rapport.vehicules">
           <input type="text" ng-model="vehicule.nombre" name="" placeholder="{{'daily_report_assist.vehicles.amount' | translate}}">
           <input type="text" ng-model="vehicule.modele" name="" placeholder="{{'daily_report_assist.vehicles.type' | translate}}">

        </fieldset>
        <button class="btn" ng-click="addNewVehicule()">{{'daily_report_assist.vehicles.add_field' | translate}}</button>



        <h3>{{'daily_report_assist.material.title' | translate}}</h3>
        <fieldset data-ng-repeat="mat in rapport.matos">
           <input type="text" ng-model="mat.nombre" name="" placeholder="{{'daily_report_assist.material.amount' | translate}}">
           <input type="text" ng-model="mat.modele" name="" placeholder="{{'daily_report_assist.material.description' | translate}}">
        </fieldset>
        <br>
        <button class="btn" ng-click="addNewMateriel()">{{'daily_report_assist.material.add_field' | translate}}</button>



        <h3>{{'daily_report_assist.missions.title' | translate}}</h3>
        <fieldset data-ng-repeat="mission in rapport.missions">
          <select ng-model="mission.section">
            <option value=''>{{'daily_report_assist.missions.by' | translate}}</option>
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

          <select id="missionTask" ng-model="mission.task" ng-options="task.label as task.label for task in tasks">
            <option value="">{{'daily_report_assist.missions.task' | translate}}</option>
          </select>

          <input type="text" ng-model="mission.description" name="" placeholder="{{'daily_report_assist.missions.description' | translate}}">
          <input type="text" ng-model="mission.lieu" name="" placeholder="{{'daily_report_assist.missions.location' | translate}}">
        </fieldset>
        <button class="btn" ng-click="addNewMission()">{{'daily_report_assist.missions.add_field' | translate}}</button>

        <h3>{{'daily_report_assist.sanitaryStatus.title' | translate}}</h3>
        <fieldset>
          <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
            <label class="btn btn-outline-success">
              <input ng-change="onChange($index)" type="radio" ng-model="rapport.sanitaryStatus.status" value="Bon">
              {{'daily_report_assist.sanitaryStatus.good' | translate}}
            </label>
            <label class="btn btn-outline-warning">
              <input ng-change="onChange($index)" type="radio" ng-model="rapport.sanitaryStatus.status"  value="Moyen">
              {{'daily_report_assist.sanitaryStatus.mean' | translate}}
            </label>
            <label class="btn btn-outline-danger">
              <input ng-change="onChange($index)" type="radio" ng-model="rapport.sanitaryStatus.status" value="Mauvais">
             {{'daily_report_assist.sanitaryStatus.bad' | translate}}
            </label>
          </div>
          <br>
          <input type="text" ng-model="rapport.sanitaryStatus.comment" name="" placeholder="{{'daily_report_assist.sanitaryStatus.comment' | translate}}">
        </fieldset>

        <br>

        <h3>{{'daily_report_assist.troopStatus.title' | translate}}</h3>
        <fieldset>
          <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
            <label class="btn btn-outline-success">
              <input ng-change="onChange($index)" type="radio" ng-model="rapport.troopStatus.status" value="Bon">
              {{'daily_report_assist.troopStatus.good' | translate}}
            </label>
            <label class="btn btn-outline-warning">
              <input ng-change="onChange($index)" type="radio" ng-model="rapport.troopStatus.status"  value="Moyen">
              {{'daily_report_assist.troopStatus.mean' | translate}}
            </label>
            <label class="btn btn-outline-danger">
              <input ng-change="onChange($index)" type="radio" ng-model="rapport.troopStatus.status" value="Mauvais">
              {{'daily_report_assist.troopStatus.bad' | translate}}
            </label>
          </div>
          <br>
          <input type="text" ng-model="rapport.troopStatus.comment" name="" placeholder="{{'daily_report_assist.troopStatus.comment' | translate}}">
        </fieldset>

        <br>

        <h3>{{'daily_report_assist.email.title' | translate}}</h3>
        <fieldset>
          <select id="email" ng-model="rapport.email" ng-options="email as email.label for email in zoneEmails">
            <option value="">{{'daily_report_assist.email.zone' | translate}}</option>
          </select>
          <br>
          <span>{{'daily_report_assist.email.note' | translate}}</span>
        </fieldset>

        <br>

        <button ng-click="submit()" type="submit" class="btn btn-primary">{{'daily_report_assist.send' | translate}}</button>

</form>

</main>
