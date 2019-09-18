<?php
$to = "iinoted@gmail.com";
$subject = "Email test";
$txt = "Hello world!";
$headers = "From: supporto@aryma.it";

mail($to, $subject, $txt, $headers);
