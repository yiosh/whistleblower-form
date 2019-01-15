<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);

    include('../set/cnf/main.php'); // Variabili Modulo 
    site_start('utf-8');

    // foreach($_POST as $key=>$value){
    // $value = check($value);
    // $messaggio .= '<p>'.$key.'='.$value.'</p>';
    // }
    // Insert Data on DB

    $fileExistsFlag = 0; 
    // $link = mysqli_connect("localhost","root","","aryma_bitetto") or die("Error ".mysqli_error($link));
  
    $nome = base64_encode($_POST['nome']);
    $cognome = base64_encode($_POST['cognome']);
    $qualificaProfessionale = $_POST['qualificaProfessionale'];
    $sedeServizio = $_POST['sedeServizio'];
    $telefono = base64_encode($_POST['telefono']);
    $email = base64_encode($_POST['email']);
    $dataDa = $_POST['dataDa'];
    $dataA = $_POST['dataA'];
    $luogoFatto = $_POST['luogoFatto'];
    $azioniValore = $_POST['azioniValore'];
    $descrizioneFatto = $_POST['descrizioneFatto'];
    $autoreFatto = $_POST['autoreFatto'];
    $eventualiSoggetti = $_POST['eventualiSoggetti'];
  
    $query = "INSERT INTO `fl_whistleblower` (`nome`, `cognome`, `qualifica_professionale`, `serde_servizio`, `telefono`, `email`, `data_da`, `data_a`, `luogo_fatto`, `azioni_valore`, `descrizione_fatto`, `autore_fatto`, `eventuali_soggetti`, `created_at`,`updated_at`) VALUES ('$nome', '$cognome', '$qualificaProfessionale', '$sedeServizio', '$telefono', '$email', '$dataDa', '$dataA', '$luogoFatto', '$azioniValore', '$descrizioneFatto', '$autoreFatto', '$eventualiSoggetti', NOW(), NOW());";
    mysql_query($query, CONNECT);
    $idRecord = mysql_insert_id(CONNECT);
  
    $query = "UPDATE `fl_whistleblower` SET `eventualli_allegati`=$idRecord WHERE id='$idRecord'";
    mysql_query($query, CONNECT);
    
    // for ($x = 0; $x < sizeof($_FILES); $x++) {
      // echo "The number is: $x <br>";
      // $fileName = $_FILES['file']['name'];
  
      /* 
      *	Checking whether the file already exists in the destination folder 
      */
  
      // $query = "SELECT filename FROM fl_whistleblower_files WHERE filename='$fileName' AND form_id='$idRecord'";
      // mysql_query($query, CONNECT);
      // while($row = mysql_fetch_array($result)) {
      //   if($row['filename'] == $fileName) {
      //     $fileExistsFlag = 1;
      //   }
      // }
  
      /*
      * If file is not present in the destination folder
      */
  
      if($fileExistsFlag == 0) {
        if (sizeof($_FILES) > 1) {
          for ($i=0; $i < sizeof($_FILES); $i++) {
            $target = "upload/";
            $fileName = $_FILES['file'.$i]['name'];
            echo $fileName;
            $fileTarget = $target.$fileName;
            $tempFileName = $_FILES["file".$i]["tmp_name"];
            $result = move_uploaded_file($tempFileName,$fileTarget);
    
            /*
            *	If file was successfully uploaded in the destination folder
            */
    
            if($result) {
              echo "Your file".$fileName." has been successfully uploaded";
              $query = "INSERT INTO fl_whistleblower_files(filepath,filename,form_id, created_at, updated_at) VALUES ('$fileTarget','$fileName','$idRecord', NOW(), NOW())";
              mysql_query($query, CONNECT);
            }
            else { 
              echo "Sorry !!! There was an error in uploading your file"; 
            }
          }
        } else {
          $target = "upload/";
          $fileName = $_FILES['file0']['name'];
          $fileTarget = $target.$fileName;
          $tempFileName = $_FILES['file0']['tmp_name'];
          $result = move_uploaded_file($tempFileName,$fileTarget);
    
          /*
          *	If file was successfully uploaded in the destination folder
          */
    
          if($result) {
            echo "result".$result;
            echo "Your file ".$fileName." has been successfully uploaded";
            $query = "INSERT INTO fl_whistleblower_files(filepath,filename,form_id, created_at, updated_at) VALUES ('$fileTarget','$fileName','$idRecord', NOW(), NOW())";
            mysql_query($query, CONNECT);
          }
          else { 
            echo "Sorry !!! There was an error in uploading your file"; 
          }
        }
      }
  
      /*
      * If file is already present in the destination folder
      */
  
      else {
        echo "File <html><b><i>".$fileName."</i></b></html> already exists in your folder. Please rename the file and try again.";
        mysqli_close(CONNECT);
      } 
    // }
           
    // send email
    // $messaggio = "worked";
    // echo smail('iinoted@gmail.com','Test Whistleblower comune di bitetto',$messaggio);



    mysql_close(CONNECT);
    exit;
?>