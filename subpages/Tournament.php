<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "password";
$db_name = "turniermanagment";

$errors = array();
$AKobjects = array ("schueler", "bjg" , "ajg" , "jun" , "aktive" , "senioren"  );//Die Namen der Checkboxen fuer Kontrollen
$Waobjects = array ("saebel", "florett");
$counter = 0; //Ein Zähler um leere Checkboxen aufzufinden

//Ueberpruefe Einkommende Daten
if (isset( $_POST['add'] ))
{
    if (empty($_POST['name']))
        $errors['name'] = "Ein Name fehlt!";

    if (empty($_POST['link']))
        $errors['link'] = "Eine Ausschreibung fehlt!";

    if (empty($_POST['datepicker']))
        $errors['datum'] = "Ein Datum fehlt!";

    if (empty($_POST['ort']))
        $errors['ort'] = "Ein Veranstaltungsort fehlt!";

    //Pruefe ob mindstens eine Altersklasse angegeben wurde
    foreach ($AKobjects as $value) {
        if ( isset($_POST["$value"]))
            $counter++;
    } //Wenn keine Altersklase angegeben wurde, ist der Counter nun 0, beschwere dich
    if ($counter == 0) {
        $errors['altersklassen'] = "Es muss mindestens eine Altersklasse angegeben werden!";
    }

    //Pruefen ob mindestens eine Waffe angegeben wurde
    $counter = 0;//Counter zuruecksetzen fuer die Waffe
    foreach ($Waobjects as $value) {
        if ( isset($_POST["$value"]))
            $counter++;
    }//Analog zu Altersklasse
    if ($counter == 0) {
        $errors['Waffe'] = "Es muss mindestens eine Waffe angegeben werden!";
    }
}


if (empty($errors) && isset( $_POST['add']) ) //Wenn keine Fehler gefunden werden konnten UND eine Anfrage vorhanden ist schreibe in die Datenbank, ohne && kommt es dazu, dass dieser Block bei Seitenaufruf ausgefuehrt wird
{
    // Verbindung oeffnen und Datenbank auswaehlen oder eine Fehlermeldung zurueckgeben
    $connect = mysqli_connect( $db_host, $db_user, $db_pass ) or die( "Der Datenbankserver konnte nicht erreicht werden!" );
    if ($connect)
    {
        mysqli_select_db( $connect , $db_name) or die("Die Datenbank wurde nicht erreicht");
    }
    //Zeichensatz auf utf8 umstellen
    mysqli_query($connect,"SET NAMES UTF8");

        // Inhalte der Felder aus POST holen und aus Sicherheitsgruenden escapen
    $iddump = mysqli_fetch_assoc(mysqli_query($connect, "SELECT MAX(`ID`)+1 AS `newid` FROM `turnier`"));
    $id = $iddump["newid"]; //der Umweg aufgrund des Rueckgabeformats von mysqli
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $ausschreibung = mysqli_real_escape_string($connect, $_POST['link']);
    $datum = mysqli_real_escape_string($connect, $_POST['datepicker']);
    $ort = mysqli_real_escape_string($connect, $_POST['ort']);
    if (isset($_POST['pflichtturnier'])) //Finde heraus, ob es ein Pflichtturnier ist checked=> ja --> 1 sonst 0
    {
        $pflicht = (int) '1';
    }
    else
    {
        $pflicht = (int) '0';
    }

    // Anfrage zusammenstellen die an die DB geschickt werden soll
    $addtournament = "INSERT INTO `turnier` (`ID` , `Name` , `Ausschreibung` , `Pflichtturnier` , `Datum` , `Ort`)
                    VALUES('$id' , '$name', '$ausschreibung', '$pflicht', '$datum' , '$ort')";
    // Schickt die Anfrage an die DB und schreibt die Daten in die Tabelle
    $add = mysqli_query($connect, $addtournament );
    // Pruefen ob der neue Datensatz tatsaechlich eingefuegt wurde
    if (mysqli_affected_rows($connect) == 1)
    {
        echo "<div class='ui-widget'><div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span><strong>$name </strong> wurde erfolgreich hinzugef&uuml;gt</p></div></div><br>"; //Gib zurueck, dass dieses Turnier hinzugefuegt wurde
    }
    else
    {
        echo "<div class='ui-widget'><div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Achtung: </strong>Das Turnier konnte nicht hinzugef&uuml;gt werden" . mysqli_error($connect) . "</p></div></div><br>"; //Gib eine Fehlermeldung zurueck
    }
 
    //Schreibe gewaehlte Altersklassen
    for ($i = 0; $i <= 5; $i++) {
        if (isset($_POST["$AKobjects[$i]"]))
        {
            $ak = "INSERT INTO `altersklassen` (`TurnierID` , `JahrgID`) VALUES ('$id' , '$i') ";
            $add = mysqli_query($connect, $ak);
        }
    }

    //Schreibe Waffen 
    for ( $i=0; $i <= 1; $i++){
        if (isset($_POST["$Waobjects[$i]"]))
        {
            $waffe = "INSERT INTO `waffetur` (`TurnierID` , `WaffeID`) VALUES ('$id' , '$i') ";
            $add = mysqli_query($connect, $waffe);
        }
    }
}

