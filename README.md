IT-Status
=========

Die Datei `index.php` zeigt den aktuellen IT-Status für den Landesverband Mecklenburg-Vorpommern der Piratenpartei Deutschland an.

Anpassen
--------

Um Anpassungen vorzunehmen, reicht es, die Datei `index.php` zu editieren.

Funktionen
----------

* `assertStatusEQ(url, stauts)` - überprüft, ob der HTTP-Status der URL *url* dem Status *status* entspricht.
* `assertTitleEQ(url, title)` - überprüft, ob der HTML-Titel der URL *url* dem Text *title* entspricht.
* `assertPortUp(domain, port)` - überprüft, ob der Port *port* der Domain *domain* erreichbar ist.
* `assertRedirectionEQ(source, target)` - überprüft, ob die URL *source* auf die URL *target* weiterleitet.

Fragen
------

Bei Fragen bitte eine Mail an support@piraten-mv.de schreiben. Wir helfen gerne!
