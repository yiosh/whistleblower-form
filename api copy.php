<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../set/cnf/main.php'); // Variabili Modulo 
site_start('utf-8');

// Test headers, remove on production
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

if (isset($_POST['insertForm'])) {
  insertForm();
}

if (isset($_POST['insertCode'])) {
  insertCode($_POST['id'], $_POST['secretCode']);
}

if (isset($_POST['fetchForm'])) {
  fetchForm($_POST['secretCode']);
}

if (isset($_POST['fetchAllForms'])) {
  fetchAllForms();
}

if (isset($_POST['fetchComments'])) {
  fetchComments($_POST['formId']);
}

if (isset($_POST['insertComment'])) {
  insertComment($_POST['formId'], $_POST['text']);
}

if (isset($_POST['checkPassword'])) {
  checkPassword($_POST['password']);
}

if (isset($_POST['checkSession'])) {
  checkSession();
}


// Insert form on DB
function insertForm()
{
  $token = $_POST['token'];
  $secret = "6LfDWcgUAAAAAIuCKuaLUZnl5ITn1IWoIZBoPE6n";
  $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $token;
  $response = file_get_contents($url);
  $response = json_decode($response);

  if ($response->success == false) {
    # code...
    echo json_encode($response);
  }
  // exit;

  $fileExistsFlag = 0;
  $nome = base64_encode($_POST['nome']);
  $cognome = base64_encode($_POST['cognome']);
  $qualificaProfessionale = $_POST['qualificaProfessionale'];
  $sedeServizio = $_POST['sedeServizio'];
  $telefono = base64_encode($_POST['telefono']);
  $email = base64_encode($_POST['email']);
  $dataDa = $_POST['dataDa'];
  $dataA = $_POST['dataA'];
  $luogoFatto = $_POST['luogoFatto'];
  $azioniValore = base64_encode($_POST['azioniValore']);
  $descrizioneFatto = $_POST['descrizioneFatto'];
  $autoreFatto = $_POST['autoreFatto'];
  $eventualiSoggetti = $_POST['eventualiSoggetti'];

  $query = "INSERT INTO `fl_whistleblower` (`nome`, `cognome`, `qualifica_professionale`, `sede_servizio`, `telefono`, `email`, `data_da`, `data_a`, `luogo_fatto`, `azioni_valore`, `descrizione_fatto`, `autore_fatto`, `eventuali_soggetti`, `created_at`,`updated_at`) VALUES ('$nome', '$cognome', '$qualificaProfessionale', '$sedeServizio', '$telefono', '$email', '$dataDa', '$dataA', '$luogoFatto', '$azioniValore', '$descrizioneFatto', '$autoreFatto', '$eventualiSoggetti', NOW(), NOW());";
  mysql_query($query, CONNECT);
  $idRecord = mysql_insert_id(CONNECT);
  $msg = "";

  $query = "UPDATE `fl_whistleblower` SET `eventualli_allegati`=$idRecord WHERE id='$idRecord'";
  mysql_query($query, CONNECT);

  /*
    * If file is not present in the destination folder
  */

  if ($fileExistsFlag == 0) {
    if (sizeof($_FILES) > 1) {
      mkdir("upload/" . $idRecord . "/");
      for ($i = 0; $i < sizeof($_FILES); $i++) {
        $target = "upload/" . $idRecord . "/";
        $fileName = $_FILES['file' . $i]['name'];
        echo $fileName;
        $fileTarget = $target . $fileName;
        $tempFileName = $_FILES["file" . $i]["tmp_name"];
        $result = move_uploaded_file($tempFileName, $fileTarget);

        /*
          *	If file was successfully uploaded in the destination folder
        */

        if ($result) {
          $msg = "Your file" . $fileName . " has been successfully uploaded";
          $query = "INSERT INTO fl_whistleblower_files(filepath,filename,form_id, created_at, updated_at) VALUES ('$fileTarget','$fileName','$idRecord', NOW(), NOW())";
          mysql_query($query, CONNECT);
        } else {
          $msg = "Sorry !!! There was an error in uploading your file";
        }
      }
    } else if (isset($_FILES['file0']['name']) && isset($_FILES['file0']['tmp_name'])) {
      mkdir("upload/" . $idRecord . "/");
      $target = "upload/" . $idRecord . "/";
      $fileName = $_FILES['file0']['name'];
      $fileTarget = $target . $fileName;
      $tempFileName = $_FILES['file0']['tmp_name'];
      $result = move_uploaded_file($tempFileName, $fileTarget);

      /*
        *	If file was successfully uploaded in the destination folder
      */

      if ($result) {
        // echo "result" . $result;
        $msg = "Your file " . $fileName . " has been successfully uploaded";
        $query = "INSERT INTO fl_whistleblower_files(filepath,filename,form_id, created_at, updated_at) VALUES ('$fileTarget','$fileName','$idRecord', NOW(), NOW())";
        mysql_query($query, CONNECT);
      } else {
        $msg = "Sorry !!! There was an error in uploading your file";
      }
    }
  }

  /*
    * If file is already present in the destination folder
  */ else {
    $msg = "File <html><b><i>" . $fileName . "</i></b></html> already exists in your folder. Please rename the file and try again.";
    mysqli_close(CONNECT);
  }
  ob_end_clean();
  $arr = array('id' => $idRecord, "msg" => $msg, "recaptcha" => json_encode($response));
  echo json_encode($arr);
}

