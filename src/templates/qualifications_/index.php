<?php
require("../../login/config.php");


$formation = trim(utf8_decode(addslashes(htmlspecialchars(isset($_GET['formation']) ? $_GET['formation'] : ''))));
$session = trim(utf8_decode(addslashes(htmlspecialchars(isset($_GET['session']) ? $_GET['session'] : ''))));

$DatabaseAccessProvider = connectToDolibarrDB();
?>

<main class="col-sm-12  col-md-12 " ng-controller="RapportCtrl">

<script type="text/javascript">
    <!--
    function MM_jumpMenu(targ,selObj,restore){ //v3.0
        eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        if (restore) selObj.selectedIndex=0;
    }
    //-->
</script>

<h3>Qualification (DB dolibarr)</h3>
<form name="form_recherche" method="post" action="mail_form.php" >
	<label for="formationS" class="ui-hidden-accessible">Formation</label>
	<select id="formationS" name="formationS" onChange="MM_jumpMenu('parent',this,0)">
		<option value="">Choisissez une formation</option>
<?php
		$result = mysqli_query($DatabaseAccessProvider, "SELECT rowId, intitule FROM llx_agefodd_formation_catalogue WHERE archive=0 AND intitule != '' ORDER BY intitule");
		while ($rec = mysqli_fetch_array($result)) {
			$rowId = $rec["rowId"];
			$intitule = $rec["intitule"];

			$selected = "";
			if ($formation == $rowId) {
				$selected = "selected";
			}

			echo '<option value="index.php?formation=' . $rowId . '" ' . $selected . '>' . $intitule . '</option>';
		}
?>
	</select>

	<label for="sessionS" class="ui-hidden-accessible">Session</label>
	<select id="sessionS" name="sessionS" onChange="MM_jumpMenu('parent',this,0)">
		<option value="">Choisissez une session</option>
<?php
	if ($formation != "") {
		$sql = "SELECT session.rowid, DATE_FORMAT(session.dated, '%Y.%m.%d'), DATE_FORMAT(session.datef, '%Y.%m.%d'), socpeople.firstname, socpeople.lastname " .
			"FROM llx_agefodd_session_formateur as sessionformateur, llx_agefodd_session as session, llx_agefodd_formateur as formateur, llx_socpeople as socpeople " .
			"WHERE " .
			"session.status <> 4 AND " .
			"session.fk_formation_catalogue = " . $formation . " AND " .
			"sessionformateur.fk_session = session.rowid AND " .
			"sessionformateur.fk_agefodd_formateur = formateur.rowid AND " .
			"formateur.fk_socpeople = socpeople.rowid " .
			"ORDER BY session.dated, session.datef, session.rowid, socpeople.firstname, socpeople.lastname";
		$result = mysqli_query($DatabaseAccessProvider, $sql);

		$oldSessionRowId = -1;

		while ($rec = mysqli_fetch_array($result)) {
			$sessionrowId = $rec[0];
			$sessiondatedebut = $rec[1];
			$sessiondatefin = $rec[2];
			$firstname = $rec[3];
			$lastname = $rec[4];

			$selected = "";
			if ($session == $sessionrowId) {
			    $selected = "selected";
			}

			if ($oldSessionRowId != $sessionrowId && $oldSessionRowId != -1) {
			    echo '</option>';
			}

			if ($oldSessionRowId != $sessionrowId) {
			    echo '<option value="index.php?formation=' . $formation . '&session=' . $sessionrowId . '" ' . $selected . '>' .
			    $sessiondatedebut . " - " . $sessiondatefin . ": " . $firstname . " " . $lastname;
			}

			if ($oldSessionRowId == $sessionrowId && $oldSessionRowId != -1) {
			    echo ", " . $firstname . " " . $lastname;
			}

			$oldSessionRowId = $sessionrowId;
		}

		if ($sessionrowId != -1) {
		    echo '</option>';
		}
	}
?>
	</select>
<?php
	if ($session != "") {
		// Display stagiaire
		$sql = "SELECT stagiaire.rowid, stagiaire.nom, stagiaire.prenom, stagiaire.civilite, stagiaire.tel2".
			" FROM llx_agefodd_session_stagiaire as sessionstagiaire, llx_agefodd_stagiaire as stagiaire ".
			" WHERE " .	"sessionstagiaire.fk_session_agefodd = " . $session .
			" AND sessionstagiaire.fk_stagiaire = stagiaire.rowid " .
			" ORDER BY stagiaire.nom, stagiaire.prenom";
?>
	<label for="Stagiaire" class="ui-hidden-accessible">Stagiaire</label>
	<select id="stagiaire" name="stagiaire">
		<option value="">Choisissez un stagiaire</option>
<?php
		$result = mysqli_query($DatabaseAccessProvider, $sql);
		$i = 0;
		while ($rec = mysqli_fetch_array($result)) {
			$rowid = ucwords(strtolower($rec[0]));
			$nom = ucwords(strtolower($rec[1]));
			$prenom = $rec[2];
			$grade = $rec[3];
			$tel2 = $rec[4];
			print '<option value="'.$rowid.'">' . $nom . ' ' . $prenom .'&nbsp;(' . $grade . ')</option>';
			$i++;
		}
    }
