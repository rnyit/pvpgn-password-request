# pvpgn-password-request
PvPGN password request script. [PHP]

What is PvPGN?
* PvPGN (Player vs Player Gaming Network) is a free and open source software project offering emulation of various gaming network servers. It is published under the GPL and based upon bnetd.
* It currently supports most features of all Battle.net classic clients (Diablo, Diablo II, Diablo II: Lord of Destruction, StarCraft, StarCraft: Brood War, Warcraft II: Battle.net Edition, Warcraft III: Reign of Chaos, Warcraft III: The Frozen Throne). It also offers basic support for Westwood Online clients (Command & Conquer: Tiberian Sun, Command & Conquer: Red Alert 2, Command & Conquer: Yuri's Revenge).


What is PvPGN password request?
* PvPGN does not support officially the function to request your password and this script can be used to have that function working on any PvPGN server.

Requirments:
* PHP Windows.
* NSSM(the Non-Sucking Service Manager).

What is PHP?
What is NSSM?

Tested on:
* OS: Windows 2012 Server Standard.
* PvPGN version: 1.8.5.
* PHP version: 7.3.4.
* NSSM version: 2.24.

How to implement?
* 1) Download and extract this repostory to your PvPGN folder.
* 2) Edit config.php file and set the required information such as your path to PvPGN folder and a SMTP server.
* 3) Add the script to run as a windows service with NSSM(the Non-Sucking Service Manager).

=
nssm install "PvPGN Mailer" C:\Users\Administrator\Desktop\php\php.exe
nssm set "PvPGN Mailer" Description PvPGN PHP Mailer.
nssm set "PvPGN Mailer" AppDirectory C:\Users\Administrator\Desktop\php
nssm set "PvPGN Mailer" AppParameters C:\Users\Administrator\Desktop\sendmail\mailer.php
=

To manually verify the data

nssm edit "PvPGN Mailer"

To remove

nssm remove "PvPGN Mailer" confirm

!delay