function insertCode($id, $secretCode)
{
  $query = "UPDATE `fl_whistleblower` SET `secret_code`='$secretCode' WHERE id='$id'";
  $result = mysql_query($query, CONNECT);
  if ($result) {
    $arr = array('id' => $id, 'code' => $secretCode);
    echo json_encode($arr);
  } else {
    echo "Error:" . mysql_error(CONNECT);
  };
}

function fetchForm($secretCode)
{
  $query = "SELECT * FROM `fl_whistleblower` WHERE `secret_code`='$secretCode'";
  $result = mysql_query($query, CONNECT);
  if ($result) {
    $arr = mysql_fetch_assoc($result);
    $arr['azioni_valore'] = base64_decode($arr['azioni_valore']);
    $formId = $arr['id'];
    $files = glob("upload/" . $formId . "/*");
    $arrFiles = [];
    if (count($files) > 0) {
      foreach ($files as $file) {
        array_push($arrFiles, array("file" => basename($file), "path" => dirname($file)));
      }
    }
    // } else {
    //   array_push($arrFiles, array("file" => basename($files), "path" => dirname($files)));
    // }
    ob_end_clean();
    $result = array("form" => $arr, "files" => $arrFiles);
    echo json_encode($result);
  } else {
    echo "Error:" . mysql_error(CONNECT);
  };
}

function fetchAllForms()
{
  $query = "SELECT * FROM `fl_whistleblower` ORDER BY id DESC";
  $result = mysql_query($query, CONNECT);
  if ($result->num_rows > 0) {
    $arr = [];
    while ($row = mysql_fetch_assoc($result)) {
      $r = $row;
      array_push($arr, $r);
    };
    $arr['azioni_valore'] = base64_decode($arr['azioni_valore']);
    ob_end_clean();
    echo json_encode($arr);
  } else {
    ob_end_clean();
    echo "Error:" . mysql_error(CONNECT);
  };
}

function fetchComments($id)
{
  $query = "SELECT * FROM `fl_whistleblower_comments` WHERE `form_id`='$id'";
  $result = mysql_query($query, CONNECT);
  if ($result) {
    $arr = [];
    while ($row = mysql_fetch_assoc($result)) {
      $r = array("id" => $row["id"], "text" => $row["text"], "createdAt" => $row["created_at"]);
      array_push($arr, $r);
    };
    echo json_encode($arr);
    // $arr = [];
  } else {
    echo "Error:" . mysql_error(CONNECT);
  };
}

function insertComment($formId, $text)
{
  $date = date("Y-m-d H:i:sa");
  $query = "INSERT INTO `fl_whistleblower_comments`(`form_id`, `text`, `created_at`) VALUES ('$formId', '$text', '$date')";
  $result = mysql_query($query, CONNECT);
  if ($result) {
    $idRecord = mysql_insert_id(CONNECT);
    ob_end_clean();
    $arr2 = array("idRecord" => $idRecord);
    echo json_encode($arr2);
  } else {
    echo "Error:" . mysql_error(CONNECT);
  };
}

function checkPassword($password)
{
  ob_end_clean();
  $password_set = "19aeuSegBi20!@";
  if ($password === $password_set) {
    if (!isset($_SESSION)) {
      session_start();
    }
    $_SESSION['status'] = "OK";
    echo json_encode(array("status" => "OK"));
  } else {
    echo json_encode(array("msg" => "Password errato"));
  }
}

function checkSession()
{
  ob_end_clean();
  if (isset($_SESSION['status'])) {
    echo json_encode(array("status" => "OK"));
  } else {
    echo json_encode(array("status" => "KO"));
  }
}



mysql_close(CONNECT);
exit;