?>
	</select>
	<br>
	<ul data-role="listview" data-inset="true">
		<li>
			<label for="comportement4">3 = Tres bon</label>
			<label for="comportement3">2 = Bon</label>
			<label for="comportement2">1 = Suffisant</label>
			<label for="comportement1">0 = Insuffisant</label>
		</li>
		<li data-role="list-divider">Connaissances de base :</li>
		<li>
			<label for="Comportement"><strong>Comportement</strong>, attitude</label>
    		<input data-mini="true" type="range" name="Comportement" id="Comportement" min="0" max="3" value="0">
		</li>
		<li>
			<label for="Motivation">Motivation, engagement, <br>entreprenant</label>
    		<input data-mini="true" type="range" name="Motivation" id="Motivation" min="0" max="3" value="0">
		</li>
		<li>
			<label for="Connaissances"><strong>Connaissances techniques</strong></label>
    		<input data-mini="true" type="range" name="Connaissances" id="Connaissances" min="0" max="3" value="0">
		</li>
		<li>
			<label for="Faculte"><strong>Facult&eacute; d'expression</strong></label>
    		<input data-mini="true" type="range" name="Faculte" id="Faculte" min="0" max="3" value="0">
		</li>
		<li>
			<label for="Aptitude"><strong>Aptitude &agrave; la fonction</strong></label>
    		<input data-mini="true" type="range" name="Aptitude" id="Aptitude" min="0" max="3" value="0">
		</li>
		<li>
			<label for="Appreciation"><strong>Appr&eacute;ciation globale</strong></label>
    		<input data-mini="true" type="range" name="Appreciation" id="Appreciation" min="0" max="3" value="0">
		</li>

		<li data-role="list-divider">Sp&eacute;cialistes et Cadres</li>
		<li>
			<label for="Situation"><strong>Capacit&eacute; d'appr&eacute;ciation <br>de la situation</strong></label>
    		<input data-mini="true" type="range" name="Situation" id="Situation" min="0" max="3" value="0">
		</li>
		<li>
			<label for="decision"><strong>Capacit&eacute; de d&eacute;cision</strong></label>
    		<input data-mini="true" type="range" name="decision" id="decision" min="0" max="3" value="0">
		</li>
		<li>
			<label for="instruire"><strong>Capacit&eacute; d'instruire</strong></label>
    		<input data-mini="true" type="range" name="instruire" id="instruire" min="0" max="3" value="0">
		</li>
		<li>
			<label for="conduire"><strong>Aptitude &agrave; conduire</strong></label>
    		<input data-mini="true" type="range" name="conduire" id="conduire" min="0" max="3" value="0">
		</li>
		<li>
			<label for="fonction"><strong>Aptitude &agrave; la fonction</strong></label>
    		<input data-mini="true" type="range" name="fonction" id="fonction" min="0" max="3" value="0">
		</li>
		<li>
			<label for="AppreciationCadre"><strong>Appr&eacute;ciation globale</strong></label>
			<input data-mini="true" type="range" name="AppreciationCadre" id="AppreciationCadre" min="0" max="3" value="0">
		</li>
		<li data-role="list-divider">Proposition d'avancement</li>
		<li>
			<label for="Proposition">ou d'intruction compl&eacute;mentaire</label>
		    <select id="Proposition" name="Proposition" data-role="slider" data-mini="true">
        		<option value="Non">Non</option>
        		<option value="Oui">Oui</option>
    		</select>
		</li>

	</ul>
	<br>
	<label for="commentaires" class="ui-hidden-accessible">Commentaires</label>
	<textarea name="commentaires" id="commentaires" cols="30" rows="10" placeholder="Commentaires" data-theme="e"></textarea>
	<input type="hidden" name="formation" value="<?php echo $formation; ?> "/>
	<input type="hidden" name="session" value="<?php echo $session; ?> "/>
    <button id="submit" type="submit">Envoyer</button>
</form>

<?php
mysqli_close($DatabaseAccessProvider);

?>

</main>
