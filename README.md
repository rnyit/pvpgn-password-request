# pvpgn-password-request
PvPGN password request script. [PHP]

## What is PvPGN?

[PvPGN](https://pvpgn.pro)(Player vs Player Gaming Network) is a free and open source software project offering emulation of various gaming network servers. It is published under the GPL and based upon bnetd.
It currently supports most features of all Battle.net classic clients (Diablo, Diablo II, Diablo II: Lord of Destruction, StarCraft, StarCraft: Brood War, Warcraft II: Battle.net Edition, Warcraft III: Reign of Chaos, Warcraft III: The Frozen Throne). It also offers basic support for Westwood Online clients (Command & Conquer: Tiberian Sun, Command & Conquer: Red Alert 2, Command & Conquer: Yuri's Revenge).

## What is PvPGN password request?

PvPGN password request is a script written in [PHP](https://www.php.net) with a [PHP Mailer](https://github.com/PHPMailer/PHPMailer) built-in that allow any PvPGN client to recover the password through a Battle.net private server that is running on PvPGN. Officially, PvPGN has no built-in function to rocover a lost password and this script can be used to have that function working.

## How is working?

PvPGN does generate and output logs if a user is requesting a new password and if the username matches with the email address stored into the database. This script can be used as a [Windows Service](https://en.wikipedia.org/wiki/Windows_service) which is running in the background checking every 5 seconds the logs generated by PvPGN. When somebody is requesting the password for their account this script will trigger and an email will be sent to the user with the password stored into the database.

## Requirments:

- PvPGN logs must be enabled.
- SMTP Server.
- PHP Windows version.
- NSSM(the Non-Sucking Service Manager).

## How to install and configure?

**1)** Download + extract this repostory to PvPGN folder and rename the extracted folder to `sendmail`.

**2)** Edit the `config.php` file from the `sendmail` folder and set the required information such as your path to PvPGN folder and a SMTP server.

**3)** Download [PHP for windows](https://windows.php.net/download)(non-thread safe version) + extract to your PvPGN folder and rename the extracted folder to PHP.

**4)** OpenSSL **must** be enabled for the PHP Mailer and by default a portable version of PHP does **not** contain a php.ini file with all the extensions enabled. To do this rename the `php.ini-development` file to `php.ini` then edit it.
Search the next stings `extension_dir = "ext"`, `extension=openssl` and uncomment those lines by deleting the first character`(;)` of each line.

**5)** Download [NSSM](https://nssm.cc/download)(the Non-Sucking Service Manager) + extract, open the extracted folder and copy your architecture(`win32` or `win64`) folder to PvPGN folder.

**6)** Open cmd.exe under Administrator privilage and change the directory to NSSM path and insert the next following commands:

`nssm install "PvPGN Mailer" "C:\Users\Administrator\Desktop\PvPGN Server\php\php.exe"`

`nssm set "PvPGN Mailer" Description "PvPGN Password Request."`

**Important!** If path to PvPGN path folder contains any spaces, **must** be quoted + quote the quotation marks. For more information see the [usage](https://nssm.cc/usage) on section **Quoting issues**.

`nssm set "PvPGN Mailer" AppParameters """C:\Users\Administrator\Desktop\PvPGN Server\sendmail\mailer.php"""`

**7)** Start the service.

`nssm start "PvPGN Mailer"`

## NSSM extra commands:

To manually verify the data.

`nssm edit "PvPGN Mailer"`

Remove the service.

`nssm remove "PvPGN Mailer" confirm`

For more information check the [commands list](https://nssm.cc/commands).

## Done!

The script will now run in the background as a Windows service and it will start automatically every time the machine is rebooted. Do **not** delete the nssm folder or change the PvPGN folder location because is necessary to run the script.

## NSSM vs SC(Service Control)

By default you can add a service through Windows Service Control, however a PHP script will not run properly because `php.exe` is not meant to be a service. In the other hand NSSM, as the name says is a "Non-Sucking Service Manager" that can make the Windows to believe that `php.exe` is a service.

## Donations:

Our purpose in life is to make everybody around happy. Donations mean that somebody on this earth finds my work useful and that makes me as developer happy.

PayPal: [https://www.paypal.me/rnyweb](https://www.paypal.me/rnyweb)

Bitcoin: [1F2nuGUUxxqgnH22aFi6hzWVgcZxCgyuwM](https://www.blockchain.com/btc/address/1F2nuGUUxxqgnH22aFi6hzWVgcZxCgyuwM)

## Tested on:

- OS: Windows 2012 Server Standard.
- PvPGN version: 1.8.5.
- PHP version: 7.3.4.
- NSSM version: 2.24.
