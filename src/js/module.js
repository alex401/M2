var app = angular.module('PCIM2', ['ui.bootstrap', 'ui.router', 'ngCookies', 'pascalprecht.translate', 'ngSanitize']);

app.config(['$translateProvider', function ($translateProvider) {
  // add translation table
  $translateProvider
    .useStaticFilesLoader({
      prefix: '/dist/i18n/locale-',
      suffix: '.json'
    })
    .useSanitizeValueStrategy('sanitizeParameters')
    .fallbackLanguage('fr')
    .registerAvailableLanguageKeys(['en', 'de', 'fr'], {
      'en_*': 'en',
      'de_*': 'de',
      'fr_*': 'fr'
    })
    .determinePreferredLanguage()
    .useLocalStorage();
}]);

app.constant('config', {
  validationStatus: 'attente de validation',
  waitingStatus: 'attente de traitement',
  treatmentStatus: 'en traitement',
  transportStatus: 'en transport',
  waitingTransportStatus: 'attente de transport',
  deliveredStatus: 'livree',
  refusedStatus: 'refusée',
  cancelledStatus: 'annulée'
});



//used to use ngCookie but ended up with ipCookie, need to check what's up with that.
