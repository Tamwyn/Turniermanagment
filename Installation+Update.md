Voraussetzungen:
- Ein Webserver wie Apache oder Nginx (getestet)
- PHP Unterstützung (Version 5.5 oder höher)
- MySQL und die notwendigen PHP-MySQL Erweiterungen
- Python Version 2.7
- Python MySQL-Connector (→ Installation)
- Python Google Oauth Pakete (→ Installation)
- Ein lokaler Mailserver

Installation:

Vorbereitung
1. Git installieren (Nicht notwendig, vereinfacht aber Installation und Updates)

2. Den Webserver mit den zugehörigen (PHP-)Paketen nach der offiziellen Dokumentation installieren.

3. MySQL Server installieren und einen „root“-Benutzer inklusive Passwort anlegen.

4. Python 2.7 inklusive „pip“ installieren.

5. Die für den Kalender notwendigen Python Bibliotheken installieren: 
pip install --upgrade google-api-python-client python-gflags

6. Den Python MySQL Connector von https://dev.mysql.com/downloads/connector/python/ für das entsprechende Betriebssystem herunterladen und installieren


Datenbank Grundlagen installieren
1. Öffnen einer Kommandozeile und MySQL starten (mysql -u root -p und Passwort eingeben)

2. Einen neuen Datenbankbenutzer anlegen und ein Passwort zuweisen:
CREATE USER 'turniere'@'localhost' IDENTIFIED BY '$password';

3. Erstelle die Datenbank: 
CREATE DATABASE IF NOT EXISTS `turniermanagment` DEFAULT CHARACTER SET `utf8` COLLATE `utf8_unicode_ci`; 

4. Weise dem neu erstelletem Nutzer die Berechtigungen für die Datenbank zu:
GRANT ALL PRIVILEGES ON `turniermanagment`.* TO 'turniere'@'localhost';

5. Aus MySQL ausloggen:
\q


Webinterface installieren
1. Das öffentliche Verzeichnis des Webservers aufrufen und eine Kommandozeile öffnen.

2. "git clone https://git.scimeda.de/thore/turniermanagment.git" ausführen und die aktuelle Version herunterladen.

3. Die Datenbankeinstellungen im Ordner subpages von Tournament.php und AddFencer.php sowie in libs/ExportCSV.php Nutzernamen und Passwort durch die zuvor angelegten Nutzerdaten ersetzen.

4. Die Änderungen in git sichern für spätere Updates: 
git commit -am „Datenbankdaten der Website angepasst"


Pythonscripte:
Die Scripte befinden sich im Unterordner Python
1. Die Datenbankparameter in calendar-push.py und turnierkurier.py ebenfalls anpassen.

2. In calendar-push.py müssen zudem die Kalendereinstellungen angepasst werden.
Zunächst werden Google API Zugangsdaten aus der Developers Console benötigt:
https://developers.google.com/google-apps/calendar/firstapp#register
Die dort erstellten Zugangsdaten für die Calendar API müssen bei
client_id = "your client ID here"
client_secret = "your client secret here"
eingefügt werden.

3. Außerdem sind zwei öffentliche Google Kalender notwendig, und deren ID in jeweils eines der 
Calendar*ID = "your calendar ID here"
Felder eingefügt werden.
Die KalenderId findet man in den jeweiligen Kalendereinstellungen unter "Kalenderadresse"

4. Auch diese Änderungen in git sichern für spätere Updates:
git commit -am "Variablen der Pythonscripte gesetzt"

Datenbank importieren:
1. Im Ordner "Datenbanken" befinden sich zwei Dateien:
- db-sample.sql
- db.sql
Erstgenannte enthält Beispieldatensätze.

2. Aufruf des Ordners Datenbanken in der Konsole

3. Import der Datenbank mit
mysql -u turniere -p < db.sql 
oder für die Beispieldatenbank
mysql -u turniere -p < db-sample.sql
Nach einer Eingabe des Passworts importiert MySQL die Datenbankeinstellungen.


Zeitsteuerung aktivieren
1. Für das jeweilige Betriebssystem unterschiedliche zeitgesteuerte Aufrufe der Pythonscripte aktivieren (Empfohlen: wöchentlich)



Aktualisieren:
Der bevorzugte Weg ein Update einzuspielen ist ebenfalls über git. Die alternative Möglichkeit ist ein erneutes herunterladen der Scripte und die erneute Eingabe der Parameter. Eine Datenbankeinrichtung entfällt jedoch.
1. Neue Version herunterladen:
git fetch origin

2. Updates einspielen ($Version durch die zu installierende Version ersetzen)
git merge update-v.$Version