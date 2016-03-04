<?php 
/**
 * 邮件发送类
 */
require(BASE_DIR.'Water/Lib/PHPMailer/PHPMailerAutoload.php');
Class Mail{
	function Send($config){
		$mail = new PHPMailer;

		if (isset($config['debug'])) $mail->SMTPDebug = 3;
		
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();
		$mail->Host = $config['host'];
		$mail->Port = $config['port'];
		$mail->SMTPAuth = true;
		$mail->Username = $config['username'];
		$mail->Password = $config['password'];
		if (isset($config['SMTPSecure'])) $mail->SMTPSecure = 'tls'; // or ssl

		$mail->setFrom($config['from']['email'], empty($config['from']['name']) ? '' : $config['from']['name']);
		foreach ($config['to'] as $v) {
			$mail->addAddress($v['email'], empty($v['name']) ? '' : $v['name']);
		}
		if (isset($config['replyTo'])) {
			foreach ($config['replyTo'] as $v) {
				$mail->addReplyTo($v['email'], empty($v['name']) ? '' : $v['name']);
			}
		}
		if (isset($config['cc'])) {
			foreach ($config['cc'] as $v) {
				$mail->addCC($v['email'], empty($v['name']) ? '' : $v['name']);
			}
		}
		if (isset($config['bcc'])) {
			foreach ($config['bcc'] as $v) {
				$mail->addBCC($v['email'], empty($v['name']) ? '' : $v['name']);
			}
		}
		if (isset($config['attachments'])) {
			foreach ($config['attachments'] as $v) {
				$mail->addAttachment($v['filepath'], empty($v['filename']) ? '' : $v['filename']);
			}
		}

		$mail->isHTML(isset($config['isHtml']) ? $config['isHtml'] : true);

		$mail->Subject = $config['subject'];
		$mail->Body    = $config['content'];
		$mail->AltBody = isset($config['contentNotHtml']) ? $config['contentNotHtml'] : strip_tags($config['content']);

		if(!$mail->send()) {
			return array('code' => 0, 'msg' => $mail->ErrorInfo);
		} else {
			return array('code' => 1, 'msg' => 'success');
		}
	}
}