# downloads.sasd.de – PHP starter application

Dieses Projekt ist eine **saubere V1 für `downloads.sasd.de`**:

- überschaubare PHP-Anwendung
- MVC-nahe Struktur
- dateibasierter Katalog
- Such- und Filteroberfläche
- direkte Download-Controller
- Mehrsprachigkeit von Anfang an (Deutsch + Englisch)
- vorbereitet für spätere Migration auf Datenbank/Repository-Wechsel

## Ziel der Architektur

Die Anwendung trennt bewusst:

- **HTTP / Controller**
- **View / Templates**
- **Service-Logik**
- **Repository-Abstraktion**
- **JSON-Katalog als aktuelle Datenquelle**

Dadurch kann später eine Datenbankanbindung eingeführt werden, ohne dass die
gesamte Anwendung neu aufgebaut werden muss.

## Mehrsprachigkeit

Die Anwendung ist **intern mehrsprachig vorbereitet**.

### UI-Texte

UI-Texte liegen in:

- `resources/lang/de.php`
- `resources/lang/en.php`

Später können weitere Dateien ergänzt werden:

- `resources/lang/fr.php`
- `resources/lang/es.php`
- `resources/lang/pt.php`
- `resources/lang/it.php`
- `resources/lang/pl.php`
- `resources/lang/tr.php`
- `resources/lang/ar.php`
- `resources/lang/hi.php`
- `resources/lang/ko.php`
- `resources/lang/zh.php`
- `resources/lang/ja.php`

Danach die Sprache in `config/app.php` unter `enabled_locales` aktivieren.

### Kataloginhalte

Produkt- und Artefakttitel sowie Beschreibungen sind **nicht** in den
Sprachdateien, sondern direkt in den JSON-Daten lokalisiert:

```json
{
  "title": {
    "de": "Mustela Handbuch",
    "en": "Mustela Manual"
  },
  "description": {
    "de": "Deutsches Handbuch für Mustela.",
    "en": "English manual for Mustela."
  }
}
```

### Empfehlung für später

Für viele Sprachen sollten Sie intern mit folgendem Muster arbeiten:

- UI-Texte in Sprachdateien
- fachliche Produkt-/Artefaktdaten als lokalisierte Felder im Katalog
- optional später Redaktionsworkflow oder Admin-Backend

## Lokale Entwicklung

### PHP Built-in Server

```bash
php -S 127.0.0.1:8080 -t public
```

Dann im Browser öffnen:

```text
http://127.0.0.1:8080
```

### Katalog validieren

```bash
php cli/validate-catalog.php
```

### Generierten Katalog neu aufbauen

```bash
php cli/rebuild-catalog.php
```

## Neues Produkt hinzufügen

1. Produkt in `products.json` ergänzen
2. Dateien nach `storage/files/...` legen
3. Artefakte in `artifacts.json` ergänzen
4. Validieren
5. Katalog neu generieren

## Produkt ausblenden oder entfernen

Für V1 ist das am saubersten über das Statusfeld lösbar:

- `current`
- `lts`
- `deprecated`
- `archived`
- `hidden`

Empfehlung:

- **nicht sofort löschen**
- lieber zunächst auf `archived` oder `hidden` setzen

Danach Katalog neu generieren.

## Nächste sinnvolle Ausbaustufen

- Admin-/Redaktionsbereich für Upload und Freigabe
- Paginierung
- feinere Suchlogik
- Prüfsummen-Dateien automatisch mit erzeugen
- Signaturen
- Download-Statistiken
- saubere Fehler- und Audit-Logs mit SASD Logger
- echte Storage-Abstraktion
- Testsuite
