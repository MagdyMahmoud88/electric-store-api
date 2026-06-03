<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;  // ✅ Barryvdh مش Barrier

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        $order->load(['items.product', 'address']);

        $this->prepareArabicText($order);

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('order'))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOption([
                'defaultFont'          => 'Cairo',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
            ]);

        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    public function stream(Order $order)
    {
        $order->load(['items.product', 'address']);

        $this->prepareArabicText($order);

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('order'))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOption([
                'defaultFont'          => 'Cairo',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
            ]);

        return $pdf->stream("invoice-{$order->order_number}.pdf");
    }

    // ✅ منفصلة عشان ما نكررش الكود
    private function prepareArabicText(Order $order): void
    {
        $address = optional($order->address);

        $order->formatted_customer_name = $order->arabicText($address->first_name . ' ' . $address->last_name);
        $order->formatted_city          = $order->arabicText($address->city);
        $order->formatted_governorate   = $order->arabicText($address->governorate);
        $order->formatted_street        = $order->arabicText($address->street_address);

        foreach ($order->items as $item) {
            $item->formatted_name = $order->arabicText($item->name);
        }
    }
}
