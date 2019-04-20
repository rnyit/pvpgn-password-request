<?php
///////////////////////////////////////////////////////////////////////
// Config.                                                           //
//                                                                   //
// Set the PvPGN path directory, SMTP information and set the script //
// to output logs to a file. The log file will be generated and      //
// located in the var folder on mailer.log file from the PvPGN       //
// folder.                                                           //
///////////////////////////////////////////////////////////////////////

// PvPGN path directory.
define('path', 'D:\Diablo II Server');

// SMTP server hostname.
define('host', 'smtp.domain.tld');

// SMTP port.
define('port', 587);

// SMTP username.
define('smtp_username', 'username@domain.tld');

// SMTP password.
define('smtp_password', 'SecretPassword123');

// From name.
define('from_name', 'PvPGN Private Server');

// From email.
define('from_email', 'username@domain.tld');

// Logs.
// 0 = Logs disabled.
// 1 = Logs enabled.
define('logs', 1);
?>
