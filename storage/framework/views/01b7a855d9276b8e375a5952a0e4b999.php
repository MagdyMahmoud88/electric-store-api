<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #<?php echo e($order->order_number); ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: ltr;
            background: #ffffff;
            color: #1c1c1c;
            font-size: 12px;
            line-height: 1.7;
        }

        /* ══ HEADER ══ */
        .header-top {
            background: #0a0f1e;
            padding: 26px 36px 20px;
        }
        .header-accent {
            height: 4px;
            background: linear-gradient(90deg, #c9a96e, #f0d090, #c9a96e);
        }
        .h-wrap  { width:100%; }
        .h-brand { font-size:22px; font-weight:900; color:#fff; }
        .h-gold  { color:#c9a96e; }
        .h-sub   { font-size:9px; color:rgba(255,255,255,0.35); margin-top:3px; letter-spacing:1.5px; }
        .h-badge {
            display:inline-block;
            border:1px solid rgba(201,169,110,0.5);
            color:#c9a96e; font-size:9px; font-weight:700;
            letter-spacing:2.5px; padding:2px 10px; border-radius:2px; margin-bottom:4px;
        }
        .h-num  { font-size:24px; font-weight:900; color:#fff; }
        .h-date { font-size:10px; color:rgba(255,255,255,0.4); margin-top:2px; }

        /* ══ STATUS STRIP ══ */
        .status-strip { background:#f7f3ec; border-bottom:1px solid #e8dcc8; padding:10px 36px; }
        .ss-wrap { width:100%; }
        .ss-cell { padding:0 16px 0 0; }
        .ss-sep  { border-left:1px solid #ddd; padding-left:16px; }
        .ss-lbl  { font-size:9px; color:#999; letter-spacing:1px; margin-bottom:2px; }
        .ss-val  { font-size:12px; font-weight:700; color:#1c1c1c; }

        .badge { display:inline-block; padding:2px 9px; border-radius:3px; font-size:10px; font-weight:700; }
        .b-paid      { background:#d1fae5; color:#065f46; }
        .b-unpaid    { background:#fee2e2; color:#991b1b; }
        .b-delivered { background:#dbeafe; color:#1d4ed8; }
        .b-pending   { background:#fef3c7; color:#92400e; }
        .b-default   { background:#f1f5f9; color:#475569; }

        /* ══ BODY ══ */
        .body { padding:26px 36px; }

        /* ── Info Grid ── */
        .info-wrap { border:1px solid #e5d9c3; border-radius:6px; overflow:hidden; margin-bottom:22px; width:100%; }
        .info-tbl { width:100%; border-collapse:collapse; }
        .info-td-r {
            width:50%; padding:16px 20px; vertical-align:top;
            background:#ffffff; border-left:1px solid #e5d9c3; text-align:right;
        }
        .info-td-l {
            width:50%; padding:16px 20px; vertical-align:top;
            background:#fdf9f3; text-align:right;
        }
        .info-heading {
            font-size:9px; font-weight:800; color:#c9a96e;
            letter-spacing:2px; border-bottom:1px solid #e8dcc8;
            padding-bottom:6px; margin-bottom:12px;
        }
        .info-row  { margin-bottom:7px; }
        .info-key  { font-size:10px; color:#999; margin-bottom:1px; text-align:right; }
        .info-val  { font-size:12px; font-weight:600; color:#1c1c1c; text-align:right; }
        .info-ltr  { font-size:12px; font-weight:600; color:#1c1c1c; text-align:left; direction:ltr; }

        /* ── Section label ── */
        .sec-lbl {
            font-size:9px; font-weight:800; color:#c9a96e;
            letter-spacing:2px; text-align:right;
            margin-bottom:10px; border-bottom:1px solid #e5d9c3; padding-bottom:5px;
        }

        /* ── Items Table ── */
        .items-tbl { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .items-tbl thead tr { background:#0a0f1e; }
        .items-tbl thead th { color:#fff; padding:10px 14px; font-size:10px; font-weight:700; letter-spacing:.8px; }
        .items-tbl thead th.r { text-align:right; }
        .items-tbl thead th.c { text-align:center; }
        .items-tbl thead th.l { text-align:left; }
        .items-tbl tbody tr { border-bottom:1px solid #f0ebe2; }
        .items-tbl tbody tr:nth-child(even) td { background:#fdf9f4; }
        .items-tbl tbody tr:last-child { border-bottom:none; }
        .items-tbl tbody td { padding:10px 14px; font-size:11.5px; color:#333; vertical-align:middle; }
        .items-tbl tbody td.r { text-align:right; }
        .items-tbl tbody td.c { text-align:center; }
        .items-tbl tbody td.l { text-align:left; }

        .idx-circle {
            display:inline-block; width:22px; height:22px;
            background:#c9a96e; color:#fff; border-radius:50%;
            font-size:10px; font-weight:800; text-align:center; line-height:22px;
        }
        .price-v { font-weight:700; color:#6b5320; }
        .total-v { font-weight:800; color:#0a0f1e; font-size:12.5px; }

        /* ── Totals ── */
        .totals-inner { border:1px solid #e5d9c3; border-radius:6px; overflow:hidden; }
        .t-row { display:table; width:100%; padding:9px 16px; border-bottom:1px solid #f0ebe2; }
        .t-row:last-child { border-bottom:none; }
        .t-grand { background:#0a0f1e; padding:13px 16px; }
        .t-lbl { display:table-cell; font-size:11px; color:#777; vertical-align:middle; text-align:right; }
        .t-val { display:table-cell; font-size:12px; font-weight:700; color:#1c1c1c; vertical-align:middle; text-align:left; }
        .t-grand .t-lbl { color:rgba(255,255,255,0.65); font-size:12px; font-weight:600; }
        .t-grand .t-val { color:#c9a96e; font-size:18px; font-weight:900; }
        .v-green { color:#16a34a !important; }

        /* ══ FOOTER ══ */
        .footer-bar { background:#0a0f1e; padding:14px 36px; }
        .ft-tbl   { width:100%; }
        .ft-brand { font-size:13px; font-weight:900; color:#fff; }
        .ft-gold  { color:#c9a96e; }
        .ft-sub   { font-size:9px; color:rgba(255,255,255,0.3); margin-top:2px; }
        .ft-note  { font-size:9.5px; color:rgba(255,255,255,0.35); text-align:right; line-height:1.8; }
        .ft-hr    { border:none; border-top:1px solid rgba(255,255,255,0.07); margin:10px 0 8px; }
        .ft-btm   { font-size:9px; color:rgba(255,255,255,0.2); text-align:center; }
    </style>
</head>
<body>


<div class="header-top">
    <table class="h-wrap" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="h-brand">
                    <?php echo e($order->t->store_name); ?> <span class="h-gold">⚡</span>
                </div>
                <div class="h-sub">ELECTRIC STORE — EGYPT</div>
            </td>
            <td style="text-align:right;">
                <div class="h-badge">TAX INVOICE</div><br>
                <div class="h-num"># <?php echo e($order->order_number); ?></div>
                <div class="h-date"><?php echo e($order->created_at->format('d / m / Y')); ?></div>
            </td>
        </tr>
    </table>
</div>
<div class="header-accent"></div>


<div class="status-strip">
    <table class="ss-wrap" cellpadding="0" cellspacing="0">
        <tr>
            <td class="ss-cell" style="width:22%;">
                <div class="ss-lbl"><?php echo e($order->t->payment_status_lbl); ?></div>
                <div class="ss-val">
                    <span class="badge <?php echo e($order->payment_badge_class); ?>">
                        <?php echo e($order->formatted_payment_status); ?>

                    </span>
                </div>
            </td>
            <td class="ss-cell ss-sep" style="width:28%;">
                <div class="ss-lbl"><?php echo e($order->t->payment_method_lbl); ?></div>
                <div class="ss-val"><?php echo e($order->formatted_payment_method); ?></div>
            </td>
            <td class="ss-cell ss-sep" style="width:25%;">
                <div class="ss-lbl"><?php echo e($order->t->order_date_lbl); ?></div>
                <div class="ss-val"><?php echo e($order->created_at->format('d M Y')); ?></div>
            </td>
            <td class="ss-cell ss-sep" style="width:25%;">
                <div class="ss-lbl"><?php echo e($order->t->order_status_lbl); ?></div>
                <div class="ss-val">
                    <span class="badge <?php echo e($order->status_badge_class); ?>">
                        <?php echo e($order->formatted_status); ?>

                    </span>
                </div>
            </td>
        </tr>
    </table>
</div>


<div class="body">

    
    <div class="info-wrap">
        <table class="info-tbl" cellpadding="0" cellspacing="0">
            <tr>
                
                <td class="info-td-r">
                    <div class="info-heading"><?php echo e($order->t->customer_section); ?></div>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->name_lbl); ?></div>
                        <div class="info-val"><?php echo e($order->formatted_customer_name); ?></div>
                    </div>

                    <?php if(optional($order->address)->phone): ?>
                        <div class="info-row">
                            <div class="info-key"><?php echo e($order->t->phone_lbl); ?></div>
                            <div class="info-ltr"><?php echo e(optional($order->address)->phone); ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->address_lbl); ?></div>
                        <div class="info-val"><?php echo e($order->formatted_street); ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->city_lbl); ?></div>
                        <div class="info-val"><?php echo e($order->formatted_city); ?> — <?php echo e($order->formatted_governorate); ?></div>
                    </div>
                </td>

                
                <td class="info-td-l">
                    <div class="info-heading"><?php echo e($order->t->invoice_section); ?></div>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->order_num_lbl); ?></div>
                        <div class="info-ltr"># <?php echo e($order->order_number); ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->issue_date_lbl); ?></div>
                        <div class="info-ltr"><?php echo e($order->created_at->format('Y-m-d')); ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->store_lbl); ?></div>
                        <div class="info-val"><?php echo e($order->t->store_name); ?> ⚡</div>
                    </div>

                    <div class="info-row">
                        <div class="info-key"><?php echo e($order->t->email_lbl); ?></div>
                        <div class="info-ltr">info@electric-store.com</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    
    <div class="sec-lbl"><?php echo e($order->t->products_section); ?></div>
    <table class="items-tbl" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th class="c" style="width:36px;">#</th>
            <th class="r"><?php echo e($order->t->product_col); ?></th>
            <th class="c" style="width:70px;"><?php echo e($order->t->qty_col); ?></th>
            <th class="l" style="width:115px;"><?php echo e($order->t->unit_price_col); ?></th>
            <th class="l" style="width:115px;"><?php echo e($order->t->total_col); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="c"><span class="idx-circle"><?php echo e($idx + 1); ?></span></td>
                <td class="r" style="font-weight:700; color:#111;"><?php echo e($item->formatted_name); ?></td>
                <td class="c" style="font-weight:700;"><?php echo e($item->quantity); ?></td>
                <td class="l price-v"><?php echo e(number_format($item->price, 0)); ?> <?php echo e($order->t->currency); ?></td>
                <td class="l total-v"><?php echo e(number_format($item->price * $item->quantity, 0)); ?> <?php echo e($order->t->currency); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px;">
        <tr>
            <td style="width:52%;"></td>
            <td style="width:48%; vertical-align:top;">
                <div class="totals-inner">

                    <div class="t-row">
                        <div class="t-lbl"><?php echo e($order->t->subtotal_lbl); ?></div>
                        <div class="t-val"><?php echo e(number_format($order->subtotal, 0)); ?> <?php echo e($order->t->currency); ?></div>
                    </div>

                    <?php if($order->discount > 0): ?>
                        <div class="t-row">
                            <div class="t-lbl"><?php echo e($order->t->discount_lbl); ?></div>
                            <div class="t-val v-green">- <?php echo e(number_format($order->discount, 0)); ?> <?php echo e($order->t->currency); ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="t-row">
                        <div class="t-lbl"><?php echo e($order->t->shipping_lbl); ?></div>
                        <div class="t-val">
                            <?php if($order->shipping == 0): ?>
                                <span class="v-green"><?php echo e($order->t->free_shipping); ?></span>
                            <?php else: ?>
                                <?php echo e(number_format($order->shipping, 0)); ?> <?php echo e($order->t->currency); ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="t-row">
                        <div class="t-lbl"><?php echo e($order->t->tax_lbl); ?> (14%)</div>
                        <div class="t-val"><?php echo e(number_format($order->tax, 0)); ?> <?php echo e($order->t->currency); ?></div>
                    </div>

                    <div class="t-row t-grand">
                        <div class="t-lbl"><?php echo e($order->t->grand_total_lbl); ?></div>
                        <div class="t-val"><?php echo e(number_format($order->total, 0)); ?> <?php echo e($order->t->currency); ?></div>
                    </div>

                </div>
            </td>
        </tr>
    </table>

</div>


<div class="footer-bar">
    <table class="ft-tbl" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="ft-brand"><?php echo e($order->t->store_name); ?> <span class="ft-gold">⚡</span></div>
                <div class="ft-sub">ELECTRIC STORE — EGYPT</div>
            </td>
            <td style="text-align:right;">
                <div class="ft-note">
                    <?php echo e($order->t->footer_note1); ?><br>
                    <?php echo e($order->t->footer_note2); ?> ⚡
                </div>
            </td>
        </tr>
    </table>
    <hr class="ft-hr">
    <div class="ft-btm">
        ORDER: <?php echo e($order->order_number); ?>

        &nbsp;•&nbsp;
        <?php echo e($order->t->footer_no_stamp); ?>

    </div>
</div>

</body>
</html>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/invoices/pdf.blade.php ENDPATH**/ ?>