<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

/* CUSTOMER DATA */
define("sitename", "Condivision Cloud");
define("client", "DEMO");
define('LOGO_MAIL', 'https://www.comune.bitetto.ba.it/set/lay/logo.png');


/*ROOT*/
define('DOCUMENT_ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));
//define('DOCUMENT_ROOT','../lib/PHPMailer/');
// echo DOCUMENT_ROOT;

/*AUTH DATA*/
define("mail_host", "mail.aryma.it");
define('SMTPSecure', 'ssl');
define('Port', '465');
define("mail_name", client);
define("mail_user", " webmaster@comune.bitetto.ba.it");
define("mail_password", "dsq432%g!d3");


/*REPLY AND SUPPORT */
define("reply_to", 'info@aryma.it');
define("mail_admin", "support@aryma.it");
define("mail_copy", "info@aryma.it");

/*SEND A MAIL*/
$whistCode = base64_encode(time());
$whistCode = str_replace("==", "", $whistCode);

$emailto = 'vitomichele.fazio@gmail.com';
$subjet = 'Segnalazione Whistleblower #' . $whistCode;
$messaggio = '<p>Hai Ricevuto una nuova segnalazione, per consultarla inserisci il codice:</p> <h2>' . $whistCode . '</h2>';

$attachment = '';
$attachmentname = '';


/* System Core */
function smail($destinatario, $soggetto, $messaggio, $from = '', $nameFrom = '', $allegato = '', $allname = '', $file = 0, $AddCC = array(), $AddBCC = array(), $workflow_id = '', $record_id = '')
{

  if (!defined('SMTPSecure')) define('SMTPSecure', '');
  if (!defined('Port')) define('Port', '25');

  if (!file_exists(DOCUMENT_ROOT . '/whistleblower/lib/PHPMailer/PHPMailerAutoload.php')) die('Non trovo classe mailer, vedi DOCUMENT_ROOT');
  require_once(DOCUMENT_ROOT . '/whistleblower/lib/PHPMailer/PHPMailerAutoload.php');

  $mail = new PHPMailer;
  $mail->SMTPAuth = true;
  $mail->SMTPDebug = 0;
  $mail->Debugoutput = 'html';
  $mail->Host = mail_host;
  $mail->SMTPSecure = SMTPSecure;
  $mail->Port = Port;
  $mail->Username = mail_user;
  $mail->Password = mail_password;
  $mail->CharSet = 'UTF-8';

  $nameFrom = ($nameFrom != '') ? $nameFrom : mail_name;
  $from = ($from != '') ? $from : mail_user;
  $mail->setFrom($from, $nameFrom);
  //if(defined('reply_to') && reply_to != '') $mail->addReplyTo(reply_to, $nameFrom);
  //if(isset($_SESSION['mail'])) $mail->addReplyTo($_SESSION['mail'], $nameFrom);

  $ccList = '';
  $bccList = '';
  $mail->addAddress($destinatario, $destinatario);
  //foreach ($AddBCC as $key => $value) { $mail->AddBCC($value,$value); $ccList .= $value; }
  //foreach ($AddCC as $key => $value) { $mail->AddCC($value,$value); $bccList .= $value; }


  $mail->Subject = $soggetto;
  $mail->Body = $messaggio;
  $mail->AltBody = 'To view this email please enable HTML';
  if ($allegato != '' && $file == 0) $mail->AddStringAttachment($allegato, $allname, 'base64', 'application/pdf');
  if ($file == 1) $mail->addAttachment($allegato, $allname);

  if (!$mail->send()) {
    mail(mail_admin, ROOT . '..:: Errore funzione smail ' . mail_host . ' port ' . Port, $mail->ErrorInfo);
    //if(defined('mail_send_log')) mail_save($from,$destinatario,$ccList,$bccList,$soggetto,$messaggio,0,$mail->ErrorInfo,$workflow_id,$record_id); 
    echo "Didn't work";
    return $mail->ErrorInfo;
  } else {
    if (defined('mail_send_log')) mail_save($from, $destinatario, $ccList, $bccList, $soggetto, $messaggio, 1, 'INVIATA', $workflow_id, $record_id);
    return true;
  }

  $mail->clearAddresses();
  $mail->clearAttachments();
}

$mail_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Email</title>
    <style>
      a {
        color: #3CB142;
        text-decoration: none !important;
      }

      @media only screen and (max-width: 599px){
        /*CLIENT-SPECIFIC MOBILE STYLES */
        body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:none !important;} /* Prevent Webkit platforms from changing default text sizes */
        body{width:100% !important; min-width:100% !important;} /* Prevent iOS Mail from adding padding to the body */
        #bodyCell{padding:10px !important;}

        .flexibleContainer {
          width:85% !important;
        }

        #templateContainer{
          max-width:600px !important;
          width:100% !important;
        }
        h1{
          font-size:24px !important;
          line-height:100% !important;
        }
      }
    </style>
  </head>
  <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="color: #666; background-color:#F2F2F2;width:100% !important;height:100% !important;padding:0;margin:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
    <center>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="background-color:#F2F2F2;width:100% !important;padding:0;margin:0;height:100% !important;border-collapse:collapse !important;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
        <tr>
          <td align="center" valign="top" id="bodyCell" style="width:100% !important;padding:0px;margin:0;height:100% !important;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
            <!-- BEGIN TEMPLATE // -->
            <table border="0" cellpadding="0" cellspacing="0" id="templateContainer" style="border:1px solid #DDDDDD;border-bottom-color:#CCCCCC;max-width:500px !important;border-collapse:collapse !important;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
              <tr>
                <td align="center" valign="top" style="mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                  <!-- BEGIN BODY // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody" style="border-bottom:1px solid #CCCCCC;border-top:1px solid #FFFFFF;background-color:#FFFFFF;border-collapse:collapse !important;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                    <tr>
                      <td valign="top" class="bodyContent" mc:edit="body_content" style="text-align:center;padding-left:20px;padding-bottom:30px;padding-right:20px;padding-top:30px;line-height:150%;font-size:15px;font-family:Helvetica;color:#4E524E;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
					  <h1><img src="' . LOGO_MAIL . '" alt="Logo"></h1>
					  
					 </td>
                    </tr>
                    <tr width="100%">
                      <td align="center" valign="top" style="mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                      

                       
                        <!-- CENTERING TABLE // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse !important;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                          <tr height="47">
                            <td align="center" valign="top" style="mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                             

                              <!-- FLEXIBLE CONTAINER // -->[*CORPO*]<!-- // FLEXIBLE CONTAINER -->
                          

                            </td>
                          </tr>
                        </table>
                        <!-- // CENTERING TABLE -->


                      </td>
                    </tr>
                    <tr width="100%">
                      <td align="center" valign="top" style="mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                        <!-- CENTERING TABLE // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="70%" style="border-collapse:collapse !important;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
                          <tr>
                            <td valign="top" class="bodyContent" mc:edit="body_content" style="text-align:center;padding-left:20px;padding-bottom:30px;padding-right:20px;padding-top:30px;font-family:Helvetica;mso-table-rspace:0pt;mso-table-lspace:0pt;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;color:#4E524E;line-height:13px;font-size:11px;"> 
							<p style="font-size: smaller;">
							<strong>Informativa Sulla Privacy</strong><br>
