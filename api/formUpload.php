<?php

$fileExistsFlag = 0; 
  $link = mysqli_connect("localhost","root","","aryma_bitetto") or die("Error ".mysqli_error($link));

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

  $query = "INSERT INTO `fl_whistleblower` (`nome`, `cognome`, `qualifica_professionale`, `serde_servizio`, `telefono`, `email`, `data_da`, `data_a`, `luogo_fatto`, `azioni_valore`, `descrizione_fatto`, `autore_fatto`, `eventuali_soggetti`) VALUES ('$nome', '$cognome', '$qualificaProfessionale', '$sedeServizio', '$telefono', '$email', '$dataDa', '$dataA', '$luogoFatto', '$azioniValore', '$descrizioneFatto', '$autoreFatto', '$eventualiSoggetti');";
  mysqli_query($link, $query);
  $idRecord = mysqli_insert_id($link);

  $query = "UPDATE `fl_whistleblower` SET `eventualli_allegati`=$idRecord WHERE id='$idRecord'";
  mysqli_query($link, $query);
  
  // for ($x = 0; $x < sizeof($_FILES); $x++) {
    // echo "The number is: $x <br>";
  
    /* 
    *	Checking whether the file already exists in the destination folder 
    */

    // $query = "SELECT filename FROM fl_files WHERE filename='$fileName' AND form_id='$idRecord'";
    // $result = $link->query($query) or die("Error : ".mysqli_error($link));
    // while($row = mysqli_fetch_array($result)) {
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
            echo "This";
            echo "Your file".$fileName." has been successfully uploaded";
            $query = "INSERT INTO fl_files(filepath,filename,form_id, created_at, updated_at) VALUES ('$fileTarget','$fileName','$idRecord', NOW(), NOW())";
            $link->query($query) or die("Error : ".mysqli_error($link)); 
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
          $query = "INSERT INTO fl_files(filepath,filename,form_id, created_at, updated_at) VALUES ('$fileTarget','$fileName','$idRecord', NOW(), NOW())";
          $link->query($query) or die("Error : ".mysqli_error($link)); 
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
      mysqli_close($link);
    } 
  // }
  mysqli_close($link);
?>