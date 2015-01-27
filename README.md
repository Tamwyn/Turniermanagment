Nutzungshinweise
Anlegen von Turnieren:
Neue Turniere können im Webinterface im Reiter "Turnier hinzufügen" angelegt 
werden.
Die Felder mit dem Namen, der Ausschreibung und dem Veranstaltungsort sind 
Pflichtfelder. Sind diese nicht ausgefüllt schlägt das Hinzufügen fehl. Das 
Datum lässt sich einfach mithilfe des Kalenderformulars eingeben, sobald man auf 
die Eingabezeile hierfür klickt.
Bei den Altersklassen und den Waffen muss mindestens ein Kästchen angekreuzt 
werden, ansonsten schlägt auch hier der Prozess fehl. Anders sieht es beim 
Pflichtturnier aus. Dieses kann ankreuzt werden, es ist jedoch nicht zwingend 
erforderlich. Sofern es ausgewählt ist wird sich im generierten Mailtext ein 
zusätzlicher Hinweis auf die Relevanz dieses Turniers befinden.


Einen neuen Fechter anlegen:

Das Anlegen eines neuen Fechter ist unter "Fechter hinzufügen" möglich.
Hier muss in jedem Feld eine Angabe gemacht werden und auch hier wieder 
mindestens ein Kästchen angekreuzt werden. Auch dieses Formular gibt Rückmeldung
ob das hinzufügen erfolgreich gewesen ist oder nicht. Sofern Eltern informiert 
werden sollen sind diese mit dem Jahrgang des Kindes in der Datenbank zu 
erfassen, um eine Benachrichtigung nach Altersklassen zu ermöglichen.


Export der angelegten Turniere

Es ist möglich die erfassten Turniere nach Waffe, Altersklasse und Datum 
sortiert in ein Tabellendokument zu exportieren. Hierfür ist ein Klick auf den 
Button im Reiter "Turnierlisten exportieren" nötig. Nach kurzer Zeit sollte 
sich ein Download öffnen, welche eine CSV Tabelle herunterlädt. Diese lässt sich
mit herkömmlichen Tabellenkalkulationsprogrammen öffnen und dort grafisch 
aufarbeiten und ausdrucken.


Python

Emails versenden:
Der in Python verfasste "Turnierkurier" ist ein Script, welches die kommenden 
Turniere der nächsten 6 Wochen aus der Datenbank abfragt, die Altersklassen und 
Waffen für dieses Turnier ermittelt und anschließend mit den gespeicherten Daten
der Fechter abgleicht um diese bei Übereinstimmung per Mail zu informieren.

Sollte dieses Script zu Demonstrationszwecken gestartet werden empfiehlt es sich
den Testmodus durch setzen der Variable "test = 1" am Anfang des Scriptes zu 
aktivieren
Die Folge ist, dass es die Mail nicht zu versenden versucht und stattdessen in 
einer Konsole den Mailtext ausgibt.


Kalender ausfüllen:
Das Script "calendar-push" schreibt die Turniere nach Waffen sortiert in eigene 
Google Kalender, welche auf nahezu allen Plattformen eingebunden werden können.
(Outlook, Thunderbird, iOS, Android). Dies ist auch der Grund, weshalb die 
Entscheidung auf ein proprietäres Kalenderformat gefallen ist. 
Es ist unter Android nicht ohne erweiterten Aufwand möglich einen anderen 
Kalender zu importieren. Dies ist mit vorinstallierten Apps nur mit Google 
Calendar und den integrierten Freigaben möglich.

