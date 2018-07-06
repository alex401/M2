<?php
$genrecours = addslashes(htmlspecialchars(isset($_POST['genrecours']) ? $_POST['genrecours'] : ''));
$dateentreeservice_jour = addslashes(htmlspecialchars(isset($_POST['dateentreeservice_jour']) ? $_POST['dateentreeservice_jour'] : ''));
$dateentreeservice_mois = addslashes(htmlspecialchars(isset($_POST['dateentreeservice_mois']) ? $_POST['dateentreeservice_mois'] : ''));
$dateentreeservice_annee = addslashes(htmlspecialchars(isset($_POST['dateentreeservice_annee']) ? $_POST['dateentreeservice_annee'] : ''));
$datelicenciement_jour = addslashes(htmlspecialchars(isset($_POST['datelicenciement_jour']) ? $_POST['datelicenciement_jour'] : ''));
$datelicenciement_mois = addslashes(htmlspecialchars(isset($_POST['datelicenciement_mois']) ? $_POST['datelicenciement_mois'] : ''));
$datelicenciement_annee = addslashes(htmlspecialchars(isset($_POST['datelicenciement_annee']) ? $_POST['datelicenciement_annee'] : ''));
$dateentreeservice_jour = addslashes(htmlspecialchars(isset($_POST['dateentreeservice_jour']) ? $_POST['dateentreeservice_jour'] : ''));
$dateentreeservice_jour = addslashes(htmlspecialchars(isset($_POST['dateentreeservice_jour']) ? $_POST['dateentreeservice_jour'] : ''));
$dateEntree = $dateentreeservice_jour . "." . $dateentreeservice_mois . "." . $dateentreeservice_annee;
$dateLicenciement = $datelicenciement_jour . "." . $datelicenciement_mois . "." . $datelicenciement_annee;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Questionnaire de qualification</title>
        <link href="form.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="QQualification">
        <?php
        for ($i = 0; $i < count($tableauPersonne); $i++) {
            $result = mysqli_query($DatabaseAccessProvider, "SELECT * FROM personne WHERE avs='" . $tableauPersonne[$i] . "'");
            $rec = mysqli_fetch_array($result);
            $avs = $rec["avs"];
            $nom = $rec["nom"];
            $prenom = $rec["prenom"];
            $adresse = $rec["adresse"];
            $npa = $rec["npa"];
            $localite = $rec["ville"];
            $affectation = $rec["affectation"];
            $incorporation = $rec["incorporation"];

            if ($i > 0) {
                echo"<br clear=all style='page-break-before:always'>";
            }
            include("header.php");
            ?>
            <div class="formTitle">Qualification&nbsp;</div>
            <table width="100%" cellpadding="0px" class="tableBorderQQualification">
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="50%">N&deg; AVS</td>
                    <td width="50%">&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $avs; ?>&nbsp;</td>
                    <td>Monsieur&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $nom . " " . $prenom; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>Incorporation</td>
                    <td><?php echo $adresse; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $incorporation; ?>&nbsp;</td>
                    <td><?php echo $npa . " " . $localite; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Bulle, le <?php echo date("d.m.y"); ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Date d'entr&eacute;e en service</td>
                    <td>Date de licenciement</td>
                </tr>
                <tr>
                    <td><?php echo $dateEntree; ?>&nbsp;</td>
                    <td><?php echo $dateLicenciement; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Genre de cours</td>
                    <td>Fonction</td>
                </tr>
                <tr>
                    <td><?php echo $genrecours; ?>&nbsp;</td>
                    <td><?php echo $affectation; ?>&nbsp;</td>
                </tr>
            </table>
            <br />
            <table width="100%" class="tableBorderQQualificationCaseACocher" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="cellRightBorder" width="40%"><p><strong>Comportement</strong>, attitude</p></td>
                    <td class="cellRightBorder" valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Tr&egrave;s bon</p></td>
                    <td class="cellRightBorder" valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Bon</p></td>
                    <td class="cellRightBorder" valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Suffisant</p></td>
                    <td valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Insuffisant</p></td>
                </tr>
                <tr>
                    <td class="cellRightTopBorder" valign="middle"><p><strong>Motivation</strong>, engagement, entreprenant</p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td class="cellRightTopBorder" valign="middle"><p><strong>Connaissances techniques</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td class="cellRightTopBorder" valign="middle"><p><strong>Facult&eacute; d'expression</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td class="cellRightTopBorder" valign="middle"><p><strong>Aptitude &agrave; la fonction</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td class="cellRightTopBorder" valign="middle"><p><strong>Appr&eacute;ciation globale</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
            </table>
            <br />
            Sp&eacute;cialistes et Cadres
            <table width="100%" class="tableBorderQQualificationCaseACocher" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="cellRightBorder" width="271" valign="middle"><p><strong>Capacit&eacute; d'appr&eacute;ciation de la situation</strong> </p></td>
                    <td class="cellRightBorder" valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Tr&egrave;s bon</p></td>
                    <td class="cellRightBorder" valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Bon</p></td>
                    <td class="cellRightBorder" valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Suffisant</p></td>
                    <td valign="top" width="15%"><p align="center"><input type="checkbox" name="checkbox"/>Insuffisant</p></td>
                </tr>
                <tr>
                    <td width="271" valign="middle" class="cellRightTopBorder" ><p><strong>Capacit&eacute; de d&eacute;cision</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td width="271" valign="middle" class="cellRightTopBorder" ><p><strong>Capacit&eacute; d'instruire</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td width="271" valign="middle" class="cellRightTopBorder" ><p><strong>Aptitude &agrave; conduire</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td width="271" valign="middle" class="cellRightTopBorder" ><p><strong>Aptitude &agrave; la fonction</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
                <tr>
                    <td width="271" valign="middle" class="cellRightTopBorder" ><p><strong>Appr&eacute;ciation globale</strong></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellRightTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                    <td class="cellTopBorder" valign="top"><p align="center"><input type="checkbox" name="checkbox"/></p></td>
                </tr>
            </table>
            <br />
            <table class="tableBorderQQualificationCaseACocher"  border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td colspan="3" valign="middle"><p>Proposition d'avancement ou d'instruction compl&eacute;mentaire</p></td>
                </tr>
                <tr>
                    <td valign="top" width="30%" class="cellRightTopBorder" ><p align="center"><input type="checkbox" name="checkbox"/>Oui</p></td>
                    <td valign="top" width="30%" class="cellRightTopBorder" ><p align="center"><input type="checkbox" name="checkbox"/>Non</p></td>
                    <td valign="middle" width="30%" class="cellTopBorder" ><p>Doit &ecirc;tre appr&eacute;ci&eacute;e par    le cdt PCi</p></td>
                </tr>
                <tr>
                    <td valign="middle" class="cellRightTopBorder" ><p>Proposition d'avancement</p></td>
                    <td colspan="2" valign="top" class="cellTopBorder" ><p>&nbsp;</p></td>
                </tr>
            </table>
            <br />
            Remarques du chef de classe
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tableSpaceQQualification">
                <tr>
                    <td class="ligneSaisie">&nbsp;</td>
                </tr>
                <tr>
                    <td class="ligneSaisie">&nbsp;</td>
                </tr>
            </table>
            <br />
            Le participant a pris connaissance de cette qualification
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tableSpaceQQualification">
                <tr>
                    <td align="center" width="30%">Lieu, Date</td>
                    <td>&nbsp;</td>
                    <td align="center" width="30%">Participant</td>
                    <td>&nbsp;</td>
                    <td align="center" width="30%">Le chef de classe</td>
                </tr>
                <tr>
                    <td class="ligneSaisie">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="ligneSaisie">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="ligneSaisie">&nbsp;</td>
                </tr>
            </table>
            <br />
            Incorporation
            <table border="0" cellspacing="0" cellpadding="0" width="100%"  class="tableBorderQQualificationCaseACocher">
                <tr>
                    <td valign="top" class="cellRightBorder" ><p align="center">Compagnie</p></td>
                    <td valign="top" class="cellRightBorder" ><p align="center">Section</p></td>
                    <td valign="top"><p align="center">Fonction</p></td>
                </tr>
                <tr>
                    <td width="30%" class="cellRightTopBorder" >&nbsp;</td>
                    <td width="30%" class="cellRightTopBorder" >&nbsp;</td>
                    <td width="30%" class="cellTopBorder" >&nbsp;</td>
                </tr>
            </table>
    <?php
}
?>
    </body>
</html>
