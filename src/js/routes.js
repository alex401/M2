'use strict';

/**
 * Route configuration
 */
angular.module('PCIM2').config(['$stateProvider', '$urlRouterProvider','$locationProvider',
    function($stateProvider, $urlRouterProvider, $locationProvider) {

        // For unmatched routes
        $urlRouterProvider.otherwise('/');
        $locationProvider.hashPrefix('');

        // Application routes
        $stateProvider
            .state('index', {
                url: '/',
                templateUrl: 'templates/menu.html'
            })
            .state('commandes', {
                url: '/menu/commandes',
                templateUrl: 'templates/commandes/creation/menu_commandes.html'
            })
            .state('demande', {
                url: '/menu/demandes',
                templateUrl: 'templates/menu_demandes.html'
            })
            .state('cmdrepas', {
                url: '/commande/repas',
                templateUrl: 'templates/commandes/creation/cmd_repas.html'
            })
            .state('cmdcarburant', {
                url: '/commande/carburant',
                templateUrl: 'templates/commandes/creation/cmd_carburant.html'
            })
            .state('cmdmateriel', {
                url: '/commande/materiel',
                templateUrl: 'templates/commandes/creation/cmd_materiel.html'
            })
            .state('formsuivichantier', {
                url: '/form/suivichantier',
                templateUrl: 'templates/form_suivichantier.html'
            })
            .state('cmdtransport', {
                url: '/commande/transport',
                templateUrl: 'templates/commandes/creation/cmd_transport.html'
            })
            .state('recherchetiers', {
                url: '/admin/recherchetiers',
                templateUrl: 'templates/recherche_tiers.html'
            })
            .state('recherchetags', {
                url: '/admin/recherchetags',
                templateUrl: 'templates/recherche_tags.html'
            })
            .state('conge', {
                url: '/form/demandeconge',
                templateUrl: 'templates/form_demandeconge.html'
            })
            .state('assistance', {
                url: '/form/demandeassistance',
                templateUrl: 'templates/form_demandeassistance.html'
            })
            .state('demandeavance', {
                url: '/form/demandeavance',
                templateUrl: 'templates/form_demandeavancement.html'
            })
            .state('rapportparking', {
                url: '/form/rapportparking',
                templateUrl: 'templates/form_rapportparking.html'
            })
            .state('entreeservice', {
                url: '/form/entreeservice',
                templateUrl: 'templates/form_entreeservice.html'
            })
            .state('qualifications', {
              url: '/admin/qualifications',
              templateUrl: 'templates/form_qualifications.html'
            })
            .state('etatcirculation', {
                url: '/form/etatcirculation',
                templateUrl: 'templates/form_etatcirculation.html'
            })
            .state('suivimachine', {
                url: '/form/suivimachine',
                templateUrl: 'templates/form_suivimachine.html'
            })
            .state('fichetransport', {
                url: '/admin/fichetransport',
                templateUrl: 'templates/form_fichetransport.html'
            })
            .state('ctrlequipement', {
                url: '/form/ctrlequipement',
                templateUrl: 'templates/form_ctrlequipement.html'
            })
            .state('suivichantier', {
                url: '/form/suivichantier',
                templateUrl: 'templates/form_suivichantier.html'
            })
            .state('rapportserviceinterne', {
                url: '/rapport/serviceinterne',
                templateUrl: 'templates/rapport_serviceinterne.html'
            })
            .state('rapportjournalier', {
                url: '/rapport/journalier',
                templateUrl: 'templates/rapport_journalier.php'
            })
            .state('rapportjournalierold', {
                url: '/rapport/journalierold',
                templateUrl: 'templates/rapport_journalier_old.php'
            })
            .state('rapportservice', {
                url: '/rapport/service',
                templateUrl: 'templates/rapport_service.html'
            })
            .state('listeappel', {
                url: '/admin/listeappel',
                templateUrl: 'templates/liste_appel.html'
            })
            .state('listelicenciement', {
                url: '/admin/listeLicenciement',
                templateUrl: 'templates/liste_licenciement.html'
            })
            .state('rapportsppam', {
                url: '/rapport/sppam',
                templateUrl: 'templates/rapport_sppam.php'
            })
            .state('tracking', {
                url: '/commandes/tracking/{type}',
                templateUrl: 'templates/commandes/tracking/cmd_tracking.html'
            })
            .state('radios', {
                url: '/form/radios',
                templateUrl: 'templates/form_radios.html'
            })
            .state('radios0', {
                url: '/form/radios0',
                templateUrl: 'templates/form_radios0.html'
            })
            .state('trackingmenu', {
                url: '/commandes/tracking',
                templateUrl: 'templates/commandes/tracking/menu_tracking.html'
            })
            .state('gestionmenu', {
                url: '/commandes/gestion',
                templateUrl: 'templates/commandes/gestion/menu_gestion.html'
            })
            .state('gestion', {
                url: '/commandes/gestion/{type}',
                templateUrl: 'templates/commandes/gestion/cmd_gestion.html'
            })
            .state('cmddetails', {
                url: '/commandes/details/{id}',
                templateUrl: 'templates/commandes/details.html'
            })
            .state('gestioncmddetailsaidecmdt', {
                url: '/commandes/gestion/{t}/details/{id}',
                templateUrl: 'templates/commandes/details.html'
            })
            .state('cmdsearch', {
                url: "/commandes/search",
                templateUrl: 'templates/commandes/menu_search.html'
            })
            .state('warnings', {
              url: "/superadmin/warnings",
              templateUrl: 'templates/superadmin/warnings.html'
            })
            .state('logins', {
                url: '/superadmin/logins',
                templateUrl: 'templates/superadmin/logins.html'
            })
            .state('etatgroupe', {
              url: '/form/etatgroupe',
              templateUrl: 'templates/form_etatgroupe.html'
            })
            .state('mails', {
                url: '/superadmin/mails',
                templateUrl: 'templates/superadmin/attributionMail.html'
            });
    }
]);
