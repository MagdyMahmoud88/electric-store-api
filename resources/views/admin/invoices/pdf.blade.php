<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>فاتورة رقم {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: ltr;
            text-align: right;
            color: #333;
            font-size: 12px;
            line-height: 1.8;
            margin: 0;
            padding: 20px;
        }
        .invoice-box { max-width: 800px; margin: auto; }

        .header-table  { width:100%; margin-bottom:25px; border-bottom:2px solid #c9a96e; padding-bottom:15px; }
        .logo          { font-size:20px; font-weight:bold; color:#c9a96e; }
        .invoice-title { font-size:18px; font-weight:bold; text-align:left; }

        .info-table    { width:100%; margin-bottom:25px; }
        .info-table td { vertical-align:top; width:50%; padding:4px; }
        .section-title { font-size:12px; font-weight:bold; border-bottom:1px solid #ddd; padding-bottom:5px; margin-bottom:8px; color:#555; }
        .info-line     { margin-bottom:5px; font-size:11px; }

        .details-table    { width:100%; border-collapse:collapse; margin-bottom:25px; }
        .details-table th { background:#f5f5f5; border:1px solid #ddd; padding:8px 6px; font-weight:bold; font-size:11px; text-align:right; }
        .details-table td { border:1px solid #ddd; padding:8px 6px; font-size:11px; }
        .details-table tr:nth-child(even) td { background:#fafafa; }

        /* ── Summary — على اليمين ── */
        .summary-wrap  { width:100%; margin-bottom:30px; }
        .summary-table { width:42%; float:right; border-collapse:collapse; font-size:11px; }
        .summary-table td { padding:6px 10px; border-bottom:1px solid #eee; }
        .summary-table .label { text-align:right; color:#555; }
        .summary-table .value { text-align:left;  font-weight:bold; }
        .total-row td  { font-weight:bold; font-size:13px; color:#c9a96e; background:#fdf8f0; border-top:2px solid #c9a96e; }
        .discount-row td { color:#16a34a; }

        .badge        { display:inline-block; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:bold; }
        .badge-paid   { background:#d1fae5; color:#065f46; }
        .badge-unpaid { background:#fee2e2; color:#991b1b; }

        .footer { margin-top:60px; text-align:center; font-size:10px; color:#888; border-top:1px solid #eee; padding-top:10px; }
        .clearfix::after { content:''; display:table; clear:both; }
    </style>
</head>
<body>
<div class="invoice-box">

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td class="logo">{{ $order->arabicText('متجر الكهرباء') }} ⚡</td>
            <td class="invoice-title">{{ $order->arabicText('فاتورة بيع') }}</td>
        </tr>
    </table>

    {{-- Info --}}
    <table class="info-table">
        <tr>
            <td>
                <div class="section-title">{{ $order->arabicText('تفاصيل العميل والشحن') }}</div>
                <div class="info-line"><strong>{{ $order->arabicText('الاسم') }}:</strong> {{ $order->formatted_customer_name }}</div>
                <div class="info-line"><strong>{{ $order->arabicText('الهاتف') }}:</strong> {{ optional($order->address)->phone }}</div>
                <div class="info-line"><strong>{{ $order->arabicText('العنوان') }}:</strong> {{ $order->formatted_street }}</div>
                <div class="info-line">
                    <strong>{{ $order->arabicText('المدينة / المحافظة') }}:</strong>
                    {{ $order->formatted_city }}، {{ $order->formatted_governorate }}
                </div>
            </td>
            <td style="padding-right:30px;">
                <div class="section-title">{{ $order->arabicText('بيانات الفاتورة') }}</div>
                <div class="info-line"><strong>{{ $order->arabicText('رقم الطلب') }}:</strong> #{{ $order->order_number }}</div>
                <div class="info-line"><strong>{{ $order->arabicText('تاريخ الطلب') }}:</strong> {{ $order->created_at->format('Y-m-d') }}</div>
                <div class="info-line">
                    <strong>{{ $order->arabicText('حالة الدفع') }}:</strong>
                    @if($order->payment_status === 'paid')
                        <span class="badge badge-paid">{{ $order->arabicText('تم الدفع') }}</span>
                    @else
                        <span class="badge badge-unpaid">{{ $order->arabicText('غير مدفوع') }}</span>
                    @endif
                </div>
                <div class="info-line">
                    <strong>{{ $order->arabicText('طريقة الدفع') }}:</strong>
                    {{ $order->arabicText(match($order->payment_method) {
                        'kashier'  => 'Kashier',
                        'card'     => 'بطاقة بنكية',
                        'cod'      => 'الدفع عند الاستلام',
                        'vodafone' => 'Vodafone Cash',
                        'instapay' => 'InstaPay',
                        default    => $order->payment_method,
                    }) }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Items --}}
    <table class="details-table">
        <thead>
        <tr>
            <th style="width:50%;">{{ $order->arabicText('المنتج') }}</th>
            <th style="width:15%;text-align:center;">{{ $order->arabicText('الكمية') }}</th>
            <th style="width:17%;text-align:left;">{{ $order->arabicText('سعر الوحدة') }}</th>
            <th style="width:18%;text-align:left;">{{ $order->arabicText('الإجمالي') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->formatted_name }}</td>
                <td style="text-align:center;">{{ $item->quantity }}</td>
                <td style="text-align:left;">{{ number_format($item->price, 0) }} {{ $order->arabicText('ج.م') }}</td>
                <td style="text-align:left;font-weight:bold;">{{ number_format($item->price * $item->quantity, 0) }} {{ $order->arabicText('ج.م') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Summary --}}
    <div class="summary-wrap clearfix">
        <table class="summary-table">

            {{-- المجموع الفرعي --}}
            <tr>
                <td class="label">{{ $order->arabicText('المجموع الفرعي') }}</td>
                <td class="value">{{ number_format($order->subtotal, 0) }} {{ $order->arabicText('ج.م') }}</td>
            </tr>

            {{-- الخصم --}}
            @if($order->discount > 0)
                <tr class="discount-row">
                    <td class="label">{{ $order->arabicText('الخصم') }}</td>
                    <td class="value">- {{ number_format($order->discount, 0) }} {{ $order->arabicText('ج.م') }}</td>
                </tr>
            @endif

            {{-- الشحن --}}
            <tr>
                <td class="label">{{ $order->arabicText('الشحن') }}</td>
                <td class="value">
                    @if($order->shipping == 0)
                        {{ $order->arabicText('مجاني') }}
                    @else
                        {{ number_format($order->shipping, 0) }} {{ $order->arabicText('ج.م') }}
                    @endif
                </td>
            </tr>

            {{-- ✅ القيمة المضافة (14%) --}}
            <tr>
                <td class="label">
                    {{ $order->arabicText('ضريبة القيمة المضافة') }}
                    (14%)
                </td>
                <td class="value">{{ number_format($order->tax, 0) }} {{ $order->arabicText('ج.م') }}</td>
            </tr>

            {{-- الإجمالي النهائي --}}
            <tr class="total-row">
                <td class="label">{{ $order->arabicText('الإجمالي النهائي') }}</td>
                <td class="value">{{ number_format($order->total, 0) }} {{ $order->arabicText('ج.م') }}</td>
            </tr>

        </table>
    </div>

    {{-- Footer --}}
    <div class="footer">
        {{ $order->arabicText('تم إنشاء هذه الفاتورة برمجياً وتعتبر مستنداً رسمياً لعملية الشحن والتسليم.') }}<br>
        {{ $order->arabicText('نشكركم على تسوقكم وثقتكم بنا!') }} ⚡
    </div>

</div>
</body>
</html>
