<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');
        /* نضع الخط كاحتياطي للمتصفحات الحديثة */
        body, table, td, p, a, span {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }
    </style>
</head>
<body style="background-color: #0f172a; margin: 0; padding: 0; text-align: right; color: #f1f5f9; direction: rtl;">
<div class="email-container" style="max-width: 600px; margin: 40px auto; background-color: #1e293b; border-radius: 16px; overflow: hidden; border: 1px solid #334155; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);">

    <div class="header" style="background: linear-gradient(135deg, #e2b86f 0%, #c9a96e 100%); padding: 40px 25px; text-align: center; color: #0f172a;">
        <h1 style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">شكراً لشرائك من متجرنا!</h1>
        <p style="margin: 8px 0 0 0; font-size: 14px; font-weight: 600; opacity: 0.9;">لقد تم تأكيد دفعتك بنجاح ونقوم الآن بتجهيز شحنتك</p>
    </div>

    <div class="content" style="padding: 35px;">
        <p style="font-size: 16px; margin-top: 0;">أهلاً بك يا <strong style="color: #e2b86f; font-weight: 700;">{{ optional($order->address)->first_name ?? 'عميلنا العزيز' }}</strong>،</p>
        <p style="font-size: 14px; color: #94a3b8; line-height: 1.8;">يسعدنا إبلاغك بأن عملية الدفع تمت بأمان وجاري العمل على تحضير طلبك وتسليمه لشركة الشحن في أسرع وقت.</p>

        <div class="order-badge" style="display: inline-block; background-color: #0f172a; border: 1px solid #334155; padding: 10px 20px; border-radius: 30px; margin: 15px 0 30px 0;">
            <span style="font-size: 13px; color: #64748b; margin-left: 6px;">رقم الطلب:</span>
            <span style="font-size: 15px; font-weight: 800; color: #e2b86f;">#{{ $order->order_number }}</span>
        </div>

        <h3 style="font-size: 16px; color: #f8fafc; margin-bottom: 15px; border-bottom: 2px solid #334155; padding-bottom: 10px; font-weight: 700;">
            📦 محتويات الشحنة
        </h3>

        <table class="items-table" style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
            <tr>
                <th style="text-align: right; width: 55%; background-color: #0f172a; padding: 12px 16px; font-size: 12px; font-weight: 700; color: #64748b; border-bottom: 2px solid #334155; border-radius: 0 8px 8px 0;">المنتج</th>
                <th style="text-align: center; width: 15%; background-color: #0f172a; padding: 12px 16px; font-size: 12px; font-weight: 700; color: #64748b; border-bottom: 2px solid #334155;">الكمية</th>
                <th style="text-align: left; width: 30%; background-color: #0f172a; padding: 12px 16px; font-size: 12px; font-weight: 700; color: #64748b; border-bottom: 2px solid #334155; border-radius: 8px 0 0 8px;">السعر</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr class="item-row">
                    <td style="text-align: right; padding: 16px; border-bottom: 1px solid #334155; font-size: 13px; font-weight: 600;">{{ $item->name }}</td>
                    <td style="text-align: center; padding: 16px; border-bottom: 1px solid #334155; font-size: 13px; color: #94a3b8;">{{ $item->quantity }}</td>
                    <td style="text-align: left; padding: 16px; border-bottom: 1px solid #334155; font-size: 13px; font-weight: 700; color: #e2b86f;">{{ number_format($item->price * $item->quantity, 0) }} ج.م</td>
                </tr>
            @endforeach

            <tr class="summary-row">
                <td colspan="2" style="text-align: left; padding: 12px 16px 6px 16px; font-size: 13px; color: #94a3b8;">المجموع الفرعي</td>
                <td style="text-align: left; padding: 12px 16px 6px 16px; font-size: 13px; color: #f1f5f9; font-weight: 600;">{{ number_format($order->subtotal, 0) }} ج.م</td>
            </tr>

            <tr class="summary-row">
                <td colspan="2" style="text-align: left; padding: 6px 16px; font-size: 13px; color: #94a3b8;">تكلفة الشحن</td>
                <td style="text-align: left; padding: 6px 16px; font-size: 13px; font-weight: 700;" class="{{ $order->shipping == 0 ? 'green-text' : '' }}">
                    @if($order->shipping == 0)
                        <span style="color: #10b981; background-color: rgba(16, 185, 129, 0.1); padding: 2px 8px; border-radius: 4px; font-size: 11px;">مجاني</span>
                    @else
                        <span style="color: #f1f5f9;">{{ number_format($order->shipping, 0) }} ج.م</span>
                    @endif
                </td>
            </tr>

            <tr class="summary-row">
                <td colspan="2" style="text-align: left; padding: 6px 16px 16px 16px; font-size: 13px; color: #94a3b8;">ضريبة القيمة المضافة {{ number_format(($order->subtotal > 0 ? ($order->tax / $order->subtotal) * 100 : 0), 0) }}%</td>
                <td style="text-align: left; padding: 6px 16px 16px 16px; font-size: 13px; color: #f1f5f9; font-weight: 600;">{{ number_format($order->tax, 0) }} ج.م</td>
            </tr>

            <tr class="total-row">
                <td colspan="2" style="text-align: left; background-color: #0f172a; padding: 18px 16px; border-radius: 0 10px 10px 0; font-size: 14px; font-weight: 700; color: #f8fafc; border-top: 1px solid #334155; border-bottom: 1px solid #334155;">الإجمالي النهائي</td>
                <td style="text-align: left; background-color: #0f172a; padding: 18px 16px; border-radius: 10px 0 0 10px; font-size: 18px; font-weight: 800; color: #e2b86f; border-top: 1px solid #334155; border-bottom: 1px solid #334155;">{{ number_format($order->total, 0) }} ج.م</td>
            </tr>
            </tbody>
        </table>

        <h3 style="font-size: 16px; color: #f8fafc; margin-bottom: 15px; border-bottom: 2px solid #334155; padding-bottom: 10px; font-weight: 700;">📍 تفاصيل الشحن والتوصيل</h3>
        <div class="address-card" style="background-color: #0f172a; border: 1px solid #334155; padding: 20px; border-radius: 12px;">
            <div style="font-weight: 700; color: #e2b86f; font-size: 14px; margin-bottom: 6px;">{{ optional($order->address)->first_name }} {{ optional($order->address)->last_name }}</div>
            <div style="font-size: 13px; color: #94a3b8; line-height: 1.6;">
                <span style="color: #64748b;">العنوان:</span> {{ $order->address->street_address }}@if($order->address->building_number)، مبنى {{ $order->address->building_number }}@endif
                ، {{ $order->address->city }}، {{ $order->address->governorate }} <br>
                <span style="color: #64748b; display: inline-block; margin-top: 5px;">رقم الهاتف:</span> {{ $order->address->phone }}
            </div>
        </div>
    </div>

    <div class="footer" style="background-color: #0b0f19; padding: 25px; text-align: center; font-size: 12px; color: #475569; border-top: 1px solid #1e293b; line-height: 1.6;">
        هذا البريد تم إرساله آلياً لتأكيد طلبكم المالي وشحنتكم.<br>
        جميع الحقوق محفوظة &copy; {{ date('Y') }} متجر الأدوات الكهربائية الذكي.
    </div>
</div>
</body>
</html>
