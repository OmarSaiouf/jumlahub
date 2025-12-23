Jumlahub  متجر الجملة التشاركي

## ملخص المشروع (بالعربية)

Jumlahub هو منصة سوق تسمح للتجار بعرض منتجات جملة بكميات كبيرة، ويسمح للمشترين بطلب كميات محددة من كل منتج. عندما تتجمع الطلبات وتصل إلى الكمية الإجمالية المطلوبة، يُغلق المنتج ويُعتبر مكتملًا ويتم إرسال الكمية كاملة.

**مزايا الرئيسية:**
- عرض منتجات بالجملة بكميات كبيرة
- طلب كميات جزئية من كل منتج حتى اكتمال الكمية الإجمالية
- إدارة بوابات الدفع وتكاملها مع واجهة الإدارة

## التشغيل والتهيئة (خطوات سريعة)

1. تثبيت التبعيات:

```bash
composer install
```

2. إعداد البيئة: انسخ .env ثم حرّر معلومات قاعدة البيانات والأوراق الأخرى:

```bash
copy .env.example .env
php artisan key:generate
```

3. ترحيل قاعدة البيانات وملء البيانات الابتدائية:

```bash
php artisan migrate --seed
```

4. (اختياري) إضافة بيانات وهمية:

```bash
php artisan db:seed --class=FakeData
```

5. إنشاء مستخدم مدير (لوحة الإدارة على `/admin`):

```bash
php artisan backpack:user
```

6. بعد تشغيل التطبيق تأكد من ضبط `APP_URL` ثم:

```bash
php artisan storage:link
php artisan basset:install
```

## لماذا بُني هذا المشروع

هذا مشروع نهائي لدورة تدريب Laravel في مبادرة "ألف مبرمج" التابعة لمداد التعليمية. المشروع مفتوح المصدر تحت رخصة MIT.

## المطوّر

**‍ Omar Saiouf**

- LinkedIn: https://www.linkedin.com/in/omarsaiouf
- GitHub: https://github.com/OmarSaiouf
- Telegram: https://t.me/omarsaiouf

---

## Payment / الدفع  طريقة إضافة بوابات جديدة (محدث، تتطابق مع الكود)

في هذا المشروع، لإضافة بوابة دفع جديدة يجب إنشاء كلاس داخل `app/Modules/Payments/Gateways` يرث من `App\Modules\Payments\Abstractions\PaymentAbstraction` ويتبع العقود والـ DTOs المستخدمة (`App\Modules\Payments\DTO\PaymentData` و`App\Modules\Payments\DTO\PaymentResult`). إعدادات الاتصال (config) تُدار من لوحة الإدارة وتُخزن في جدول `payment_providers`، ثم تُمرّر تلقائيًا إلى كلاس البوابة عند التحميل.

1. هيكلية العمل الموصى بها:
   - مجلد البوابات: `app/Modules/Payments/Gateways/`
   - فئة أساسية/مجرّدة: `App\Modules\Payments\Abstractions\PaymentAbstraction`.
   - DTOs: `App\Modules\Payments\DTO\PaymentData`, `App\Modules\Payments\DTO\PaymentResult`.
   - جدول إعدادات: `payment_providers` يحتوي على الأعمدة `id, name, class, config (json), active`.

2. سلوك النظام:
   - يقوم النظام بقراءة السجلات النشطة (`active = 1`) من جدول `payment_providers` عند الحاجة أو عند تهيئة خدمة الدفع.
   - قيمة العمود `class` يجب أن تكون اسم الفئة الكامل (FQCN) مثل `App\\Modules\\Payments\\Gateways\\PaypalGateway`.
   - قيمة `config` هي JSON تُخزن من لوحة الإدارة وتحتوي مفاتيح التي يتوقعها الكلاس (مثال مفاتيح PayPal موجودة في الكود: `live_url`, `test_url`, `client_id`, `secret`, `cache_ttl`, `is_test`, `webhook_id`).
   - عند التحميل، يقوم التطبيق بعمل `app()->make($class, ['config' => $config])` لتهيئة الكلاس وتمرير الإعدادات.

