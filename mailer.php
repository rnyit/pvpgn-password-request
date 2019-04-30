<?php
require('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(logs === 1) {
	echo 'Logs are enabled.' . PHP_EOL;
} else {
	echo 'Logs are disabled.' . PHP_EOL;
}

echo '===================================================================' . PHP_EOL;

$message = '[' . date('m.d.y h:i:sa') . '] PvPGN Request Password Script.' . PHP_EOL;
echo $message;

if(logs === 1) {
	save_logs($message);
}

unset($message);

loop();

function save_logs($message) {
	file_put_contents(path . '\var\mailer.log', $message, FILE_APPEND);
}

function loop() {
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
				$message = '[' . date('m.d.y h:i:sa') . '] Username ' . $username . ' made a request for the password.' . PHP_EOL;
				echo $message;
				if(logs === 1) {
					save_logs($message);
				}
				unset($message);
				$search = 'BNET\\\acct\\\passhash1';
				$lines = file(path . '\var\users\\' . $username);
				$line_number = false;
				while(list($key, $line) = each($lines) and !$line_number) {
					if(strpos($line, $search) !== false) {
						$line_number = $key + 1;
					}
				}
				$split_hash = explode('=', trim($lines[$line_number - 1]));
				$hash = substr($split_hash[1], 1, -1);
				$password = decrypt_hash($hash);
				send_mail($username, $email, $password);
			}
		}
		fclose($log_file);
		$size = $current_size;
	}
}

function decrypt_hash($hash) {
	$url = 'http://harpywar.pvpgn.pl/api.php?method=crack&hash=' . $hash;
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
		$mail->Host = host;
		$mail->Port = port;
		$mail->Username = smtp_username;
		$mail->Password = smtp_password;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->setFrom(from_email, from_name);
		$mail->addAddress($email);
		$mail->isHTML(true);
		$mail->Subject = 'Password requested';
		$mail->Body = '<p>Your username <b>' . $username . '</b> has the password: <b>' . $password . '</b></p>';
		$mail->AltBody = 'Your username ' . $username . ' has the password: ' . $password;
		$mail->send();
		$message = '[' . date('m.d.y h:i:sa') . '] Email has been sent to: ' . $email . PHP_EOL;
		echo $message;
	} catch(Exception $e) {
		$message = '[' . date('m.d.y h:i:sa') . '] Email could not be sent. Mailer Error: ' . $mail->ErrorInfo . PHP_EOL;
		echo $message;
	}
	if(logs === 1) {
		save_logs($message);
	}
	unset($message);
}
?>
