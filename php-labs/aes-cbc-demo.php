<?php
declare(strict_types=1);
header('Cache-Control: no-store');
$error='';$result='';$mode=(string)($_POST['mode']??'encrypt');
if($_SERVER['REQUEST_METHOD']==='POST'){
 $pass=(string)($_POST['pass']??'');$payload=(string)($_POST['payload']??'');
 if(strlen($pass)<8 || strlen($pass)>128 || $payload==='' || strlen($payload)>10000){$error='أدخل رسالة تجريبية وعبارة مرور من 8 إلى 128 بايت.';}
 else try{
  if($mode==='encrypt'){
   $salt=random_bytes(16);$iv=random_bytes(16);
   $derived=hash_pbkdf2('sha256',$pass,$salt,150000,64,true);
   $encKey=substr($derived,0,32);$macKey=substr($derived,32,32);
   $cipher=openssl_encrypt($payload,'aes-256-cbc',$encKey,OPENSSL_RAW_DATA,$iv);
   if($cipher===false)throw new RuntimeException('encrypt');
   $mac=hash_hmac('sha256','WSC1'.$salt.$iv.$cipher,$macKey,true);
   $result=base64_encode('WSC1'.$salt.$iv.$mac.$cipher);
  }elseif($mode==='decrypt'){
   $blob=base64_decode($payload,true);
   if($blob===false || strlen($blob)<84 || substr($blob,0,4)!=='WSC1')throw new RuntimeException('payload');
   $salt=substr($blob,4,16);$iv=substr($blob,20,16);
   $mac=substr($blob,36,32);$cipher=substr($blob,68);
   $derived=hash_pbkdf2('sha256',$pass,$salt,150000,64,true);
   $encKey=substr($derived,0,32);$macKey=substr($derived,32,32);
   $expected=hash_hmac('sha256','WSC1'.$salt.$iv.$cipher,$macKey,true);
   if(!hash_equals($expected,$mac))throw new RuntimeException('tampered');
   $result=(string)openssl_decrypt($cipher,'aes-256-cbc',$encKey,OPENSSL_RAW_DATA,$iv);
  }else throw new RuntimeException('mode');
 }catch(Throwable $e){$error='فشل فك التشفير أو التحقق. راجع المفتاح والبيانات.';}
 unset($pass,$derived,$encKey,$macKey);
}
function e(string $v):string{return htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
?>
<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>WebSec Lab PHP AES-256-CBC</title><style>body{font:16px/1.9 system-ui,Tahoma;background:#081020;color:#eaf5ff;max-width:780px;margin:auto;padding:30px}form,article{background:#101d33;border:1px solid #253958;border-radius:15px;padding:22px;margin:20px 0}label{display:block}input,select,textarea{padding:12px;background:#081020;color:#fff;border:1px solid #59708d;border-radius:8px;width:95%}textarea{min-height:120px}button{padding:13px;background:#4be3bf;color:#09232b;border:0;border-radius:9px;margin-top:16px;font-weight:bold}pre{white-space:pre-wrap;overflow-wrap:anywhere;direction:ltr;text-align:left;color:#94e7d2}</style></head><body><h1>🔐 AES-256-CBC باستخدام PHP</h1><p>مطابق لموضوع المحاضرة مع HMAC-SHA256 إضافي لحماية سلامة الرسالة، وSalt وIV عشوائيين. للتشغيل المحلي فقط.</p><form method="post"><label for="mode">العملية:</label><select id="mode" name="mode"><option value="encrypt" <?=$mode==='encrypt'?'selected':''?>>تشفير</option><option value="decrypt" <?=$mode==='decrypt'?'selected':''?>>فك التشفير</option></select><label for="payload">النص أو الناتج المشفّر Base64:</label><textarea id="payload" name="payload" required><?=e((string)($_POST['payload']??'Hello Web Security!'))?></textarea><label for="pass">عبارة مرور وهمية:</label><input id="pass" name="pass" type="password" minlength="8" maxlength="128" required autocomplete="new-password" placeholder="DemoOnly2026!"><button>تنفيذ</button></form><?php if($error):?><p role="alert"><?=e($error)?></p><?php endif;?><?php if($result!==''):?><article><strong>النتيجة:</strong><pre><?=e($result)?></pre><p>لاختبار فك التشفير: انسخ الناتج، واختر «فك التشفير»، واستعمل نفس عبارة المرور.</p></article><?php endif;?><article><b>ماذا تعلمنا؟</b> AES تشفير متماثل قابل للفك بالمفتاح. CBC وحده لا يضمن سلامة الرسالة، ولذلك أضفنا HMAC ونفحصه قبل فك التشفير. في المتصفح نستخدم AES-GCM الذي يوفر خاصية التحقق ضمن نمط التشفير.</article></body></html>
