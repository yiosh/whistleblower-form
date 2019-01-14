<?php
// header('Content-Type: application/x-www-form-urlencoded');
$fileName = $_FILES["file"]['name'];
echo json_encode($fileName);

$target = "upload/"; 
$fileTarget = $target.$fileName;
echo json_encode($fileTarget);
$tempFileName = $_FILES["file"]["tmp_name"];
$result = move_uploaded_file($tempFileName,$fileTarget);

if($result) { 
    echo "Worked";
  }
  else { 
    echo "Sorry !!! There was an error in uploading your file"; 
  }
echo json_encode($_POST);
echo json_encode($_FILES);
//     ini_set('display_errors',1);
//     error_reporting(E_ALL);

//     header('Access-Control-Allow-Origin: *');  
//     include('../set/cnf/main.php'); // Variabili Modulo 
//     site_start('utf-8');
//     function crypy($var) { return base64_encode($var); };
    
//     $messaggio = 'TEST';
//     var_dump($_POST);

//     foreach($_POST as $key=>$value){
//     $value = check($value);
//     $messaggio .= '<p>'.$key.'='.$value.'</p>';
//     }
//     // Insert Data on DB
//     $query = "INSERT INTO `fl_whistleblower` (`id`, `nome`, `cognome`, `qualifica_professionale`, `serde_servizio`, `telefono`, `email`, `data_da`, `data_a`, `luogo_fatto`, `azioni_valore`, `descrizione_fatto`, `autore_fatto`, `eventuali_soggetti`, `eventualli_allegati`)
//      VALUES (NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '');";

//     mysql_query($query,CONNECT);
//     $idRecord = mysql_insert_id();
//     $pinCode = crypy($idRecord.time());


//   // Insert file (check errors)
//     if(isset($_FILES["files"])){
//     $numFiles = sizeof($_FILES["files"]["name"]);
//     for ($i=0; $i < $numFiles; $i++) { 
//         # code...
//         // var_dump($_FILES["files"]["tmp_name"][$i]);
//         if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], "./upload/".$_FILES['file']['name'][$i])) {
//             echo "done";
           
//         }
//     }}
    
//       // send email
//     echo smail('vitomichele.fazio@gmail.com','Test Whistleblower comune di bitetto',$messaggio);



//     mysql_close(CONNECT);
//     exit;
?>