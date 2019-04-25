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
                templateUrl: 'templates/menu_commandes.html'
            })
            .state('demande', {
                url: '/menu/demandes',
                templateUrl: 'templates/menu_demandes.html'
            })
            .state('formrepas', {
                url: '/form/repas',
                templateUrl: 'templates/form_repas.html'
            })
            .state('formcarburant', {
                url: '/form/carburant',
                templateUrl: 'templates/form_carburant.html'
            })
            .state('formmateriel', {
                url: '/form/materiel',
                templateUrl: 'templates/form_materiel.html'
            })
            .state('formsuivichantier', {
                url: '/form/suivichantier',
                templateUrl: 'templates/form_suivichantier.html'
            })
            .state('formtransport', {
                url: '/form/transport',
                templateUrl: 'templates/form_transport.html'
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
            .state('rapportsppam', {
                url: '/rapport/sppam',
                templateUrl: 'templates/rapport_sppam.php'
            })
            .state('commande', {
                url: '/administration/{type}',
                templateUrl: 'templates/administration/commandes.html'
            })
            .state('radios', {
                url: '/form/radios',
                templateUrl: 'templates/form_radios.html'
            })
            .state('administration', {
                url: '/administration',
                templateUrl: 'templates/administration/main.html'
            });
    }
]);
