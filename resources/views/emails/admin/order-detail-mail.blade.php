<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>New Order Alert - #{{ $order->order_number ?? $order->id }}</title>
    <style type="text/css">
        /* Client-specific Resets */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #f9f7f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        /* Mobile Responsive Rules */
        @media only screen and (max-width: 620px) {
            .mobile-container { width: 100% !important; max-width: 100% !important; border-radius: 0 !important; }
            .mobile-padding { padding-left: 20px !important; padding-right: 20px !important; }
            .mobile-stack { display: block !important; width: 100% !important; text-align: left !important; box-sizing: border-box !important; }
            .mobile-spacing { margin-bottom: 12px !important; }
            .mobile-center { text-align: center !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f9f7f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2c2224;">

    <!-- Wrapper Table (Soft warm linen backdrop, easy on the eyes) -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f9f7f7; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 35px 12px;">
                
                <!-- Main Email Card Container (600px Max Width) -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" class="mobile-container" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 18px; overflow: hidden; border: 1px solid #ebdcdc; box-shadow: 0 8px 24px rgba(164, 121, 121, 0.08);">
                    
                    <!-- 1. BRAND HEADER (Matching Customer Email: #a47979 Dusty Rose) -->
                    <tr>
                        <td align="center" style="background-color: #a47979; padding: 30px 25px; text-align: center;">
                            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td align="center">
                                        <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Vastrkaya Logo"
                                            style="max-height: 42px; width: auto; display: block; margin: 0 auto 6px;" />
                                        <p style="margin: 0; font-size: 11px; font-weight: 600; color: #ffecec; letter-spacing: 2px; text-transform: uppercase;">
                                            Store Management &bull; Admin Notification
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 2. SOFT HERO BANNER (Dynamic for New Order vs Cancelled) -->
                    <tr>
                        <td class="mobile-padding" style="padding: 32px 38px 18px; text-align: left;">
                            @if (($order->order_status ?? '') === 'cancelled')
                                <!-- Cancelled Alert Pill -->
                                <div style="display: inline-block; background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 14px;">
                                    &#9888; Order Cancelled
                                </div>
                                <h2 style="margin: 0 0 8px; font-size: 22px; font-weight: 800; color: #991b1b; letter-spacing: -0.4px;">
                                    Order #{{ $order->order_number ?? $order->id }} Was Cancelled
                                </h2>
                                <p style="margin: 0; font-size: 14px; color: #6e5d61; line-height: 22px;">
                                    The customer has cancelled this order. Please halt packaging and shipment, and ensure inventory stock has been restored.
                                </p>
                            @else
                                <!-- Gentle Alert Pill -->
                                <div style="display: inline-block; background-color: #fdf2f4; border: 1px solid #f9d5dc; color: #7a2c3e; font-size: 11px; font-weight: 700; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 14px;">
                                    &bull; New Order Received
                                </div>
                                <h2 style="margin: 0 0 8px; font-size: 22px; font-weight: 800; color: #a65a5a; letter-spacing: -0.4px;">
                                    Order #{{ $order->order_number ?? $order->id }} Placed
                                </h2>
                                <p style="margin: 0; font-size: 14px; color: #6e5d61; line-height: 22px;">
                                    A new purchase has been completed on your store. Review the items and prepare for packaging and delivery.
                                </p>
                            @endif
                        </td>
                    </tr>

                    <!-- 3. ORDER SNAPSHOT CARD (Soft blush-tinted box) -->
                    <tr>
                        <td class="mobile-padding" style="padding: 8px 38px 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #faf6f6; border: 1px solid #eee3e3; border-radius: 14px;">
                                <tr>
                                    <td style="padding: 18px 22px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <!-- Order Total -->
                                                <td width="28%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase; letter-spacing: 0.5px;">Order Value</div>
                                                    <div style="font-size: 18px; font-weight: 800; color: #7a2c3e; margin-top: 4px;">
                                                        &#8377;{{ number_format($order->total_amount, 2) }}
                                                    </div>
                                                </td>
                                                <!-- Payment Method -->
                                                <td width="26%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase; letter-spacing: 0.5px;">Payment Mode</div>
                                                    <div style="font-size: 13px; font-weight: 700; color: #2c2224; margin-top: 5px; text-transform: uppercase;">
                                                        {{ $order->payment->payment_method ?? 'COD' }}
                                                    </div>
                                                </td>
                                                <!-- Status -->
                                                <td width="24%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase; letter-spacing: 0.5px;">Status</div>
                                                    <div style="margin-top: 5px;">
                                                        @if (($order->order_status ?? '') === 'cancelled')
                                                            <span style="display: inline-block; background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 12px; text-transform: uppercase;">
                                                                Cancelled
                                                            </span>
                                                        @else
                                                            <span style="display: inline-block; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px; text-transform: uppercase;">
                                                                {{ $order->order_status ?? 'Processing' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <!-- Date & Time -->
                                                <td width="22%" valign="top" align="right" class="mobile-stack">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase; letter-spacing: 0.5px;">Date</div>
                                                    <div style="font-size: 13px; font-weight: 600; color: #2c2224; margin-top: 5px;">
                                                        {{ isset($order->created_at) ? $order->created_at->format('M d, Y') : date('M d, Y') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 4. CUSTOMER DETAILS CARD -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 38px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #ebdcdc; border-radius: 14px; overflow: hidden;">
                                <tr>
                                    <td style="background-color: #fbf8f8; padding: 10px 18px; border-bottom: 1px solid #eee3e3;">
                                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #7a2c3e;">
                                            Customer Information
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="50%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase;">Name</div>
                                                    <div style="font-size: 14px; font-weight: 700; color: #2c2224; margin-top: 3px;">
                                                        {{ $order->user->name ?? 'Guest User' }}
                                                    </div>
                                                </td>
                                                <td width="50%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase;">Phone</div>
                                                    <div style="font-size: 14px; font-weight: 700; color: #2c2224; margin-top: 3px;">
                                                        {{ $order->user->phone ?? '91XXXXXXXXXX' }}
                                                    </div>
                                                </td>
                                                <td width="50%" valign="top" class="mobile-stack">
                                                    <div style="font-size: 11px; font-weight: 700; color: #8e7a7e; text-transform: uppercase;">Email</div>
                                                    <div style="font-size: 14px; font-weight: 600; color: #7a2c3e; margin-top: 3px;">
                                                        <a href="mailto:{{ $order->user->email ?? '' }}" style="color: #7a2c3e; text-decoration: none;">
                                                            {{ $order->user->email ?? 'N/A' }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 5. ITEMS TO FULFILL HEADING -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 38px 8px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1.5px solid #eee3e3; padding-bottom: 8px;">
                                <tr>
                                    <td align="left">
                                        <h3 style="margin: 0; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #2c2224;">
                                            Ordered Items ({{ isset($order->orderItems) ? count($order->orderItems) : 0 }})
                                        </h3>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #8e7a7e; letter-spacing: 0.5px;">
                                            Price Total
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 6. ITEMS LIST (Smooth product cards) -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 38px 18px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                @if(isset($order->orderItems) && count($order->orderItems) > 0)
                                    @foreach($order->orderItems as $item)
                                        @php
                                            $product = $item->product ?? null;
                                        @endphp
                                        <tr>
                                            <td style="padding: 14px 0; border-bottom: 1px solid #f6eeee;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <!-- Product Thumbnail -->
                                                        <td width="65" valign="top" style="padding-right: 14px;">
                                                            @if(!empty($product?->image))
                                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name ?? 'Product' }}" width="60" height="75" style="width: 60px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #eee3e3; display: block;" />
                                                            @else
                                                                <table border="0" cellpadding="0" cellspacing="0" width="60" height="75" style="background-color: #faf6f6; border: 1px solid #eee3e3; border-radius: 8px; text-align: center;">
                                                                    <tr>
                                                                        <td align="center" valign="middle" style="font-size: 20px; color: #a47979;">🛍️</td>
                                                                    </tr>
                                                                </table>
                                                            @endif
                                                        </td>

                                                        <!-- Product Details -->
                                                        <td valign="top" align="left">
                                                            <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; color: #7a2c3e; letter-spacing: 0.8px;">
                                                                {{ $product->brand ?? 'VastrKaya' }}
                                                            </div>
                                                            <div style="font-size: 14px; font-weight: 700; color: #2c2224; margin: 2px 0 4px; line-height: 18px;">
                                                                {{ $product->name ?? 'Ethnic Product' }}
                                                            </div>
                                                            <div style="font-size: 12px; color: #6e5d61;">
                                                                Qty: <strong style="color: #2c2224;">{{ $item->quantity }}</strong>
                                                                &nbsp;&bull;&nbsp;
                                                                Rate: &#8377;{{ number_format($item->unit_price ?? ($item->total_price / ($item->quantity ?: 1)), 2) }}
                                                            </div>
                                                        </td>

                                                        <!-- Line Total -->
                                                        <td width="90" valign="middle" align="right">
                                                            <div style="font-size: 14px; font-weight: 800; color: #2c2224;">
                                                                &#8377;{{ number_format($item->total_price ?? ($item->quantity * ($item->unit_price ?? 0)), 2) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td align="center" style="padding: 20px 0; color: #8e7a7e; font-size: 13px;">
                                            No item details recorded.
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- 7. REVENUE TOTALS (Clean eye-friendly layout) -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 38px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="45%" class="mobile-stack"></td>
                                    <td width="55%" class="mobile-stack">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="font-size: 14px; font-weight: 800; color: #2c2224; padding: 10px 0 2px; border-top: 1px solid #ebdcdc;">
                                                    Total Bill
                                                </td>
                                                <td align="right" style="font-size: 17px; font-weight: 800; color: #7a2c3e; padding: 10px 0 2px; border-top: 1px solid #ebdcdc;">
                                                    &#8377;{{ number_format($order->total_amount, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 8. ACTION BUTTON (Dynamic Button for New vs Cancelled) -->
                    <tr>
                        <td class="mobile-padding" align="center" style="padding: 5px 38px 35px; text-align: center;">
                            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td align="center" style="background-color: #7a2c3e; border-radius: 30px; box-shadow: 0 4px 15px rgba(122, 44, 62, 0.25);">
                                        @if (($order->order_status ?? '') === 'cancelled')
                                            <a href="{{ url('/admin/dashboard') }}" target="_blank" style="display: inline-block; padding: 14px 34px; font-size: 13px; font-weight: 800; color: #ffffff; text-decoration: none; text-transform: uppercase; letter-spacing: 0.8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                                Review Cancelled Order &rarr;
                                            </a>
                                        @else
                                            <a href="{{ url('/admin/dashboard') }}" target="_blank" style="display: inline-block; padding: 14px 34px; font-size: 13px; font-weight: 800; color: #ffffff; text-decoration: none; text-transform: uppercase; letter-spacing: 0.8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                                Open Admin Panel &rarr;
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 9. FOOTER (Soft, elegant warm footer) -->
                    <tr>
                        <td align="center" style="background-color: #fbf8f8; border-top: 1px solid #eee3e3; padding: 22px 25px; text-align: center;">
                            <p style="margin: 0 0 5px; font-size: 12px; color: #6e5d61; font-weight: 600;">
                                &copy; {{ date('Y') }} VastrKaya Management System
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #8e7a7e; line-height: 16px;">
                                This is an automated internal transaction notification dispatched to store managers and administrators.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- /Main Email Card Container -->

            </td>
        </tr>
    </table>
    <!-- /Wrapper Table -->

</body>
</html>