3. مثال للكلاس متوافق مع الكود الفعلي (موجز):

```php
namespace App\Modules\Payments\Gateways;

use App\Modules\Payments\Abstractions\PaymentAbstraction;
use App\Modules\Payments\DTO\PaymentData;
use App\Modules\Payments\DTO\PaymentResult;
use Illuminate\Http\Request;

class PaypalGateway extends PaymentAbstraction
{
    public function __construct(public array $config)
    {
        parent::__construct($config);
        // تهيئة clientId, clientSecret, headers, ... كما في الكود
    }

    public function pay(PaymentData $data): PaymentResult
    {
        // تنفيذ عملية الدفع، يرجع PaymentResult
    }

    public function refund(string $paymentId, float $amount): PaymentResult
    {
        // تنفيذ عملية استرداد
    }

    public function getStatus(string $paymentId): PaymentResult
    {
        // جلب حالة الدفع
    }

    public function handleCallback(Request $request): PaymentResult
    {
        // معالجة webhooks/callbacks
    }

    public function handleReturn(Request $request): PaymentResult
    {
        // معالجة رجوع المستخدم بعد الدفع
    }
}
```

4. خطوات إضافة بوابة جديدة (مطابقة للكود):
   1. أنشئ فئة جديدة في `app/Modules/Payments/Gateways/` وارث `App\Modules\Payments\Abstractions\PaymentAbstraction`، وطبق الدوال المطلوبة (`pay`, `refund`, `getStatus`, `handleCallback`, `handleReturn`).
   2. من لوحة الإدارة أضف سجلًا جديدًا إلى `payment_providers`، املأ `class` باسم الفئة الكامل وضع JSON الإعدادات في `config`، واضبط `active = 1`.
   3. عند الحفظ سيُحمَّل المزود تلقائيًا لأن التطبيق يقرأ المزودات النشطة ديناميكيًا.
   4. اختبر البوابة في بيئة sandbox وتأكد من أن webhooks ممررة ومُعالجة بشكل صحيح.

5. مثال إدخال بيانات عبر SQL (يتضمن المفاتيح التي يتوقعها `PaypalGateway` في الكود):

```sql
INSERT INTO payment_providers (name, class, config, active) VALUES (
  'Paypal',
  'App\\Modules\\Payments\\Gateways\\PaypalGateway',
  '{"live_url":"https://api.paypal.com","test_url":"https://api.sandbox.paypal.com","client_id":"xxxx","secret":"yyyy","cache_ttl":300,"is_test":true,"webhook_id":"wh_abc123"}',
  1
);
```

6. ملاحظات أمنية وتشغيلية:
   - لا تحفظ مفاتيح حسّاسة في مستودع الكود؛ استخدم لوحة الإدارة أو خزنة أسرار.
   - تأكد أن `PaymentAbstraction` يوفر تسجيلًا مناسبًا والتحقق من الأخطاء.
   - اضبط عناوين الـ webhooks في إعدادات كل مزود داخل لوحة الإدارة.

---

## English  Project Summary (concise)

Jumlahub is a wholesale-collaborative marketplace where merchants list bulk products and buyers place partial orders. When cumulative orders reach the target quantity the product is closed and the shipment is prepared.

See the Arabic section above for setup commands and payment integration notes.

## Türkçe  Kısa Açıklama

Jumlahub, tedarikçilerin büyük miktarda ürün listelediği ve alıcıların her ürün için belirli miktarlar sipariş ettiği toptan pazar yeridir. Toplam sipariş miktarı hedefe ulaşınca ürün kapatılır ve gönderim yapılır.

---

## الرخصة

مشروع مفتوح المصدر بموجب رخصة MIT.

---

## ما التالي؟

- أستطيع إضافة مثال عملي كامل للفئة `ExampleGateway` داخل `app/Modules/Payments/Gateways` وSeeder لملء سجل في `payment_providers` وتجربة webhooks. هل تريدني أضيف هذا الآن?

