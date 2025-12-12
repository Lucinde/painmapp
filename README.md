# Painmapp
Tracking symptoms and habits to find patterns

# Vereisten:

PHP 8.4  
SQL server   
Composer

# Installatie

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

- Ga in de terminal naar de map waar je de repository naartoe gekloond hebt en voer de volgende commando's uit:  
  `composer install`  
  `npm install`  
  `npm run build`

- run de applicatie lokaal met:  
  `composer run dev`
- Draai de migraties en seed de database:  
  `php artisan migrate --seed`

# Lokaal mails versturen

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