Ai sensi e per effetti del T.U. sulla privacy (D.Lgs 196/03), questa mail &egrave; destinata unicamente alle persone sopra indicate e le informazioni in essa contenute sono da considerarsi strettamente riservate.&Egrave; proibito leggere, copiare, usare o diffondere il contenuto della presente mail senza il consenso del mittente.
Se ricevete  questo messaggio per errore, siete pregati di segnalarlo al mittente. Per le comunicazioni relative alla privacy e richieste di trattamento secondo il D.Lgs 196/03 utilizzare la mail ' . reply_to . '. Il titolare dei dati &egrave; : ' . client . '

</p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <!-- // END BODY -->
                </td>
              </tr>
            </table>
            <!-- // END TEMPLATE -->
          </td>
        </tr>
      </table>
    </center>
  </body>
</html>';

$mail_txt = str_replace("[*CORPO*]", $messaggio, $mail_template); //we insert content in a template

$esito = smail($emailto, $subjet, $mail_txt, '', '', $attachment, $attachmentname, 1);

if ($_POST['email']) {
  $emailto = $_POST['email'];
  $messaggio = '<p>Hai enviato una nuova segnalazione, per consultarla inserisci il codice:</p> <h2>' . $whistCode . '</h2>';
  $mail_txt = str_replace("[*CORPO*]", $messaggio, $mail_template);
  $esito = smail($emailto, $subjet, $mail_txt, '', '', $attachment, $attachmentname, 1);
}

if (!defined('mail_template')) define("mail_template", $mail_template);
unset($mail_template);

if ($esito && $_POST['email']) {
  $callback  = array('code' => $whistCode, 'success' => $esito, 'double' => true);
  echo json_encode($callback);
} elseif ($esito) {
  $callback  = array('code' => $whistCode, 'success' => $esito);
  echo json_encode($callback);
} else {
  $callback  = array('success' => $esito);
  echo json_encode($callback);
}
