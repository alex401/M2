<?php
//******************************
// Rapports
//-----------------
//
// Rapport
//
//******************************

$app->get('/v1/rapport/getall', function ($request,$response) {



   try{
     if($report != null){
       $filejson = "log/".date("Ymd")."-formation.log";
       file_put_contents("$filejson",$dataT, FILE_APPEND);
       return $response->withJson(array('status' => 'OK', 'url' => $report),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant traitement du rapport '),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

//******************************
// Rapports
//-----------------
//
// Rapport
//
//******************************

$app->post('/v1/rapport/journalier/assistance', function ($request, $response) {

   $data = $request->getParsedBody();
   $dataT = (json_encode($data));
   //echo "$dataT";

   $situation = $data['situationActuelle'];
   $hommes = $data['hommes'];
   $missions = $data['missions'];
   $sanitaryStatus = $data['sanitaryStatus'];
   $troopStatus = $data['troopStatus'];
   $chantier = $data['chantier'];
   $matos = $data['matos'];
   $vehicules = $data['vehicules'];
   $meteo = $data['meteo'];
   $email = $data['email'];
   $comment = $data['comment'];

   $report = buildHtmlReportAssist($meteo, $situation, $vehicules, $matos, $chantier, "rapport-journalier-assistance", $hommes, $missions, $sanitaryStatus, $troopStatus, $comment);

   if ($email != null) {
     $mail = mailReport("Rapport du jour ", $report, "sud.commandement@pci-fr.ch", $email['addr']);
     if ($mail != 0) {
       return $response->withJson(array('status' => 'Erreur pendant traitement du rapport '), 422);
     }
   }

   try{
     if($report != null) {
       // $filejson = "log/".date("Ymd")."-formation.log";
       // file_put_contents("$filejson",$dataT, FILE_APPEND);
       return $response->withJson(array('status' => 'OK', 'url' => $report),200);
     }
     else {
       return $response->withJson(array('status' => 'Erreur pendant traitement du rapport '),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

// Créer rapport journalier en HTML
function buildHtmlReportAssist($meteo, $situation, $vehicules, $matos, $chantier, $filename, $hommes, $missions, $sanitaryStatus, $troopStatus, $comment) {

$content = '<!doctype html>

<html lang="fr">

 <style>

.blog-header {
  line-height: 1;
  border-bottom: 1px solid #e5e5e5;
}

.blog-header-logo {
  font-family: "Playfair Display", Georgia, "Times New Roman", serif;
  font-size: 2.25rem;
}

.blog-header-logo:hover {
  text-decoration: none;
}

h1, h2, h3, h4, h5, h6 {
  font-family: "Playfair Display", Georgia, "Times New Roman", serif;
}

.display-4 {
  font-size: 2.5rem;
}
@media (min-width: 768px) {
  .display-4 {
    font-size: 3rem;
  }
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

.nav-scroller .nav-link {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: .875rem;
}

.card-img-right {
  height: 100%;
  border-radius: 0 3px 3px 0;
}

.flex-auto {
  -ms-flex: 0 0 auto;
  flex: 0 0 auto;
}

.h-400 { height: 400px; }
@media (min-width: 768px) {
  .h-md-400 { height: 400px; }
}

.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }

.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }

/*
 * Blog name and description
 */
.blog-title {
  margin-bottom: 0;
  font-size: 2rem;
  font-weight: 400;
}
.blog-description {
  font-size: 1.1rem;
  color: #999;
}

@media (min-width: 40em) {
  .blog-title {
    font-size: 3.5rem;
  }
}

/* Pagination */
.blog-pagination {
  margin-bottom: 4rem;
}
.blog-pagination > .btn {
  border-radius: 2rem;
}

/*
 * Blog posts
 */

.blog-post {
  margin-bottom: 4rem;
}
.blog-post-title {
  margin-bottom: .25rem;
  font-size: 2.5rem;
}
.blog-post-meta {
  margin-bottom: 1.25rem;
  color: #999;
}

/*
 * Footer
 */
.blog-footer {
  padding: 2.5rem 0;
  color: #999;
  text-align: center;
  background-color: #f9f9f9;
  border-top: .05rem solid #e5e5e5;
}
.blog-footer p:last-child {
  margin-bottom: 0;
}

</style>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Rapport de la PCI</title>

    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">

          <div class="col-12 text-center">
            <a class="blog-header-logo text-dark" href="#">Rapport Journalier Assistance</a>
          </div>

        </div>
      </header>



      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
          <h1 class="display-4 font-italic">Mission: '.$chantier .'</h1>
          <p class="lead my-3">';
          if (!empty($comment)) {
            $content .= 'Dates concernées: '.$comment. '\r\n';
          }
          $content .=
          $situation .'</p>
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-400">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-primary">Météo</strong>
              <h3 class="mb-0">
                    <a class="text-dark" href="#">Météo de '. $meteo["ville"] .' </a>
                  </h3>
                  <div class="mb-1 text-muted"> '. $meteo["court"] .'</div>
                  <p class="card-text mb-auto">  '. $meteo["desc"] .' </p>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block"> <!-- data-src=" " alt="Card image cap"-->
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-400">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-success">Hommes</strong>
              <h3 class="mb-0">  </h3>
              ';

              foreach ($hommes as $value) {
                if($value["name"] != null){
                $content .=  ' <p class="card-text mb-auto">  '. $value["grade"] .' - '. $value["name"] .' + '. $value["nombre"] .' </p>';
                }
              }
              $content .= '
              <p class="card-text mb-auto">  </p>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block"> <!-- data-src=" " alt="Card image cap"-->
          </div>
        </div>
      </div>
    </div>

    <main role="main" class="container">
      <div class="row">
        <div class="col-md-8 blog-main">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            Description des missions
          </h3>


          ';

          foreach ($missions as $key => $value) {
            if($value["section"] != "" && $value["description"] != "" && $value["lieu"] != ""){

            $content .=  '<div class="blog-post">';
            $content .=  '  <h2 class="blog-post-title">'. $value["section"]  .' </h2>';
            $content .=  '  <p class="blog-post-meta"> '. $value["lieu"].'  - tâche '. $value["task"].' </p>';
            $content .=  '  <p>  '. $value["description"] .' </p>';
            $content .=  '  <hr> </div>';
          }
        }

        $content .= '

        <h3 class="pb-3 mb-4 font-italic border-bottom">
          État sanitaire
        </h3>';

        if($sanitaryStatus["status"] != "") {
          $content .=  '<div class="blog-post">';
          switch ($sanitaryStatus["status"]) {
            case "Bon":
              $content .=  '  <label class="btn btn-success">Bon</label>';
              break;
            case "Moyen":
              $content .=  '  <label class="btn btn-warning">Moyen</label>';
              break;
            case "Mauvais":
              $content .=  '  <label class="btn btn-danger">Mauvais</label>';
              break;
          }
          $content .=  '  <p class="blog-post-meta">'. $sanitaryStatus["comment"] .'</p>';
          $content .=  '  <hr> </div>';
        }

        $content .= '

        <h3 class="pb-3 mb-4 font-italic border-bottom">
          État des troupes
        </h3>';

        if($troopStatus["status"] != "") {
          $content .=  '<div class="blog-post">';
          switch ($troopStatus["status"]) {
            case "Bon":
              $content .=  '  <label class="btn btn-success">Bon</label>';
              break;
            case "Moyen":
              $content .=  '  <label class="btn btn-warning">Moyen</label>';
              break;
            case "Mauvais":
              $content .=  '  <label class="btn btn-danger">Mauvais</label>';
              break;
          }
          $content .=  '  <p class="blog-post-meta">'. $troopStatus["comment"] .'</p>';
          $content .=  '  <hr> </div>';
        }

        $content .= '

        </div><!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
          <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">Moyens engagés </h4>
            <h5 class="font-italic"> Vehicules </h5>
            '; foreach ($vehicules as $key => $value) {
              if($value["nombre"] != "" && $value["modele"] != ""){
              $content .=  ' <p class="mb-0">  '. $value["nombre"] .': '. $value["modele"] .' </p>';
            }
            }
            $content .= ' <h5 class="font-italic"> Matériel </h5>';

            foreach ($matos as $key => $value) {
              if($value["nombre"] != "" && $value["modele"] != ""){
              $content .=  ' <p class="mb-0">  '. $value["nombre"] .': '. $value["modele"] .' </p>';
            }
          }


            $content .= '  </div>

          <div class="p-3">
            <h4 class="font-italic">Nous contacter</h4>
            <ol class="list-unstyled">
              <li><a href="mailto:info.sud@pci-fr.ch"> info.sud@pci-fr.ch </a></li>
            </ol>
          </div>
        </aside><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </main><!-- /.container -->

    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
  </body>
</html>';


  $file = "rapports/".date("Ymd-h:i:s")."-$filename.html";
  //Build HTML
  file_put_contents("../$file", $content, FILE_APPEND);
  return "https://pci-fr.ch/m2/$file";
}

$app->post('/v1/rapport/journalier', function ($request,$response) {

   $data = $request->getParsedBody();
   $dataT = (json_encode($data));
   //echo "$dataT";

   $situation = $data['situationActuelle'];
   $hommes = $data['hommes'];
   $missions = $data['missions'];
   $missionTransmises = $data['missionsTransmises'];
   $formation = $data['formation'];
   $matos = $data['matos'];
   $vehicules = $data['vehicules'];
   $meteo = $data['meteo'];

   $report = buildHtmlReport($meteo, $situation, $vehicules, $matos ,$formation, "rapport-journalier", $hommes, $missions, $missionTransmises);
   $mail = mailReport("Rapport du jour ", $report, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");

   try{
     if($report != null){
       $filejson = "log/".date("Ymd")."-formation.log";
       file_put_contents("$filejson",$dataT, FILE_APPEND);
       return $response->withJson(array('status' => 'OK', 'url' => $report),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant traitement du rapport '),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

// Créer rapport journalier en HTML
function buildHtmlReport($meteo, $situation, $vehicules, $matos ,$formation, $filename, $hommes, $missions, $missionTransmises){

$content = '<!doctype html>

<html lang="fr">

 <style>

.blog-header {
  line-height: 1;
  border-bottom: 1px solid #e5e5e5;
}

.blog-header-logo {
  font-family: "Playfair Display", Georgia, "Times New Roman", serif;
  font-size: 2.25rem;
}

.blog-header-logo:hover {
  text-decoration: none;
}

h1, h2, h3, h4, h5, h6 {
  font-family: "Playfair Display", Georgia, "Times New Roman", serif;
}

.display-4 {
  font-size: 2.5rem;
}
@media (min-width: 768px) {
  .display-4 {
    font-size: 3rem;
  }
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

.nav-scroller .nav-link {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: .875rem;
}

.card-img-right {
  height: 100%;
  border-radius: 0 3px 3px 0;
}

.flex-auto {
  -ms-flex: 0 0 auto;
  flex: 0 0 auto;
}

.h-400 { height: 400px; }
@media (min-width: 768px) {
  .h-md-400 { height: 400px; }
}

.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }

.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }

/*
 * Blog name and description
 */
.blog-title {
  margin-bottom: 0;
  font-size: 2rem;
  font-weight: 400;
}
.blog-description {
  font-size: 1.1rem;
  color: #999;
}

@media (min-width: 40em) {
  .blog-title {
    font-size: 3.5rem;
  }
}

/* Pagination */
.blog-pagination {
  margin-bottom: 4rem;
}
.blog-pagination > .btn {
  border-radius: 2rem;
}

/*
 * Blog posts
 */

.blog-post {
  margin-bottom: 4rem;
}
.blog-post-title {
  margin-bottom: .25rem;
  font-size: 2.5rem;
}
.blog-post-meta {
  margin-bottom: 1.25rem;
  color: #999;
}

/*
 * Footer
 */
.blog-footer {
  padding: 2.5rem 0;
  color: #999;
  text-align: center;
  background-color: #f9f9f9;
  border-top: .05rem solid #e5e5e5;
}
.blog-footer p:last-child {
  margin-bottom: 0;
}

</style>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Rapport de la PCI</title>

    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">

          <div class="col-12 text-center">
            <a class="blog-header-logo text-dark" href="#">Rapport Journalier</a>
          </div>

        </div>
      </header>



      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
          <h1 class="display-4 font-italic">Mission: '.$formation .'</h1>
          <p class="lead my-3">'.$situation .'</p>
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-400">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-primary">Météo</strong>
              <h3 class="mb-0">
                    <a class="text-dark" href="#">Météo de '. $meteo["ville"] .' </a>
                  </h3>
                  <div class="mb-1 text-muted"> '. $meteo["court"] .'</div>
                  <p class="card-text mb-auto">  '. $meteo["desc"] .' </p>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block"> <!-- data-src=" " alt="Card image cap"-->
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-400">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-success">Hommes</strong>
              <h3 class="mb-0">  </h3>
              ';

              foreach ($hommes as $value) {
                if($value["name"] != null){
                $content .=  ' <p class="card-text mb-auto">  '. $value["grade"] .' - '. $value["name"] .' + '. $value["nombre"] .' </p>';
                }
              }
              $content .= '
              <p class="card-text mb-auto">  </p>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block"> <!-- data-src=" " alt="Card image cap"-->
          </div>
        </div>
      </div>
    </div>

    <main role="main" class="container">
      <div class="row">
        <div class="col-md-8 blog-main">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            Description des missions
          </h3>


          ';

          foreach ($missions as $key => $value) {
            if($value["section"] != "" && $value["description"] != "" && $value["lieu"] != ""){

            $content .=  '<div class="blog-post">';
            $content .=  '  <h2 class="blog-post-title">'. $value["section"]  .' </h2>';
            $content .=  '  <p class="blog-post-meta"> '. $value["lieu"].'  - avancement '. $value["avancement"].' </p>';
            $content .=  '  <p>  '. $value["description"] .' </p>';
            $content .=  '  <hr> </div>';
          }
        }
          $content .= '

          <h3 class="pb-3 mb-4 font-italic border-bottom">
            Missions transmises
          </h3>';

          foreach ($missionTransmises as $key => $value) {
            if($value["description"] != "" && $value["lieu"] != ""){

            $content .=  '<div class="blog-post">';
            $content .=  '  <h2 class="blog-post-title">'. $value["lieu"] .' </h2>';
            $content .=  '  <p class="blog-post-meta">25 Janvier 2018 </p>';
            $content .=  ' '. $value["description"] .' </p>';
            $content .=  '  <hr> </div>';
          }
          }

          $content .= '

        </div><!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
          <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">Moyens engagés </h4>
            <h5 class="font-italic"> Vehicules </h5>
            '; foreach ($vehicules as $key => $value) {
              if($value["nombre"] != "" && $value["modele"] != ""){
              $content .=  ' <p class="mb-0">  '. $value["nombre"] .': '. $value["modele"] .' </p>';
            }
            }
            $content .= ' <h5 class="font-italic"> Matériel </h5>';

            foreach ($matos as $key => $value) {
              if($value["nombre"] != "" && $value["modele"] != ""){
              $content .=  ' <p class="mb-0">  '. $value["nombre"] .': '. $value["modele"] .' </p>';
            }
          }


            $content .= '  </div>

          <div class="p-3">
            <h4 class="font-italic">Nous contacter</h4>
            <ol class="list-unstyled">
              <li><a href="mailto:info.sud@pci-fr.ch"> info.sud@pci-fr.ch </a></li>
            </ol>
          </div>
        </aside><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </main><!-- /.container -->

    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
  </body>
</html>';



  $file = "rapports/".date("Ymd-h:i:s")."-$filename.html";
  //Build HTML
   file_put_contents("../$file",$content, FILE_APPEND);
   return "https://pci-fr.ch/m2/$file";

}
