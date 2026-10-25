# 🚀 تشغيل المشروع من GitHub على Netlify — الدليل السريع

## قبل البدء
- حساب GitHub: `MR7PRO`.
- المستودع الجديد المقترح: `websec-lab` (لا تغيّر أي مستودع آخر).
- يجب أن يحتوي جذر المستودع على `netlify.toml`، ومجلد `site/`، وملفات `README.md` و`php-labs/` و`docs/`.

## خطوات الربط
1. افتح https://github.com/new وأنشئ مستودعًا باسم `websec-lab` (يمكن جعله **Public** ليطّلع الطلبة على المصدر أو **Private** إذا فضّلت؛ يلزم السماح لتكامل Netlify بالوصول).
2. ارفع محتويات الحزمة إلى فرع `main`. تأكد أن `netlify.toml` في الجذر.
3. افتح https://app.netlify.com/start وسجّل دخولك، ثم **Import an existing project → GitHub**، ووافق على ربط المستودع فقط.
4. اختر `MR7PRO/websec-lab`. الإعدادات:
   - Base directory: فارغ
   - Build command: فارغ (static site)
   - Publish directory: `site`
   - Production branch: `main`
5. اضغط **Deploy / Publish**. افتح رابط `*.netlify.app` الذي يظهر في لوحة تحكم حسابك (الرابط لا يُعرف مسبقًا).
6. جرّب مختبر SQL ثم AES ثم اختبار 10 أسئلة، ثم اضغط تغيير اللغة.

## ملاحظات مهمة
- مشروع Netlify عام عندما تعطي الرابط للمعيدة والطلاب، فلا تستخدم بيانات حقيقية.
- ملفا PHP اختياريان **ليسَا جزءًا من الموقع المنشور** ويعملان عبر PHP/XAMPP محليًا فقط.
- الـHTML منفصل: `Standalone.html` للعرض الاحتياطي؛ `site/` هي النسخة الصحيحة للنشر.
- التعديلات في `main` تنشر تلقائيًا بعد الربط.
- نسخة Netlify Drop الاحتياطية جاهزة في ZIP آخر مستقل.

## في حال فشل النشر
- 404: راجع إعداد `Publish directory = site`.
- المختبر يعمل لكن AES لا يعمل: تأكد من HTTPS أو localhost لا من `file://`.
- الموقع قديم بعد التحديث: أعد تحميل الصفحة حتى يُفعّل Service Worker الجديد.
- PHP 404: هذا متوقع؛ لا يعمل على Netlify.