foreach ($errors as $value) { //Gib die zuvor gesammelten Fehlermeldungen Grafisch aufgewertet zurueck
    echo "<div class='ui-widget'><div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Achtung: </strong>$value</p></div></div><br>"; //Rückgabe der Fehlermeldungen
}
?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formular" id="formular" accept-charset="utf-8">
<fieldset>
    <p><b><label style="display:block;">Name des Turniers:</label></b> <input style="display:block;" type="text" name="name" id="name" /></p>
    <p><b><label style="display:block;">Link zur Ausschreibung:</label></b> <input style="display:block;" type="text" name="link" id="link" /></p>
    <p><b><label style="display:block;">Veranstaltungsort:</label></b> <input style="display:block;" type="text" name="ort" id="ort" /></p>
    <p><b><label style="display:block;">Datum:</label></b> <input style="display:block;" type="text" id="datepicker" name="datepicker"></p>
    <p><b><label style="display:block;">Altersklasse(n):</label></b>
       <fieldset>
        <div style="float: left;">
        <label style="display:block;">Schüler: </label><input style="display:block;" type="checkbox" name="schueler" value="0"><br>
        <label style="display:block;">B-Jugend: </label><input style="display:block;" type="checkbox" name="bjg" value="0"><br>
        <label style="display:block;">A-Jugend: </label><input style="display:block;" type="checkbox" name="ajg" value="0">
        </div>
        
        <div style="float: center; margin-left: 150px;" >
        <label style="display:block;">Junioren: </label><input style="display:block;" type="checkbox" name="jun" value="0"><br>
        <label style="display:block;">Aktive: </label><input style="display:block;" type="checkbox" name="aktive" value="0"> <br>
        <label style="display:block;">Senioren: </label><input style="display:block;" type="checkbox" name="senioren" value="0"> </p>
        </div>
       </fieldset>
    <p><b><label style="display:block;">Waffe(n):</label></b>
        <fieldset>
         <div style="float: left;"><label style="display:block;">S&auml;bel: </label> <input style="display:block;" type="checkbox" name="saebel" value="0"><br></div>
         <div style="float: center; margin-left: 150px;" ><label style="display:block;">Florett: </label> <input style="display:block;" type="checkbox" name="florett" value="0"></div>
        </fieldset></p>
    <p><b><label style="display:block;">Pflichtturnier:</label></b><fieldset> <label style="display:block;">Anklicken für "Ja"</label> <input style="display:block;" type="checkbox" name="pflichtturnier" value="0"></p></fieldset><br>
    <input type="submit" name="add" id="add" value="Abschicken" /></p>
</fieldset>
