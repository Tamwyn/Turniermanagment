<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "password";
$db_name = "turniermanagment";

$errors = array();
$Waobjects = array ("saebel", "florett");
$counter = 0; //Ein Zähler um leere Checkboxen aufzufinden
//Ueberpruefe Einkommende Daten
if (isset( $_POST['eintragen'] ))
{
if (empty($_POST['vorname']))
$errors['vorname'] = "Ein Vorname fehlt!";

if (empty($_POST['nachname']))
$errors['nachname'] = "Ein Nachname fehlt!";

if (empty($_POST['email']))
$errors['email'] = "Eine Email-Adresse fehlt!";

//Pruefen ob mindestens eine Waffe angegeben wurde
foreach ($Waobjects as $value) {
if ( isset($_POST["$value"]))
    $counter++;
}
if ($counter == 0) {
$errors['Waffe'] = "Es muss mindstens eine Waffe angegeben werden!"; //Beschwere dich ueber die fehlende Angabe einer Waffe
}
}


if (empty($errors) && isset( $_POST['eintragen']) )  //Wenn keine Fehler gefunden werden konnten UND eine Anfrage vorhanden ist schreibe in die Datenbank, ohne && kommt es dazu, dass dieser Block bei Seitenaufruf ausgefuehrt wird
{
// Verbindung oeffnen und Datenbank auswaehlen
$connect = mysqli_connect( $db_host, $db_user, $db_pass ) or die( "Der Datenbankserver konnte nicht erreicht werden!" );
if ($connect)
{
mysqli_select_db($connect, $db_name) or die("Die Datenbank wurde nicht erreicht");
}
//Zeichensatz auf utf8 umstellen
mysqli_query($connect,"SET NAMES UTF8");


// Inhalte der Felder aus POST holen und escapen
$vorname = mysqli_real_escape_string($connect, $_POST['vorname']);
$nachname = mysqli_real_escape_string($connect, $_POST['nachname']);
$jahrgang = (int) $_POST['jahrgang'];
$email = mysqli_real_escape_string($connect, $_POST['email']);
//Eine neue ID anlegen
$iddump = mysqli_fetch_assoc(mysqli_query($connect, "SELECT MAX(`ID`)+1 AS `newid` FROM `fechter`"));
$id = $iddump["newid"];


// Anfrage zusammenstellen der an die DB geschickt werden soll
$addfencer = "INSERT INTO `fechter` (`ID` , `Nachname` , `Vorname` , `Jahrgang` , `Email`)
		VALUES('$id' , '$nachname' , '$vorname' , '$jahrgang' , '$email')";
// Schickt die Anfrage an die DB und schreibt die Daten in die Tabelle
$add = mysqli_query($connect, $addfencer );
// Pruefen ob der neue Datensatz tatsaechlich eingefuegt wurde
if (mysqli_affected_rows($connect) == 1)
{
echo "<div class='ui-widget'><div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span><strong>$vorname  $nachname </strong> wurde erfolgreich hinzugef&uuml;gt</p></div></div><br>";
}
else
{
echo "<div class='ui-widget'><div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Achtung: </strong>$vorname $nachname konte nicht hinzugef&uuml;gt werden" . mysqli_error($connect) . "</p></div></div><br>";
break 2; //Verhindere, dass noch Waffen geschrieben werden
}

//Die Checkboxen fuer die Waffen als Array
$Waobjects = array ("saebel", "florett");
//Schreibe die ausgewaehlten Waffen:
for ( $i=0; $i <= 1; $i++){
if (isset($_POST["$Waobjects[$i]"]))
{
    $waffe = "INSERT INTO `fechterwaffe` (`FechterID` , `WaffeID`) VALUES ('$id' , '$i') ";
    $add = mysqli_query($connect, $waffe);
}
}
}
foreach ($errors as $value) { //Fehlermeldungen Grafisch aufgewertet zurueck geben
echo "<div class='ui-widget'><div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Achtung: </strong> $value </p></div></div><br>"; //Rückgabe der Fehlermeldungen
}
?>

<fieldset>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formular" id="formular" accept-charset="utf-8">
<p><b><label style="display:block;">Vorname</label></b>         <input style="display:block;" type="text" name="vorname" id="vorname" /></p>
<p><b><label style="display:block;">Nachname</label></b>        <input style="display:block;" type="text" name="nachname" id="nachname" /></p>
<p><b><label style="display:block;">Jahrgang</label></b>        <select style="display:block;" name="jahrgang" id="jahrgang"><?php for ($i=date("Y"); $i > 1950; $i--) { echo "<option>{$i}</option>"; } ?></select></p>
<p><b><label style="display:block;">Email-Adresse</label></b>   <input style="display:block;" type="text" id="email" name="email"></p>
 <p><b><label style="display:block;">Waffe(n):</label></b>
        <fieldset>
         <div style="float: left;"><label style="display:block;">S&auml;bel: </label> <input style="display:block;" type="checkbox" name="saebel" value="0"><br></div>
         <div style="float: center; margin-left: 150px;" ><label style="display:block;">Florett: </label> <input style="display:block;" type="checkbox" name="florett" value="0"></div>
        </fieldset></p>
<input type="submit" name="eintragen" id="eintragen" value="Abschicken" />
</fieldset>
