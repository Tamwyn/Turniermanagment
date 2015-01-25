#!/usr/bin/python
#coding=utf-8
#
# Copyright 2012 Google Inc. All Rights Reserved.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#    http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

#Dieses Script basiert zu einem großen Teil auf:
#https://developers.google.com/api-client-library/python/samples/authorized_api_cmd_line_calendar.py
#Ich habe es dahingehend ueberarbeitet, dass es keine Events abruft, sondern schreibt.
#Desweiteren ist es um die Datenabnkschnittstelle und ueberarbeitete Kommentare ergaenzt worden

import mysql.connector
import datetime
import formatize

import httplib2
import sys

from apiclient.discovery import build
from oauth2client.file import Storage
from oauth2client.client import AccessTokenRefreshError
from oauth2client.client import OAuth2WebServerFlow
from oauth2client.tools import run

#####LOGLEVEL#############################################################
##Veraendere den Output des Loglevels um Unterschiedlich praezise       ##
##Daten zu bekommen:                                                    ##
##0 : keine;                                                            ##
##1 : Die Werte der Variablen;                                          ##
loglvl = 0                                                              ##
##########################################################################

try:
  #Stelle eine Verbindung zur Turniermanagement Datenbank her
  cnxTurnier = mysql.connector.connect(user='root', password='password', host='localhost', database='turniermanagment')

except: #Der Datenbankserver ist anscheinend nicht erreichbar brich daher die Ausfuehrung ab
  exit("Die Datenbank konnte nicht erreicht werden")


#Die Anmeldedaten fuer die Google API
client_id = "your client_id here"
client_secret = "your client_secret here"

#Die Kalender IDs fuer Saebel und Florett
CalendarSaID = "your calendar_id here"
CalendarFlID = "your second calendar_id here"

# Die URL zur API des Kalenders
scope = 'https://www.googleapis.com/auth/calendar'

# Dieses Objekt speichert die API Daten in einem dafuer vorgesehenem Objekt ab
flow = OAuth2WebServerFlow(client_id, client_secret, scope)





def PushEvent(Waffe,Turnier, Ausschreibung, Datum, Ort): #Speichere das Turnier im Kalender fuer Saebel

  # Lege eine Datei an, in der die letzendliche Authentifizierung gespeichert wird
  storage = Storage('credentials.dat')

  # Lade diese Authentifizierungsdaten in den Speicher. Sofern keine vorhanden sind wird der Wert "None"
  credentials = storage.get()

  # Pruefe ob Daten vorliegen oder ob sie gueltig sind um sie ggf. neu zu generieren
  if credentials is None or credentials.invalid:
    credentials = run(flow, storage) #Ein Webbrowser wuerde sich oeffnen und eine Bestaetigung erfordern

  # Erstelle ein Http Objekt und nutze es um die Zugangsdaten zu authorisieren
  http = httplib2.Http()
  http = credentials.authorize(http)

  #   Estelle ein Objekt, welches die eigentlichen API Zugriffe ausführt
  #   Welche API soll angesprochen werden? (Kalender)
  #   Welche Version der API? (v3)
  #   Das autorisierte Http-Objekt um eine Verbindung herstellen zu koennen
  service = build('calendar', 'v3', http=http)

  #Versuche schreibend auf den Kalender zuzugreifen
  try:

    # Erstelle ein Objekt mit den Kalenderdaten fuer Saebel
    
    event = {
      'summary': Turnier, #Name des Termins --> Turniername
      'location':  Ort ,  #Wo?
      'description': Ausschreibung , #Beschreibung des Termins --> Link zur Ausschreibung
      'start': {
        'date': Datum
      },                             #Beginn und Ende
      'end': {
        'date': Datum
      },
    }

    if (Waffe == 0): 
      created_event = service.events().insert(calendarId=CalendarSaID, body=event).execute() #Schreibe die Turnierdaten in den Kalender fuer Saebel

    if (Waffe == 1):
       created_event = service.events().insert(calendarId=CalendarFlID, body=event).execute() #Der Kalender fuer Florett


  except AccessTokenRefreshError:
    # Ein Fehler ist mit der credentials.dat aufgetreten
    print ('Die Autorisiserung ist ausgelaufen. Bitte erneut starten um den Autorisierungsprozess zu starten')


def MarkTournament(TurID, WaffeID): #Nimm dieses Turnier aus der Liste der Abrufe 
  if (loglvl ==1): print("MarkTournament")
  cursor = cnxTurnier.cursor()

  query = ("UPDATE waffetur SET Kalender='1' WHERE TurnierID=")
  query += str(TurID) + " AND WaffeID =" + str(WaffeID)  #Verfollstaendige die SQL Query
  if (loglvl == 2): print(query)

  cursor.execute(query) #Schreibe, dass das Turnier gecasted wurde und bestaetige mit commit
  cnxTurnier.commit()

##########################################################################################################################################



cursor = cnxTurnier.cursor()

#################SAEBEL###############################################################################################################################################
querySabour = ("SELECT Name, Ausschreibung, Datum, Ort, ID FROM turnier AS t JOIN waffetur AS wt ON t.ID = wt.TurnierID WHERE Kalender=0 AND WaffeID=0")
cursor.execute(querySabour)
SabourEvents = cursor.fetchall()
WaffeID = 0
for event in SabourEvents: #Gehe fuer jedes gefundene Turnier einzeln vor
  Turnier = event[0].encode('utf-8') #Auch hier wieder das Codieren in utf-8 um eventuelle Umlaute verarbeiten zu koennen
  Ausschreibung = str(event[1])
  Datum = str(event[2])
  Ort = event[3].encode('utf-8')
  if (loglvl == 1): print Turnier + " " + Ausschreibung + " " + Datum + " " + Ort

  #Sende die Saebelturniere an den Kalender
  PushEvent(WaffeID,Turnier, Ausschreibung, Datum, Ort)

  #Speichere ab, dass dieses Turnier im Saebelkalender gespeichert wurde
  MarkTournament(event[4], WaffeID )


#################Florett##############################################################################################################################################
queryFleur = ("SELECT Name, Ausschreibung, Datum, Ort, ID FROM turnier AS t JOIN waffetur AS wt ON t.ID = wt.TurnierID WHERE Kalender=0 AND WaffeID=1")
cursor.execute(queryFleur)
FleurEvents = cursor.fetchall()
WaffeID = 1
for event in FleurEvents:
  Turnier = event[0].encode('utf-8')
  Ausschreibung = str(event[1])
  Datum = str(event[2])
  Ort = event[3].encode('utf-8')
  if (loglvl == 1): print Turnier + " " + Ausschreibung + " " + Datum + " " + Ort

  #Sende die Florettturniere an den Kalender
  PushEvent(WaffeID, Turnier, Ausschreibung, Datum, Ort)

  #Speichere ab, dass diese Turnier im Florettkalender gespeichert wurde
  MarkTournament(event[4], WaffeID)