=== Evangelische Termine ===
Contributors: regibaer 
Tags: evangelische, termine, elkb, vernetzte, kirche
Requires at least: 3.0
Tested up to: 4.2.3
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mit dem Plugin "Evangelische Termine" wird die Datenbank der "Evangelischen Termine" abgefragt und in Wordpress eingebunden.

== Description ==
Mit dem Plugin "Evangelische Termine" wird die Datenbank der "Evangelischen Termine" abgefragt und in Wordpress eingebunden. Über Shortcodes/Makros und über ein Widget wird die Anzeige für einzelne/mehrere Veranstalter oder für eine Region gesteuert.

Das Plugin verwendet cURL (curl.so - http://curl.haxx.se/), um die Daten bei den Evangelischen Terminen anzufordern und abzurufen. Sollte cURL nicht auf dem Server installiert sein, muss der Abruf der Daten umgeschrieben werden.

Das Plugin basiert auf zwei PHP-Skripten von Miklós Geyer von der [Vernetzten Kirche](http://www.vernetzte-kirche.de/). Das erste Skript gibt einen Filter, einen Pager und die Liste der Termine aus. Das zweite ruft die Termine ab und gibt sie ohne Filter und Pager
aus.

= Features =

* Shortcode [et_veranstalter @parameter] zur Einbindung der Evangelischen Termine in einem Beitrag oder auf einer Seite
* Shortcode [et_teaser @parameter] zur Einbindung der Evangelischen Termine in einem Beitrag oder auf einer Seite
* Widget "Evangelische Termine" zur Einbindung der Evangelischen Termine in einem Widget-Bereich
* Option-Page für die Grundeinstellungen des Plugins
* Überschreiben der Grundeinstellungen über die @parameter bei den Shortcodes und im Widget
* Einbinden von eigenen CSS-Dateien

= Shortcodes =
Über den Shortcode `et_veranstalter` wird das Veranstalter-Modul der
Evangelischen Termine aufgerufen. Es wird ein Filterfeld angezeigt und
darunter die Terminliste.
`[et_veranstalter @parameter]`

Der Shortcode `et_teaser` ruft das Teaser-Modul auf. Es wird eine Terminliste
ohne Suchfunktion ausgegeben.
`[et_teaser @parameter]`

Beschreibung der [@parameter](http://wordpress.org/plugins/evangtermine/other_notes/#Parameter)

== Installation ==
* `evangtermine.zip` in das `/wp-content/plugins/` Verzeichnis hochladen und dort entpacken.
* Plugin über das 'Plugins'-Menü in Wordpress aktivieren.
* Grundeinstellungen im Menü 'Einstellungen' 'Evangelische Termine' anpassen.

== Other Notes ==
= Grundeinstellungen =
Die Grundeinstellungen finden sich im Menü 'Einstellungen' 'Evangelische
Termine'. Die einzelnen Optionen sind:

**Veranstalter-ID**: Die Veranstalter-ID wird in den Evangelischen Terminen
nach der Anmeldung unter http://www.evangelische-termine.de/ rechts oben
angezeigt. Möchte man mehrere Veranstalter auf der Website anzeigen lassen,
können die IDs in einer kommagetrennten Liste angegeben werden. Es dürfen
keine Leerzeichnen verwendet werden.
Beispiel: id1,id2,..,idn

**Dekanats-ID**: Hier kann die Dekanats-ID der Evangelischen Termine
eingetragen werden. Sie wird an die Evangelischen Termine im Feld region
übergeben und zeigt die Veranstaltungen aller Veranstalter innerhalb des
Dekanats an.

**Until**: Mit diesem Schalter kann ausgewählt werden, ob Veranstaltungen bis
zum Enddatum angezeigt werden (yes|no). Default: yes.

**CSS-Datei**: Über dieses Feld kann man dem Plugin eine CSS-Datei mitteilen,
die dann statt der CSS-Datei des Plugins verwendet wird.

**Encoding**: Über diesen Schalter kann die Zeichenkodierung der Website
ausgewählt werden. Die Daten der Evangelischen Termine werden dann
entsprechend angepasst (utf8 oder latin1). Default: utf8.

= Parameter =
Eine genaue Beschreibung der möglichen Parameter findet sich im [Handbuch der Evangelischen Termine](http://handbuch.evangelische-termine.de/Ausgabe-Parameter/). In der aufgeführten Liste sind die implementierten Parameter aufgeführt:

**vid**: Veranstalter-ID(s); mehrere IDs können durch Komma getrennt werden - Beispiel: `[et_teaser vid="952,988"]`

**region**: dreistellige Dekanatsnummer oder mehrere durch Kommata getrennte Dekanatsnummern. Im Filterfeld des Shortcodes `[et_veranstalter]` wird dann ein weiteres Feld angezeigt, über das ein Website-Benutzer den gewünschten Veranstalter auswählen kann. Die vid sollte dann auf vid="all" oder auf einen vorselektierten Veranstalter gesetzt werden.

**eventtype**: ID der Veranstaltungskategorie - ein vorangestelltes "-" negiert die Auswahl; mehrere IDs können durch Komma getrennt werden.

**highlight**: zeigt entweder alle Veranstaltungen an (all) oder nur die Veranstaltungen, die als Highlight markiert sind (high).

**people**: durch Komma getrennte Liste der IDs der der Zielgruppen

**person**: durch Komma getrennte Liste der IDs der Ansprechpartner

**place**: durch Komma getrennte Liste der IDs der Veranstaltungsorte

**ipm**: durch Komma getrennte Liste der IDs der Veranstaltungstypen (Eingabemasken)

**cha**: durch Komma getrennte Liste der IDs der Kanäle

**itemsperpage**: Anzahl der anzuzeigenden Veranstaltungen. Für den Shortcode `[et_veranstalter]` sollten nur die Werte 5, 10, 20, 30, 40, 50 oder 100 verwendet werden. Default: 20.

**dest**: Gibt an, welche Veranstaltungen angezeigt werden sollen (extern = nur die öffentlichen, intern = nur die internen, all = alle Veranstaltungen). Default: extern.

**until**: Gibt an, ob eine Veranstaltung bis zum Enddatum angezeigt werden soll oder nicht (yes|no). Default: yes.

= Widget =
Die Beschreibung der Parameter findet sich im [Handbuch der Evangelischen Termine](http://handbuch.evangelische-termine.de/Ausgabe-Parameter/).

== Screenshots ==

1. Grundeinstellungen des Plugins
2. Ausgabe des Shortcodes `[et_veranstalter]`
3. Ausgabe des Shortcodes `[et_teaser]`
4. Widget-Einstellungen
5. Ausgabe des Widgets

== Changelog ==
= 1.2 =
* NEW: Dokumentation

= 1.1 =
* FIXED: Sessionhandling wurde angepasst. Werte werden jetzt direkt an den Pager übergeben (Ersetzung `__HOST__`)

== Upgrade Notice ==
= 1.2 =
Die Dokumentation wurde in das Plugin aufgenommen.

= 1.1 =
Das Sessionhandling wurde angepasst. Die Werte werden jetzt direkt im Link im Pager angegeben.

