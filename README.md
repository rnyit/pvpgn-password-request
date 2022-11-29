# pvpgn-password-request
PvPGN Password Request Script.

## What is PvPGN?

[PvPGN](https://pvpgn.pro)(Player vs Player Gaming Network) is a free and open source software project offering emulation of various gaming network servers. It is published under the GPL and based upon bnetd.
It currently supports most features of all Battle.net classic clients (Diablo, Diablo II, Diablo II: Lord of Destruction, StarCraft, StarCraft: Brood War, Warcraft II: Battle.net Edition, Warcraft III: Reign of Chaos, Warcraft III: The Frozen Throne). It also offers basic support for Westwood Online clients (Command & Conquer: Tiberian Sun, Command & Conquer: Red Alert 2, Command & Conquer: Yuri's Revenge).

## What is this?

PvPGN password request is a script written in [PHP](https://www.php.net) which has a [PHP Mailer](https://github.com/PHPMailer/PHPMailer) built-in that allow any user to recover the password through a Battle.net private server that is running under PvPGN. Officially PvPGN has no built-in function to rocover a lost password and this script make that function working. The script does **not** reset the password instead is sending the **current** password of the account.

## How is working?

PvPGN does generate and output logs if a user is requesting the password however the username have to match with the email address stored into the database. This script can be used as a [Windows Service](https://en.wikipedia.org/wiki/Windows_service) with [NSSM](https://nssm.cc) which will run in the background checking every 5 seconds the logs generated by PvPGN. When an account owner is requesting the password to be reseted this script will send an email to the owner with the authentification details.

## Requirments:

- PvPGN logs must be enabled.
- SMTP Server.
- PHP Client.
- NSSM(the Non-Sucking Service Manager).

## How to enable PvPGN logs?

Edit the `bnetd.conf` file from `PvPGN/conf` folder and search for the string `loglevels`.

`loglevels = info`

## How to install and configure?

**1)** Download + extract [this](https://github.com/rnyweb/pvpgn-password-request/archive/master.zip) repostory to PvPGN folder and rename the extracted folder to `sendmail`.

**2)** Edit the `config.php` file from the `sendmail` folder and set the required information such as your path to PvPGN folder and a SMTP server.

**3)** Download [PHP for windows](https://windows.php.net/download)(non-thread safe version) + extract to your PvPGN folder and rename the extracted folder to PHP.

**4)** OpenSSL **must** be enabled for the PHP Mailer and by default a portable version of PHP does **not** contain a php.ini file with all the extensions enabled. To do this rename the `php.ini-development` file to `php.ini` then edit it.
Search the next stings `extension_dir = "ext"`, `extension=openssl` and uncomment those lines by deleting the first character`(;)` of each line.

**5)** Download [NSSM](https://nssm.cc/download)(the Non-Sucking Service Manager) + extract, open the extracted folder and copy your architecture(`win32` or `win64`) folder to PvPGN folder. Rename the architecture folder to `nssm`.

**6)** Open cmd.exe under Administrator privilage and change the directory to NSSM path and insert the next following commands:

`nssm install "PvPGN Mailer" "C:\Users\Administrator\Desktop\PvPGN Server\php\php.exe"`

`nssm set "PvPGN Mailer" Description "PvPGN Password Request."`

**Warning!** If path to PvPGN path folder contains any spaces, it must be quoted + quote the quotation marks. For more information see the [usage](https://nssm.cc/usage) on section **Quoting issues**.

`nssm set "PvPGN Mailer" AppParameters """C:\Users\Administrator\Desktop\PvPGN Server\sendmail\mailer.php"""`

**7)** Start the service.

`nssm start "PvPGN Mailer"`

## NSSM extra commands:

To manually verify the data.

`nssm edit "PvPGN Mailer"`

Remove the service.

`nssm remove "PvPGN Mailer" confirm`

For more information check the [commands list](https://nssm.cc/commands).

## NSSM vs SC(Service Control)

By default you can add a service through Windows Service Control, however a PHP script will not run properly because `php.exe` is not meant to be a service. In the other hand NSSM, as the name says is a "Non-Sucking Service Manager" that can make the Windows to believe that `php.exe` is a service.

## Donations:

Our purpose in life is to make everybody around happy. Donations mean that somebody on this earth finds my work useful and that makes me as developer happy.

PayPal: [https://www.paypal.me/rnyit](https://www.paypal.me/rnyit)

Bitcoin Address: [bc1qpkfmlrwfk4mrfjfgds3vcrp0djj92d9qjzq5zy](https://www.blockchain.com/btc/address/bc1qpkfmlrwfk4mrfjfgds3vcrp0djj92d9qjzq5zy)

## Tested on:

- OS: Windows 2012 Server Standard.
- PvPGN version: 1.8.5.
- PHP version: 7.3.4.
- NSSM version: 2.24.
