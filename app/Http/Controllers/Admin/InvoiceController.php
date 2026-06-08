<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        $order->load(['items.product', 'address']);
        $this->prepareArabicText($order);

        $pdf = $this->buildPdf($order);
        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    public function stream(Order $order)
    {
        $order->load(['items.product', 'address']);
        $this->prepareArabicText($order);

        $pdf = $this->buildPdf($order);
        return $pdf->stream("invoice-{$order->order_number}.pdf");
    }

    private function buildPdf(Order $order)
    {
        return Pdf::loadView('admin.invoices.pdf', compact('order'))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOption([
                'defaultFont'          => 'DejaVu Sans',   // ← DejaVu أكثر ثباتاً مع ArPHP
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'dpi'                  => 150,
            ]);
    }

    private function prepareArabicText(Order $order): void
    {
        $address = optional($order->address);

        // ── بيانات العميل ──
        $order->formatted_customer_name = $order->arabicText(
            trim($address->first_name . ' ' . $address->last_name)
        );
        $order->formatted_city        = $order->arabicText($address->city);
        $order->formatted_governorate = $order->arabicText($address->governorate);
        $order->formatted_street      = $order->arabicText($address->street_address);

        // ── أسماء المنتجات ──
        foreach ($order->items as $item) {
            $item->formatted_name = $order->arabicText($item->name);
        }

        // ── حالة الدفع ──
        $order->formatted_payment_status = $order->arabicText(
            $order->payment_status === 'paid' ? 'تم الدفع' : 'غير مدفوع'
        );

        // ── طريقة الدفع ──
        $order->formatted_payment_method = $order->arabicText(match($order->payment_method) {
            'kashier'  => 'Kashier',
            'card'     => 'بطاقة بنكية',
            'cod'      => 'الدفع عند الاستلام',
            'vodafone' => 'Vodafone Cash',
            'instapay' => 'InstaPay',
            default    => $order->payment_method ?? '',
        });

        // ── حالة الطلب ──
        $order->formatted_status = $order->arabicText(match($order->status) {
            'pending'    => 'قيد الانتظار',
            'processing' => 'جاري التجهيز',
            'shipped'    => 'تم الشحن',
            'delivered'  => 'تم التسليم',
            'cancelled'  => 'ملغي',
            default      => $order->status ?? '',
        });

        // ── CSS class للـ badge ──
        $order->status_badge_class = match($order->status) {
            'pending'    => 'b-pending',
            'processing' => 'b-default',
            'shipped'    => 'b-delivered',
            'delivered'  => 'b-paid',
            'cancelled'  => 'b-unpaid',
            default      => 'b-default',
        };

        $order->payment_badge_class = $order->payment_status === 'paid' ? 'b-paid' : 'b-unpaid';

        // ── نصوص الـ UI الثابتة (كلها تعدي على arabicText) ──
        $order->t = (object) [
            // Header
            'store_name'        => $order->arabicText('متجر الكهرباء'),
            'invoice_label'     => $order->arabicText('فاتورة ضريبية'),

            // Status strip
            'payment_status_lbl'  => $order->arabicText('حالة الدفع'),
            'payment_method_lbl'  => $order->arabicText('طريقة الدفع'),
            'order_date_lbl'      => $order->arabicText('تاريخ الطلب'),
            'order_status_lbl'    => $order->arabicText('حالة الطلب'),

            // Info grid
            'customer_section'    => $order->arabicText('بيانات العميل والشحن'),
            'invoice_section'     => $order->arabicText('بيانات الفاتورة'),
            'name_lbl'            => $order->arabicText('الاسم'),
            'phone_lbl'           => $order->arabicText('الهاتف'),
            'address_lbl'         => $order->arabicText('العنوان'),
            'city_lbl'            => $order->arabicText('المدينة / المحافظة'),
            'order_num_lbl'       => $order->arabicText('رقم الطلب'),
            'issue_date_lbl'      => $order->arabicText('تاريخ الإصدار'),
            'store_lbl'           => $order->arabicText('المتجر'),
            'email_lbl'           => $order->arabicText('البريد الإلكتروني'),

            // Items table
            'products_section'    => $order->arabicText('تفاصيل المنتجات'),
            'product_col'         => $order->arabicText('المنتج'),
            'qty_col'             => $order->arabicText('الكمية'),
            'unit_price_col'      => $order->arabicText('سعر الوحدة'),
            'total_col'           => $order->arabicText('الإجمالي'),
            'currency'            => $order->arabicText('ج.م'),

            // Totals
            'subtotal_lbl'        => $order->arabicText('المجموع الفرعي'),
            'discount_lbl'        => $order->arabicText('الخصم'),
            'shipping_lbl'        => $order->arabicText('الشحن'),
            'free_shipping'       => $order->arabicText('مجاني'),
            'tax_lbl'             => $order->arabicText('ضريبة القيمة المضافة'),
            'grand_total_lbl'     => $order->arabicText('الإجمالي النهائي'),

            // Footer
            'footer_note1'        => $order->arabicText('تم إنشاء هذه الفاتورة برمجياً وتُعدّ مستنداً رسمياً.'),
            'footer_note2'        => $order->arabicText('نشكركم على تسوقكم وثقتكم بنا!'),
            'footer_no_stamp'     => $order->arabicText('هذه الفاتورة لا تحتاج توقيعاً أو ختماً'),
        ];
    }
}
