<?php
// 6ickZone Decryptor - Full Auto Scan by 0x6ick
set_time_limit(0);
error_reporting(0);

// --- Config ---
$key = isset($_POST['decryption_key']) ? $_POST['decryption_key'] : '';
$encrypted_extension = ".6ick";
$exclude_list = [basename(__FILE__), 'encrypt.php', '.htaccess', '.user.ini'];

$decryptedFilesCount = 0;
$operation_status = false;

// --- Decrypt Function ---
function decryptFile($filePath, $key, $ext) {
    global $decryptedFilesCount;
    $data = file_get_contents($filePath);
    if (!$data || substr($data, 0, 9) !== "6ickZone:") return false;

    $decoded = base64_decode(substr($data, 9));
    if (strlen($decoded) < 16) return false;

    $iv = substr($decoded, 0, 16);
    $encrypted = substr($decoded, 16);

    $decrypted = openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($decrypted === false) return false;

    $original = substr($filePath, 0, -strlen($ext));
    if (file_put_contents($original, $decrypted) === false) return false;

    unlink($filePath);
    $decryptedFilesCount++;
    return true;
}

// --- Recursive Scanner ---
function scanAndDecrypt($dir, $key, $exclude, $ext) {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || in_array($item, $exclude)) continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {
            scanAndDecrypt($path, $key, $exclude, $ext);
        } elseif (is_file($path) && substr($item, -strlen($ext)) === $ext) {
            decryptFile($path, $key, $ext);
        }
    }
}

// --- Main Logic ---
if (isset($_POST['unlock'])) {
    if (!empty($key)) {
        $operation_status = true;
        scanAndDecrypt(__DIR__, $key, $exclude_list, $encrypted_extension);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>6ickZone Decryptor</title>
  <style>
    body { background:#000; color:#0f0; font-family:monospace; text-align:center; padding-top:40px }
    input, button { padding:10px; font-size:16px; margin:10px; border-radius:5px; }
    input { width:300px; border:1px solid #0f0; background:#111; color:#0f0; }
    button { background:#0f0; color:#000; border:none; cursor:pointer; }
    .info { margin-top:20px; }
    .footer { margin-top:50px; color:#666; font-size:13px }
  </style>
</head>
<body>
  <h1>6ickZone Decryptor</h1>
  <p><strong>USE UR BRAIN:</strong><br />
  THIS TOOL IS FOR UNLOCKING FILES ENCRYPTED WITH <code>.6ick</code> EXTENSION ONLY.<br />
  DO NOT USE IN LIVE SYSTEMS WITHOUT BACKUPS.</p>

<?php if (!$operation_status): ?>
  <form method="post">
    <input type="text" name="decryption_key" placeholder="Enter decryption key..." required />
    <br />
    <button type="submit" name="unlock">UNLOCK FILES NOW</button>
  </form>
<?php else: ?>
  <div class="info">
    <p><strong>Decryption Complete!</strong></p>
    <p>Total files decrypted: <?= $decryptedFilesCount ?></p>
    <p>Make sure the key was correct if result is 0.</p>
  </div>
<?php endif; ?>

  <div class="footer">by 0x6ick - 6ickZone</div>
</body>
</html>
