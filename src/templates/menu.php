<?php
    include("../login/isEnSession.php");
?>

<main class="col-sm-12  col-md-12 ">

<?php if ($_SESSION["usertype_utilisateurformulaires"] == "user" || $_SESSION["usertype_utilisateurformulaires"] == "admin") : ?>

  <div class="form-group">
{{'menu.commands.title' | translate}}

<a class="btn btn-outline-secondary btn-block" href="#/commande/repas" role="button">{{'menu.commands.meal' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/commande/materiel" role="button">{{'menu.commands.material' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/commande/carburant" role="button">{{'menu.commands.fuel' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/commande/transport" role="button">{{'menu.commands.transport' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/radios" role="button">Radios</a>
<!-- <a class="btn btn-outline-secondary btn-block" href="#/form/radios0" role="button">Radios(date picker test)</a> -->
<a class="btn btn-outline-secondary btn-block" href="#/commandes/gestion" role="button">{{'menu.commands.management' | translate}}</a>
<!-- <a class="btn btn-outline-secondary btn-block" href="#/commandes/tracking" role="button">Suivi de Commandes</a> -->
<a class="btn btn-outline-secondary btn-block" href="#/commandes/search" role="button">{{'menu.commands.search' | translate}}</a>

Accès rapide recherche de tiers

<a class="btn btn-outline-secondary btn-block" href="#/admin/recherchetiers" role="button">{{'recherche.tiers.title' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/admin/recherchetags" role="button">{{'recherche.tags.title' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/admin/recherchecontacts" role="button"> {{'recherche.contact.title' | translate}}</a>

Accès rapide

<a class="btn btn-outline-secondary btn-block" href="#/form/demandeconge" role="button">Demande de congé</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/demandeassistance" role="button">Demande d'assistance</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/demandeavance" role="button">Demande d'avancement</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/rapportparking" role="button">Etat parking</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/etatcirculation" role="button">Etat de circulation</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/ctrlequipement" role="button">{{'menu.equipement' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/suivimachine" role="button">Suivi de machine</a>
<a class="btn btn-outline-secondary btn-block" href="#/form/entreeservice" role="button">{{'menu.competences' | translate}}</a>

{{'menu.admin.title' | translate}}
<!-- <a class="btn btn-outline-secondary btn-block" href="#/rapport/service" role="button">Rapport Journalier Section</a> -->
<a class="btn btn-outline-secondary btn-block" href="#/rapport/journalier" role="button">{{'menu.admin.daily_report' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/rapport/journalier/assistance" role="button">{{'menu.admin.daily_report_assist' | translate}}</a>
<a class="btn btn-outline-secondary btn-block" href="#/admin/listeappel" role="button">Liste d'appel</a>
<a class="btn btn-outline-secondary btn-block" href="#/admin/listeLicenciement" role="button"> Liste de libération / Licenciement </a>
<a class="btn btn-outline-secondary btn-block" href="#/admin/qualifications" role="button">Qualifications</a>
<a class="btn btn-outline-secondary btn-block" href="#/admin/attribMail" role="button"> Attributions mail </a>
<!-- <a class="btn btn-outline-secondary btn-block" href="#/form/etatgroupe" role="button"> Etat groupe </a> -->

</div>
<?php endif; ?>

</main>
