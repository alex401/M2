<?php
    include("../login/isEnSession.php");

    echo ( $_SESSION["email_utilisateurformulaires"]  );

?>




<main class="col-sm-12 col-md-12" ng-controller="PisaCtrl">

  <div ng-if="status==1"> {{'competences.message.success' | translate}}</div>
  <div ng-if="status==2"> {{'competences.message.error' | translate}}</div>
  <div ng-if="status==3"> {{'competences.message.loading' | translate}} </div>



<form ng-submit="submit(personne)" ng-if="status == 0 ">
<div ng-if="personne != null">
<div class="form-group">
  <label for="formGroupNom">{{'competences.name' | translate}}</label>
  <input type="text" ng-model="personne.nom" class="form-control" id="formGroupNom">
</div>

<div class="form-group">
  <label for="formGroupNom">{{'competences.address' | translate}}</label>
  <input type="text" ng-model="personne.address" class="form-control" id="formGroupNom">
</div>

<div class="form-group">
  <label for="formGroupNom">{{'competences.zip' | translate}}</label>
  <input type="text" ng-model="personne.zip" class="form-control" id="formGroupNom">
</div>

<div class="form-group">
  <label for="formGroupNom">{{'competences.location' | translate}}</label>
  <input type="text" ng-model="personne.town" class="form-control" id="formGroupNom">
</div>

<div class="form-group">
  <label for="formGroupNom">{{'competences.mail' | translate}}</label>
  <input type="email" ng-model="personne.email" class="form-control" id="formGroupNom">

</div>
<div class="form-group">
  <label for="formGroupNom">{{'competences.phone' | translate}}</label>
  <input type="tel" ng-model="personne.phone" class="form-control" id="formGroupNom">
</div>

<div class="form-group row">
  <div class="col-md-3">
    <label for="urgence">{{'competences.emergency' | translate}}</label>
    <input type="tel" ng-model="personne.extra.nb" class="form-control" id="urgence" required>
  </div>
  <div class="col-md-3">
    <label for="parent">{{'competences.relationship' | translate}}</label>
    <select class="form-control" id="parent" ng-model="personne.extra.lp" ng-options="p.rowid as p.label for p in parentList" required>
      <option value="">{{'competences.selectRelation' | translate}}</option>
    </select>
  </div>
</div>

<label for="allergy"> {{'competences.allergie' | translate}} </label>
<div id="allergy" class="btn-group-toggle col-sm-12 col-md-12" data-toggle="buttons">
    <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="personne.allergie" value="Oui">
      Oui
     </label>
     <label class="btn btn-outline-secondary">
     <input type="radio" ng-model="personne.allergie"  value="Non">
      Non
     </label>
</div>

<div class="form-group">
  <label for="formGroupNom"> {{'competences.selectAllergie' | translate}} </label>
  <input type="text" ng-model="personne.selectAllergie" class="form-control" id="formGroupNom">
</div>



<div  class="from-group">
  <label for="formGroupNom">{{'competences.third.name' | translate}}</label>
  <input ng-change="loadTiers(personne.tier.nom)" type="text" ng-model="personne.tier.nom" class="form-control" id="formGroupNom">
</div>


<div ng-if="tiers.length > 0 && personne !== null" >
  <br>
  <ul  ng-click="onClickTier(tier)" class="list-group" ng-repeat="tier in tiers" >
    <li class="list-group-item active" >{{tier.nom}}</li>
    <li class="list-group-item" style="background-color:yellow">{{tier.zip}} {{tier.town}}</li>
    <li class="list-group-item" style="background-color:yellow">{{tier.email}}</li>
    <li class="list-group-item" style="background-color:yellow"  >{{tier.phone}}</li>
 </ul>
 <br>
</div>


<div ng-if="personne.tier !== null || tiers.length == 0" class="form-group">
  <label for="formGroupNom">{{'competences.third.address' | translate}}</label>
  <input type="text" ng-model="personne.tier.address" class="form-control" id="formGroupNom">
</div>

<div ng-if="personne.tier !== null || tiers.length == 0" class="form-group">
  <label for="formGroupNom">{{'competences.third.zip' | translate}}</label>
  <input type="text" ng-model="personne.tier.zip" class="form-control" id="formGroupNom">
</div>

<div ng-if="personne.tier !== null || tiers.length == 0" class="form-group">
  <label for="formGroupNom">{{'competences.third.town' | translate}}</label>
  <input type="text" ng-model="personne.tier.town" class="form-control" id="formGroupNom">
</div>

<div ng-if="personne.tier !== null || tiers.length == 0"class="form-group">
  <label for="formGroupNom">{{'competences.third.phone' | translate}}</label>
  <input type="text" ng-model="personne.tier.phone" class="form-control" id="formGroupNom">
</div>

<div ng-if="personne.tier !== null || tiers.length == 0"class="form-group">
  <label for="formGroupNom">{{'competences.third.email' | translate}}</label>
  <input type="text" ng-model="personne.tier.email" class="form-control" id="formGroupNom">
</div>
<div id ="toptags"></div>

<div class="form-group">
  <label for="formGroupNom"> {{'competences.iban' | translate}} </label>
  <input type="text" ng-model="personne.iban" class="form-control" id="formGroupNom">
</div>

<div class="btn-group-toggle col-sm-12 col-md-12" data-toggle="buttons">
    <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Compagnie">
      Compagnie
     </label>
     <label class="btn btn-outline-secondary">
     <input type="radio" ng-model="description"  value="Grade">
      Grade
     </label>
     <label class="btn btn-outline-secondary">
      <input type="radio" ng-model="description" value="Section Pci">
      Section
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Fonction Pci" >
      Fonction
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Metier">
      Métier
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="activite secondaire" >
      Activité secondaire
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Langue maternelle" >
      Langue maternelle
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Langue"  >
      Autres langues
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Permis">
      Permis
     </label>
     <label class="btn btn-outline-secondary">
      <input  type="radio" ng-model="description" value="Hobby">
      Hobby
     </label>
</div>


<div role="alert" ng-repeat="tag in tags" >
  <p ng-show="tag.description == description" class="alert" ng-class="{'alert-success': tag.checked == 'true' }" ng-click="actionTag(tag, $index)" ng-model="tagged" class="mb-0">{{ tag.label }}</p>
</div>


</div>


<button type="submit()" class="btn btn-primary btn-block" >{{'competences.send' | translate}}</button>

<br>

</form>

</main>
