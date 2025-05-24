<?php
// 6ickZone Decryptor - For Lab Test Only
// This script will attempt to decrypt files encrypted by 6ickZone Ransomware v2.
// by 0x6ick (Upgraded by Gemini)

set_time_limit(0);
error_reporting(0);

// --- Configuration ---
$key = "6ickZoneRansomKeyForLabTestOnly!@#"; // MUST be the SAME key used for encryption!
$encrypted_extension = ".6ick"; // The extension added by the encryption script

// List of files/folders to EXCLUDE from scanning for decryption
// (e.g., this script itself, or the encrypt script)
$exclude_list_decrypt = [
    basename(__FILE__), // This script itself (decrypt.php)
    'encrypt.php',      // The encryption script
    '!!!DECRYPT_ME!!!.html', // The ransom note
    '.htaccess',
    '.user.ini',
    // Add other relevant files you want to exclude from decryption scan
];

// --- Global Variables ---
$decryptedFilesCount = 0;
$operation_status_decrypt = false;

// --- Decryption Function ---
function decryptFile($filePath, $encryptionKey, $encryptedExtension) {
    global $decryptedFilesCount;

    $data = file_get_contents($filePath);
    if ($data === false) return false;

    // Check if the file starts with our specific header
    $header_len = strlen("6ickZone:");
    if (substr($data, 0, $header_len) !== "6ickZone:") {
        return false; // Not an encrypted file by us, skip
    }

    // Extract encrypted data (after header)
    $encodedEncryptedData = substr($data, $header_len);
    $binaryData = base64_decode($encodedEncryptedData);

    // Extract IV (first 16 bytes) and actual encrypted content
    if (strlen($binaryData) < 16) {
        return false; // Not enough data for IV
    }
    $iv = substr($binaryData, 0, 16);
    $encryptedContent = substr($binaryData, 16);

    // Decrypt the data
    $decryptedData = openssl_decrypt($encryptedContent, 'AES-128-CBC', $encryptionKey, OPENSSL_RAW_DATA, $iv);
    if ($decryptedData === false) return false;

    // Determine the original file path by removing the added extension
    $originalFilePath = substr($filePath, 0, -strlen($encryptedExtension));

    // Save the decrypted data back to the original file name
    if (file_put_contents($originalFilePath, $decryptedData) === false) {
        return false;
    }

    // Delete the encrypted file
    if (!unlink($filePath)) {
        // For simulation, we just note it.
        return false;
    }

    $decryptedFilesCount++;
    return true;
}

// --- Recursive Scan and Decrypt Function ---
function scanAndDecryptRecursive($dir, $encryptionKey, $excludeListDecrypt, $encryptedExtension) {
    global $decryptedFilesCount;

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        // Check if item is in the exclude list
        if (in_array($item, $excludeListDecrypt)) {
            continue;
        }

        if (is_dir($path)) {
            scanAndDecryptRecursive($path, $encryptionKey, $excludeListDecrypt, $encryptedExtension);
        } elseif (is_file($path)) {
            // Check if file has the specific encrypted extension
            if (substr($item, -strlen($encryptedExtension)) === $encryptedExtension) {
                decryptFile($path, $encryptionKey, $encryptedExtension);
            }
        }
    }
}

// --- Main Execution Logic ---
if (isset($_POST['unlock'])) {
    $rootDir = __DIR__; // Target directory
    $operation_status_decrypt = true;
    scanAndDecryptRecursive($rootDir, $key, $exclude_list_decrypt, $encrypted_extension);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6ickZone Decryptor</title>
    <style>
        body { background:#0d0d0d; color:#eee; font-family: 'Courier New', monospace; text-align:center; padding-top: 50px; }
        h1 { color:#33f443; } /* Green for decryptor */
        button { background:#33f443; border:none; padding:15px 30px; color:#000; font-size:16px; cursor:pointer; border-radius:5px; }
        button:hover { background:#28c628; }
        .info { margin-top: 20px; font-size: 18px; }
        .footer { margin-top: 50px; font-size: 14px; color:#777; }
        code { background: #333; padding: 2px 6px; border-radius: 4px; }
        .warning { color: #ffeb3b; font-weight: bold; margin-bottom: 20px; }
        .key-input { margin-top: 20px; }
        .key-input input[type="text"] {
            background: #222;
            border: 1px solid #0f0;
            color: #fff;
            padding: 8px;
            width: 300px;
            max-width: 80%;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>6ickZone Decryptor</h1>
    <p class="warning">
        PERINGATAN: GUNAKAN HANYA PADA FILE YANG DIENKRIPSI OLEH RANSOMWARE 6ickZone v2.
        KUNCI DEKRIPSI HARUS SESUAI.
    </p>

    <?php if (!$operation_status_decrypt): ?>
        <p>Masukkan kunci enkripsi untuk mendekripsi file:</p>
        <form method="post">
            <div class="key-input">
                <input type="text" name="decryption_key" placeholder="Masukkan Kunci Disini..." value="<?= htmlspecialchars($key) ?>" required>
            </div>
            <button type="submit" name="unlock">UNLOCK FILES NOW</button>
        </form>
    <?php else: ?>
        <div class="info">
            <p>Done! Total file terdekripsi: <strong><?= $decryptedFilesCount ?></strong></p>
            <p>Jika jumlahnya 0, pastikan kunci sudah benar dan file ada.</p>
        </div>
    <?php endif; ?>

    <div class="footer">by 0x6ick - 6ickZone</div>
</body>
</html>
