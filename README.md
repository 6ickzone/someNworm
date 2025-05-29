<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

<h1>🪱 someNworm by 0x6ick</h1>

<p>
  <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License" />
  <img src="https://img.shields.io/badge/php-7.4%2B-orange.svg" alt="PHP" />
  <img src="https://img.shields.io/badge/status-stable-success.svg" alt="Status" />
  <img src="https://img.shields.io/badge/Made%20with-💀%206ickZone-black.svg" alt="Made with" />
</p>

<p><em>Hybrid Worm Project | PHP Auto-Replicator • Obfuscation • Resurrection • Encryption</em></p>

<blockquote>
  <p>"Where Creativity, Exploitation, and Expression Collide." — 6ickZone</p>
</blockquote>

<h2>📁 Directory Structure</h2>
<pre>
/someNworm/
├── some/
│   ├── v1/
│   │   ├── en.php
│   │   └── de.php
│   └── v2/
│       ├── encrypt2.php
│       └── decrypt2.php
│
├── worm/
│   ├── worm.php
│   ├── guard.php
│   └── worm2.php
│
└── standalone.php(encrypt&decrypt) 
              
</pre>

<h2>⚙️ Script Breakdown</h2>

<h3>🔐 v1 - Basic Encoder/Decoder</h3>
<ul>
  <li><code>en.php</code>: base64 + gzdeflate</li>
  <li><code>de.php</code>: gzinflate + base64_decode</li>
</ul>

<h3>🔒 v2 - AES Encryptor/Decryptor</h3>
<ul>
  <li><code>encrypt2.php</code>: AES-256-CBC, base64 output</li>
  <li><code>decrypt2.php</code>: requires same password/key</li>
</ul>

<h3>🔧 Features (v1)</h3>
<ul>
  <li>Encryption using <strong>AES-128-CBC</strong> with default key and IV (<code>\0 * 16</code>).</li>
  <li>Encrypted content starts with the tag: <code>"6ickZone:"</code>.</li>
  <li>Recursively scans and encrypts all files <strong>except</strong>:
    <ul>
      <li>The script itself (<code>encrypt.php</code>, <code>decrypt.php</code>)</li>
      <li>Important files like <code>.htaccess</code>, <code>.user.ini</code></li>
    </ul>
  </li>
  <li>Simple web interface with <strong>Lock & Unlock</strong> buttons.</li>
  <li>Files are <strong>not renamed</strong> — only their contents are encrypted.</li>
  <li>No dropped file notes (e.g., <code>README</code>, <code>DECRYPT_ME</code>).</li>
</ul>

<p><strong>⚠️ Weaknesses:</strong></p>
<ul>
  <li>Files are not renamed → still system-readable.</li>
  <li>Uses fixed IV → weak cryptographically.</li>
  <li>Easy to reverse-engineer due to open plaintext and structure.</li>
</ul>

<hr />

<h3>🔐 Version 2 (v2) – Obfuscated & Stealthier</h3>
<p><strong>File:</strong> <code>encrypt.php</code></p>

<h4>🔧 New Features:</h4>
<ul>
  <li>Random IV per file, stored with ciphertext.</li>
  <li>Encrypted files renamed to <code>.6ickZone</code>.</li>
  <li>Original files deleted via <code>unlink()</code>.</li>
  <li>Drops ransom note: <code>!!!DECRYPT_ME!!!.html</code>.</li>
  <li>Obfuscated structure:
    <ul>
      <li><code>$k</code> = key</li>
      <li><code>$e</code> = new extension</li>
      <li><code>$x</code> = exclusion list</li>
      <li><code>$t</code> = allowed extensions</li>
      <li><code>$z()</code> = encryption func</li>
    </ul>
  </li>
  <li>Extension whitelist-based encryption (<code>$t</code>).</li>
  <li>No HTML buttons shown — stealthier.</li>
</ul>

<h4>🔒 Security:</h4>
<ul>
  <li>Random IV + raw AES → stronger encryption.</li>
  <li>Original file deletion mimics ransomware.</li>
  <li>Ransom note mimics real-world scenarios.</li>
  <li>Obfuscation → harder analysis in wild.</li>
</ul>

<hr />

<h3>🪱 worm.php</h3>
<ul>
  <li>Recursive worm dropper to all writable dirs</li>
  <li>Drops <code>.syscore.php</code> backup + <code>.6zsig</code> marker</li>
  <li>Uploader via <code>?access=6ick</code></li>
</ul>

<h3>🛡 guard.php</h3>
<ul>
  <li>Worm protector</li>
  <li>Restores worm.php if deleted</li>
</ul>

<h3>🧬 worm2.php (v2.3s)</h3>
<ul>
  <li>Stealth variant</li>
  <li>Logs to <code>.spreadlog.txt</code></li>
  <li>Uploader: <code>?up=letmein</code></li>
</ul>

<h3>🧩 standalone.php</h3>
<ul>
  <li>Click <strong>"LOCK FILES"</strong> to encrypt all except protected files.
    <ul>
      <li>After encryption, <strong>KEY</strong> will be shown — save securely.</li>
    </ul>
  </li>
  <li>To decrypt:
    <ul>
      <li>Input the saved KEY into <em>"Enter decryption key"</em>.</li>
      <li>Click <strong>"DECRYPT FILES"</strong>.</li>
    </ul>
  </li>
</ul>

<h3>📌 Notes</h3>
<ul>
  <li>Do <strong>NOT</strong> lose the KEY — required for decryption.</li>
  <li>Encrypted files get new extension via <code>_6kzone()</code>.</li>
  <li>Uses AES-128-CBC with fresh key each time.</li>
</ul>

<h2>💡 Usage</h2>
<ul>
  <li><strong>Activate worm:</strong> <code>php worm/worm.php</code></li>
  <li><strong>Uploader:</strong> <code>worm.php?access=6ick</code></li>
  <li><strong>Test guard:</strong> Delete worm.php, then run <code>guard.php</code></li>
  <li><strong>Encrypt/Decrypt:</strong> <code>php some/v2/encrypt2.php</code>, <code>php some/v2/decrypt2.php</code></li>
</ul>

<h2>📜 Legal Notice</h2>
<p>
  <strong>For Educational Purposes Only</strong><br />
  Do not deploy on unauthorized systems.
</p>

<div>
  <p>Author: <a href="https://github.com/6ickzone">0x6ick</a></p>
  <p>Email: 6ickwhispers@gmail.com</p>
  <p>License: MIT (ethical use only)</p>
  <p><em>"Some worms spread chaos. Others spread knowledge — depends on who's holding the script."</em></p>
</div>

</body>
</html>
