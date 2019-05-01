var app = angular.module('PCIM2', ['ui.bootstrap', 'ui.router']);

app.constant('config', {
  validationStatus: 'attente de validation',
  waitingStatus: 'attente de traitement',
  treatmentStatus: 'en traitement',
  transportStatus: 'en transport',
  waitingTransportStatus: 'attente de transport',
  deliveredStatus: 'livree',
  refusedStatus: 'refusée'
});



//used to use ngCookie but ended up with ipCookie, need to check what's up with that.
