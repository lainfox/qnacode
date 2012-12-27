<?
function qa_send_email($params)
{
  require_once QA_INCLUDE_DIR.'qa-class.phpmailer.php';
  require_once dirname(__FILE__) . '/class.smtp.php';
 
  $mailer=new PHPMailer();
  $mailer->CharSet='utf-8';
  $mailer->IsSMTP(); // enable SMTP
  $mailer->SMTPAuth = true;
  $mail->SMTPSecure = 'ssl'; 
  $mailer->Host = "ssl://smtp.gmail.com:465";
  $mailer->Username = "<your gmail email address here>";
  $mailer->Password = "<your gmail password here >";
 
 
  $mailer->From=$params['fromemail'];
  $mailer->Sender=$params['fromemail'];
  $mailer->FromName=$params['fromname'];
  $mailer->AddAddress($params['toemail'], $params['toname']);
  $mailer->Subject=$params['subject'];
  $mailer->Body=$params['body'];
 
  if ($params['html'])
    $mailer->IsHTML(true);
 
  return $mailer->Send();
}