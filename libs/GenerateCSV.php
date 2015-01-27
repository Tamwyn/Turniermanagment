<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "password";
$db_name = "turniermanagment";

//Stelle eine Datenbankverbindung her
$connect = mysqli_connect( $db_host, $db_user, $db_pass ) or die( "Der Datenbankserver konnte nicht erreicht werden!" );
if ($connect)
{
mysqli_select_db($connect, $db_name) or die("Die Datenbank wurde nicht erreicht");
}
//Zeichensatz auf utf8 umstellen
mysqli_query($connect,"SET NAMES UTF8");


$dir = getcwd(); //Ermittle das aktuelle Verzeichnis, um in diesem die Liste abzuspeichern
$dir = mysqli_real_escape_string($connect, $dir);//Sorge dafuer, dass die Schraegstriche von MySQL  ignoriert werden
//Diese SQL Query ruft zuerst alle Daten ab inklusive der zugewiesenen Namen ( join jahrgaenge und waffen) um anschließend die Ergebnisse zu sortieren und diese 
//wiederum mithilfe des UNION mit den Spaltenueberschriften zu verbinden, welche im csv noetig sind.

//Aus unerklaerlichen Gruenden entfernt MySQL die Schraegstriche trotz escape und kann nicht Speichern, daher eine absolute Pfadangabe

$exportquery = "SELECT 'Datum' , 'Name' , 'Ort', 'Jahrgang', 'Waffe'
				UNION
				SELECT Datum , Name , Ort, JahrgName , WaffeName FROM
					(SELECT * FROM
						(SELECT t.Datum , t.Name , t.Ort , ak.JahrgID, jg.JahrgName, wt.WaffeID, w.WaffeName
							FROM turnier as t 
							JOIN altersklassen AS ak ON t.ID = ak.TurnierID
							JOIN jahrgaenge AS jg ON ak.JahrgID = jg.ID
							JOIN waffetur AS wt ON t.ID = wt.TurnierID
							JOIN waffen AS w ON wt.WaffeID = w.ID
							WHERE Datum > date(now()) )AS Question
					ORDER BY WaffeID, JahrgID, Datum ASC ) AS ordered
				INTO OUTFILE" . "'" . $dir . "/turniere.csv'
				FIELDS TERMINATED BY ','
				ENCLOSED BY '\"'
				LINES TERMINATED BY '\n';";
mysqli_query($connect, $exportquery);
echo mysqli_error($connect); //Debugging
echo ($dir . "/turniere.csv");
?>