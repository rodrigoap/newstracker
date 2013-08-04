<?php
    header("Content-Type: text/html;charset=utf-8");
    $title = '“Que tenga matices no me convierte en opositor al Gobierno”';
    $title = preg_replace ("/[^a-zA-Z0-9áéíóúñÑÁÉÍÓÚüÜ ]/", "", $title);
    $tokens = preg_split("/[\s,]+/", $title);
    foreach ($tokens as $token) {
        if (strlen($token) > 3) {
            echo $token . "<br>";
        }
    }

?>
