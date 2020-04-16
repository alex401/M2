
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
         <option value='Averses / pluie forte'>Averses / pluie forte</option>
         <option value='Rare averses'>Rare averses</option>
         <option value='Orageux'>Orageux</option>
         <option value='Nuageux/couvert'>Nuageux/couvert</option>
         <option value='Peu nuageux'>Peu nuageux</option>
         <option value='Ensoleillé'>Ensoleillé</option>
       </select>
       <input type="text" ng-model="rapport.meteo.desc" name="" placeholder="{{'daily_report_assist.meteo.description' | translate}}">
       <input type="text" ng-model="rapport.meteo.ville" name="" placeholder="{{'daily_report_assist.meteo.city' | translate}}">

    </fieldset>

    <h2>{{'daily_report_assist.means.title' | translate}}</h2>

    <h3>{{'daily_report_assist.means.men' | translate}}</h3>
    <fieldset data-ng-repeat="homme in rapport.hommes">
      <select ng-model="homme.grade">
        <option value=''>{{'daily_report_assist.means.rank.choose' | translate}}</option>
        <option value='Soldat'>{{'daily_report_assist.means.rank.std' | translate}}</option>
        <option value='Appointe'>{{'daily_report_assist.means.rank.app' | translate}}</option>
        <option value='Caporal'>{{'daily_report_assist.means.rank.cpl' | translate}}</option>
        <option value='Sergent'>{{'daily_report_assist.means.rank.sgt' | translate}}</option>
        <option value='Sergent-major'>{{'daily_report_assist.means.rank.sgtm' | translate}}</option>
        <option value='Fourrier'>{{'daily_report_assist.means.rank.four' | translate}}</option>
        <option value='Lieutenant'>{{'daily_report_assist.means.rank.lt' | translate}}</option>
        <option value='Premier-Lieutenant'>{{'daily_report_assist.means.rank.plt' | translate}}</option>
        <option value='Capitaine'>{{'daily_report_assist.means.rank.cap' | translate}}</option>
        <option value='Major'>{{'daily_report_assist.means.rank.maj' | translate}}</option>
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
            <option value=''>{{'daily_report_assist.missions.by.title' | translate}}</option>
            <option value='Etat-Major'>{{'daily_report_assist.missions.by.e-m' | translate}}</option>
            <option value='AIC 1 - Renseignement'>{{'daily_report_assist.missions.by.AICrens' | translate}}</option>
            <option value='AIC 1 - Média'>{{'daily_report_assist.missions.by.AICmed' | translate}}</option>
            <option value='AIC 1 - Chancellerie'>{{'daily_report_assist.missions.by.AICchanc' | translate}}</option>
            <option value='AIC 2 - Télématique'>{{'daily_report_assist.missions.by.AICtele' | translate}}</option>
            <option value='AIC 2 - Informatique'>{{'daily_report_assist.missions.by.AICinfo' | translate}}</option>
            <option value='Circulation'>{{'daily_report_assist.missions.by.circ' | translate}}</option>
            <option value='Logistique - Fourrier'>{{'daily_report_assist.missions.by.logfour' | translate}}</option>
            <option value='Logistique - Infrastructure'>{{'daily_report_assist.missions.by.loginfra' | translate}}</option>
            <option value='Logistique - Subsistance'>{{'daily_report_assist.missions.by.logsub' | translate}}</option>
            <option value='Logistique - Materiel'>{{'daily_report_assist.missions.by.logmat' | translate}}</option>
            <option value='Logistique - Transport'>{{'daily_report_assist.missions.by.logtrans' | translate}}</option>
            <option value='Assistance 1'>{{'daily_report_assist.missions.by.Assist' | translate}} 1</option>
            <option value='Assistance 2'>{{'daily_report_assist.missions.by.Assist' | translate}} 2</option>
            <option value='Assistance 3'>{{'daily_report_assist.missions.by.Assist' | translate}} 3</option>
            <option value='Appui 1'>{{'daily_report_assist.missions.by.Appui' | translate}} 1</option>
            <option value='Appui 2'>{{'daily_report_assist.missions.by.Appui' | translate}} 2</option>
            <option value='Appui 3'>{{'daily_report_assist.missions.by.Appui' | translate}} 3</option>
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
