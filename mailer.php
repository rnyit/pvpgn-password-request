<?php
require('config.php');

error_reporting(errors);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(logs === 1) {
  echo activity('Logs are enabled.', false);
  echo activity('Location: ' . path . '\var\mailer.log', false);
} else {
  echo activity('Logs are disabled.', false);
}

echo activity('===============================================================', false);
echo activity('[' . date('m.d.y h:i:sa') . '] PvPGN password request script is running.', true);

$size = filesize(path . '\var\bnetd.log');
while(true) {
  clearstatcache();
  $current_size = filesize(path . '\var\bnetd.log');
  if($size == $current_size) {
    sleep(5);
    continue;
  }
  $log_file = fopen(path . '\var\bnetd.log', 'r');
  fseek($log_file, $size);
  while($line = fgets($log_file)) {
    $split_line = explode(' ', trim($line));
    if($split_line[5] === '_client_getpasswordreq:') {
      $username = substr($split_line[11], 1, -1);
      $email = substr($split_line[14], 1, -1);
      echo activity('[' . date('m.d.y h:i:sa') . '] Get password for account ' . $username . '.', true);
      $search_string = 'BNET\\\acct\\\passhash1';
      $array = file(path . '\var\users\\' . $username);
      foreach($array as $index => $string) {
        if(strpos($string, $search_string) !== false)
        $line_number = $index;
      }
	  $split_hash = explode('=', trim($array[$line_number]));
      $hash = substr($split_hash[1], 1, -1);
      $password = decrypt_hash($hash);
      send_mail($username, $email, $password);
    }
  }
  fclose($log_file);
  $size = $current_size;
}

function activity($message, $logs) {
  if(logs === 1) {
    if($logs === true) {
      file_put_contents(path . '\var\mailer.log', $message . PHP_EOL, FILE_APPEND);
    }
  }
  return $message . PHP_EOL;
}

function decrypt_hash($hash) {
  $url = 'https://pvpgn.pro/passhash/api.php?method=crack&hash=' . $hash;
  $password = file_get_contents($url);
  return $password;
}

function send_mail($username, $email, $password) {
  require_once 'phpmailer/Exception.php';
  require_once 'phpmailer/PHPMailer.php';
  require_once 'phpmailer/SMTP.php';
  $mail = new PHPMailer(true);
  try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = smtp_server;
    $mail->Port = smtp_port;
    $mail->Username = smtp_username;
    $mail->Password = smtp_password;
    $mail->SMTPAutoTLS = false;
    $mail->setFrom(mail_from, mail_name);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Password requested';
    $mail->Body = '<p>Your username <b>' . $username . '</b> has the password: <b>' . $password . '</b></p>';
    $mail->AltBody = 'Your username ' . $username . ' has the password: ' . $password;
    $mail->send();
	echo activity('[' . date('m.d.y h:i:sa') . '] Mail has been sent to ' . $email . '.', true);
  } catch(Exception $e) {
    echo activity('[' . date('m.d.y h:i:sa') . '] Mail could not be sent. ' . $mail->ErrorInfo, true);
  }
}
