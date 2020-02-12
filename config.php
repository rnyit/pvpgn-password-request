<?php
// Debugging
// Use value 0 to hide all PHP errors or value -1 to show them all.
define('errors', 0);

// PvPGN location path
define('path', 'C:\PvPGN');

// Save logs
// Use value 0 to not save the logs and 1 to do it.
define('logs', 1);

// SMTP server IP address or hostname
define('smtp_server', 'smtp.server.com');

// SMTP port
define('smtp_port', 25);

// SMTP username
define('smtp_username', 'username@server.com');

// SMTP password
define('smtp_password', 'Password!@#');

// Mail name
define('mail_name', 'PvPGN Private Server');

// Mail from address
define('mail_from', 'username@server.com');

// Timezone
// https://www.php.net/manual/en/timezones.php
date_default_timezone_set('America/Los_Angeles');
