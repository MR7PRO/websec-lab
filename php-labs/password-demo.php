<?php
declare(strict_types=1);
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
$error=''; $result=null;
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $input=(string)($_POST['password']??'');
    if ($input==='' || strlen($input)>72) {
        $error='استخدم كلمة مرور تجريبية من 1 إلى 72 بايت.';
    } else {
        $a=password_hash($input,PASSWORD_BCRYPT);
        $b=password_hash($input,PASSWORD_BCRYPT);
        $result=['a'=>$a,'b'=>$b,'ok'=>password_verify($input,$a),'no'=>password_verify($input.'WRONG',$a)];
    }
    unset($input);
}
function e(string $v):string{return htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
?>
<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>WebSec Lab PHP bcrypt</title><style>body{font:16px/1.9 system-ui,Tahoma;background:#081020;color:#eaf5ff;max-width:780px;margin:auto;padding:30px}form,article{background:#101d33;border:1px solid #253958;border-radius:15px;padding:22px;margin:20px 0}label{display:block}input{padding:12px;background:#081020;color:#fff;border:1px solid #59708d;border-radius:8px;width:90%}button{padding:13px;background:#4be3bf;color:#09232b;border:0;border-radius:9px;margin-top:16px;font-weight:bold}pre{white-space:pre-wrap;overflow-wrap:anywhere;direction:ltr;text-align:left;color:#94e7d2}p{color:#c4d4e7}</style></head><body><h1>🔐 تجربة bcrypt الحقيقية — PHP</h1><p>تعمل محليًا بخادم PHP وليس على Netlify. لا تستخدم كلمات مرور حقيقية.</p><form method="post"><label for="password">كلمة مرور تجريبية:</label><input id="password" name="password" type="password" required maxlength="72" autocomplete="new-password" placeholder="DemoOnly!2026"><button>أنشئ Hash مرتين وتحقق</button></form><?php if($error):?><p><?=e($error)?></p><?php endif; ?><?php if($result):?><article><p>نفس النص، قيمتان مختلفتان بسبب Salt عشوائي:</p><pre><?=e($result['a'])?></pre><pre><?=e($result['b'])?></pre><p>التحقق من الكلمة الأصلية: <strong><?=$result['ok']?'SUCCESS':'FAILED'?></strong></p><p>التحقق من كلمة خاطئة: <strong><?=$result['no']?'UNEXPECTED':'REJECTED'?></strong></p></article><?php endif; ?><article>في التسجيل نستخدم <code>password_hash()</code> ونخزّن الـHash فقط. وفي تسجيل الدخول نستخدم <code>password_verify()</code>. هذا ليس Encryption ولا يمكن فكّه. راعِ حد bcrypt البالغ 72 بايت.</article></body></html>
