# PainMApp
PainMApp is een webapplicatie voor het bijhouden van pijnklachten, activiteiten en dagelijkse gewoontes met als doel:
patronen herkennen tussen klachten en gedrag en zo betere behandelbeslissingen mogelijk maken.

De applicatie is ontwikkeld voor gebruik door cliënten, fysiotherapeuten en beheerders.

## Kernfunctionaliteiten

### Daglogs (DayLogs)
Elke cliënt kan per dag een log aanmaken waarin alle relevante informatie van die dag wordt vastgelegd:
- algemene notities
- pijnmomenten (pain logs)
- activiteiten (activity logs)

---

### Pijnregistratie (PainLogs)

Binnen een daglog kan een cliënt meerdere pijnmomenten registreren:
- start- en eindtijd
- intensiteit
- locatie(s)
- opmerkingen

De duur van de pijn wordt automatisch berekend op basis van start- en eindtijd.

**Rechten:**
- cliënten zien en bewerken alleen hun eigen painlogs
- fysiotherapeuten zien alleen logs van hun eigen cliënten
- beheerders zien alles

---

### Activiteitenregistratie (ActivityLogs)

Cliënten kunnen activiteiten registreren zoals:
- wandelen
- fietsen
- sporten
- rustmomenten

Per activiteit wordt vastgelegd:
- categorie (enum)
- start- en eindtijd
- intensiteit
- ervaren belasting
- notities

De duur wordt automatisch berekend via model events.

Ook hier gelden dezelfde autorisatieregels als bij painlogs.

---

### Rollen & autorisatie

De applicatie gebruikt **role-based access control** (via Spatie Permission):

| Rol            | Rechten                                         |
|----------------|-------------------------------------------------|
| Client         | eigen daglogs, painlogs en activitylogs beheren |
| Fysiotherapeut | daglogs van eigen cliënten bekijken             |
| Admin          | volledige toegang tot alle data                 |

Rechten worden afgedwongen via:
- policies
- Filament resources
- directe URL-beveiliging (geen bypass mogelijk)

---

## Teststrategie

Het project bevat uitgebreide tests met:
- Pest
- Livewire testing
- Filament TestActions

Getest wordt o.a.:
- rolgebaseerde toegang
- relation managers (painlogs & activitylogs)
- create/update flows
- directe URL-beveiliging

Alle tests draaien op seed data uit `TestUserSeeder`.

---

## Database & Seeders

De `TestUserSeeder` maakt automatisch aan:
- meerdere fysiotherapeuten
- cliënten per fysiotherapeut
- daglogs per cliënt
- painlogs (random per daglog)
- activitylogs (random per daglog)

Zo heb je na `migrate --seed` direct realistische testdata beschikbaar.

---

## Toekomstige uitbreidingen

- meer statistieken en grafieken
- patroonherkenning
- export van data (PDF / CSV)
- rapportages voor fysiotherapeuten
- koppelingen met externe systemen

---

## Technische stack

- PHP 8.4
- Laravel 11
- Filament 4
- Livewire
- Shield / Spatie Permission
- SQL database
- Pest

---

# Installatie

### Vereisten:

- PHP 8.4
- Laravel 11
- MySQL / SQL Server

---

### Voorbereidingen

Als je nog geen PHP, Composer en/of Laravel installer hebt gebruik dan Laravel Herd (https://herd.laravel.com/) of een
van de volgende commando's om deze te installeren.

MacOS:  
`/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.4)"`

Windows Powershell:  
`# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))`

Linux:  
`/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"`

- Gebruik MAMP / XAMP of een andere manier om lokaal PHP en databases te kunnen draaien en start de server

---

### Installatiestappen 

- Ga in de terminal naar de map waar je de repository naartoe gekloond hebt en voer de volgende commando's uit:  
  `composer install`  
  `npm install`  
  `npm run build`

- Draai de migraties en seed de database:  
  `php artisan migrate --seed`

- run de applicatie lokaal met:  
  `composer run dev`

---

### Lokaal mails versturen

- Installeer Mailpit  
  MacOS: `brew install mailpit`  
  Start mailpit in je terminal met `mailpit`

Voor Windows/Linux:  
Download vanaf: https://github.com/axllent/mailpit/releases  
Start het via terminal of dubbelklik  
Mailpit draait standaard op:   
SMTP-poort: 1025  
Webinterface: http://localhost:8025

Voeg in de .env de waarden voor mailpit toe:  
MAIL_MAILER=smtp  
MAIL_HOST=127.0.0.1  
MAIL_PORT=1025  
MAIL_USERNAME=null  
MAIL_PASSWORD=null  
MAIL_ENCRYPTION=null  
MAIL_FROM_ADDRESS=test@example.com  
MAIL_FROM_NAME="${APP_NAME}"
