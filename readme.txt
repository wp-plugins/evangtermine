=== Evangelische Termine ===
Contributors: Norbert Räbiger
Requires at least: 3.0
Tested up to: 4.2.2
Stable tag: 1.1

Mit dem Plugin "Evangelische Termine" wird die Datenbank der "Evangelischen Termine" abgefragt und in Wordpress eingebunden.

== Description ==
Mit dem Plugin "Evangelische Termine" wird die Datenbank der "Evangelischen Termine" abgefragt und in Wordpress eingebunden. Über Shortcodes/Makros und über ein Widget wird die Anzeige für einzelne/mehrere Veranstalter oder für eine Region gesteuert.
Das Plugin verwendet cURL (curl.so - http://curl.haxx.se/), um die Daten bei den Evangelischen Terminen anzufordern und abzurufen. Sollte cURL nicht auf dem Server installiert sein, muss der Abruf der Daten umgeschrieben werden.

<em>Features</em>

* Shortcode [et_veranstalter @attribute] zur Einbindung der Evangelischen Termine in einem Beitrag oder auf einer Seite
* Shortcode [et_teaser @attribute] zur Einbindung der Evangelischen Termine in einem Beitrag oder auf einer Seite
* Widget "Evangelische Termine" zur Einbindung der Evangelischen Temrine in einem Widget-Bereich
* Option-Page für die Grundeinstellungen des Plugins
* Überschreiben der Grundeinstellungen über die @attribute bei den Shortcodes und im Widget
* Einbinden von eigenen CSS-Dateien

<em>Included languages</em>

* German

== Installation ==
1. Hochladen des Plugins über das Plugins-Menü in Wordpress (Backend Plugins -> Installieren -> Plugin hochladen -> Durchsuchen -> Installieren)
2. Aktivieren des Plugins über das Plugins-Menü in Wordpress
3. Grundeinstellungen vornehmen
4. Shortcodes oder Widget einbinden und Einstellungen vornehmen

== Changelog ==

Hier sind die Veränderungen zwischen den einzelnen Versionen aufgezeichnet.

	Version		Date			Changes
	1.1			2015/07/02	Fixed: Sessionhandling wurde angepasst. Werte werden jetzt direkt an den Pager übergeben (Ersetzung __HOST__)
	
== Frequently Asked Questions ==



== Screenshots ==


