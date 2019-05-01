<?php
///////////////////////////////////////////////////////////////////////
// Config.                                                           //
//                                                                   //
// Set the PvPGN path directory and SMTP information.                //
// By default the logs are set to value 1 which means the script     //
// will generate logs.                                               //
// To get the valid time and date for the logs your timezone         //
// location must be set otherwise the time and date won't be         //
// accurate.                                                         //
// The logs are generated and stored in var folder on mailer.log     //
// file.                                                             //
///////////////////////////////////////////////////////////////////////

// PvPGN path directory.
define('path', 'D:\PvPGN Server');

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
// 1 = Enabled.
// 0 = Disabled.
define('logs', 1);

// Timezone.
// https://www.php.net/manual/en/timezones.php
date_default_timezone_set('America/Los_Angeles');
?>
