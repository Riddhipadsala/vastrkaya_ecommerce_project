<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Order Confirmation - {{ $order->order_number ?? $order->id }}</title>
    <style type="text/css">
        /* Client-specific Resets */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Mobile Responsive Rules */
        @media only screen and (max-width: 620px) {
            .mobile-container {
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }

            .mobile-padding {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .mobile-stack {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
                box-sizing: border-box !important;
            }

            .mobile-spacing {
                margin-bottom: 12px !important;
            }

            .mobile-center {
                text-align: center !important;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <!-- Wrapper Table (Ensures background color works everywhere) -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background-color: #f1f5f9; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 30px 10px;">

                <!-- Main Email Card Container (600px Max Width) -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" class="mobile-container"
                    style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">

                    <!-- 1. BRAND HEADER -->
                    <tr>
                        <td align="center" style="background-color: #a47979; padding: 32px 25px; text-align: center;">
                            <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Vastrkaya Logo"
                                style="max-height: 40px; width: auto;">
                            <p
                                style="margin: 6px 0 0; font-size: 11px; font-weight: 600; color: #ffecec; letter-spacing: 2px; text-transform: uppercase;">
                                Premium Fashion &amp; Lifestyle
                            </p>
                        </td>
                    </tr>

                    <!-- 2. SUCCESS ICON & TITLE -->
                    <tr>
                        <td class="mobile-padding" align="center" style="padding: 40px 40px 20px; text-align: center;">
                            <!-- Checkmark Circle -->
                            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 18px;">
                                <tr>
                                    <td align="center" valign="middle"
                                        style="width: 58px; height: 58px; background-color: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 50%; color: #059669; font-size: 26px; font-weight: bold; line-height: 58px;">
                                        &#10003;
                                    </td>
                                </tr>
                            </table>

                            <h2
                                style="margin: 0 0 10px; font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">
                                Thank You For Your Order!
                            </h2>
                            <p style="margin: 0; font-size: 15px; color: #475569; line-height: 24px;">
                                Hi <strong
                                    style="color: #0f172a;">{{ $order->user->name ?? 'Valued Customer' }}</strong>,
                                we’ve successfully received your order and we're preparing it for shipment.
                            </p>
                        </td>
                    </tr>

                    <!-- 3. ORDER METADATA CARD (Order #, Date, Status) -->
                    <tr>
                        <td class="mobile-padding" style="padding: 10px 40px 25px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <!-- Order ID -->
                                                <td width="36%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div
                                                        style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Order ID</div>
                                                    <div
                                                        style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 4px;">
                                                        #{{ $order->order_number ?? $order->id }}</div>
                                                </td>
                                                <!-- Order Date -->
                                                <td width="36%" valign="top" class="mobile-stack mobile-spacing">
                                                    <div
                                                        style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Order Date</div>
                                                    <div
                                                        style="font-size: 13px; font-weight: 600; color: #0f172a; margin-top: 4px;">
                                                        {{ isset($order->created_at) ? $order->created_at->format('M d, Y') : date('M d, Y') }}
                                                    </div>
                                                </td>
                                                <!-- Status -->
                                                <td width="28%" valign="top" align="right" class="mobile-stack">
                                                    <div
                                                        style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Status</div>
                                                    <div style="margin-top: 4px;">
                                                        <span
                                                            style="display: inline-block; background-color: #e0e7ff; color: #3730a3; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                            {{ $order->order_status ?? 'Processing' }}
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 4. ORDER SUMMARY HEADING -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 40px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                                <tr>
                                    <td align="left">
                                        <h3
                                            style="margin: 0; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #0f172a;">
                                            Order Summary
                                        </h3>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 12px; font-weight: 600; color: #64748b;">
                                            {{ isset($order->orderItems) ? count($order->orderItems) : 0 }} Item(s)
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 5. PRODUCT ITEMS LIST -->
                    <tr>
                        <td class="mobile-padding" style="padding: 10px 40px 15px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                @if (isset($order->orderItems) && count($order->orderItems) > 0)
                                    @foreach ($order->orderItems as $item)
                                        @php
                                            $product = $item->product ?? null;
                                        @endphp
                                        <tr>
                                            <td style="padding: 16px 0; border-bottom: 1px solid #f1f5f9;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <!-- Product Image -->
                                                        <td width="70" valign="top" style="padding-right: 15px;">
                                                            @if (!empty($product?->image))
                                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                                    alt="{{ $product->name ?? 'Product' }}"
                                                                    width="65" height="80"
                                                                    style="width: 65px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; display: block;" />
                                                            @else
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    width="65" height="80"
                                                                    style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; text-align: center;">
                                                                    <tr>
                                                                        <td align="center" valign="middle"
                                                                            style="font-size: 22px; color: #94a3b8;">
                                                                            🛍️</td>
                                                                    </tr>
                                                                </table>
                                                            @endif
                                                        </td>

                                                        <!-- Product Title & Details -->
                                                        <td valign="top" align="left">
                                                            <div
                                                                style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #7a2c3e; letter-spacing: 0.8px;">
                                                                {{ $product->brand ?? 'VastrKaya' }}
                                                            </div>
                                                            <div
                                                                style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 3px 0 6px; line-height: 19px;">
                                                                {{ $product->name ?? 'Ethnic Product' }}
                                                            </div>
                                                            <div
                                                                style="font-size: 12px; color: #64748b; font-weight: 500;">
                                                                Qty: <strong
                                                                    style="color: #0f172a;">{{ $item->quantity }}</strong>
                                                                &nbsp;&bull;&nbsp;
                                                                Price:
                                                                &#8377;{{ number_format($item->unit_price ?? $item->total_price / ($item->quantity ?: 1), 2) }}
                                                            </div>
                                                        </td>

                                                        <!-- Item Total -->
                                                        <td width="90" valign="middle" align="right">
                                                            <div
                                                                style="font-size: 15px; font-weight: 800; color: #0f172a;">
                                                                &#8377;{{ number_format($item->total_price ?? $item->quantity * ($item->unit_price ?? 0), 2) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td align="center" style="padding: 25px 0; color: #94a3b8; font-size: 14px;">
                                            No item details available.
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- 6. PRICING BREAKDOWN -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 40px 25px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <!-- Spacer for Desktop -->
                                    <td width="45%" class="mobile-stack"></td>

                                    <!-- Total Calculation Card -->
                                    <td width="55%" class="mobile-stack">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr style="padding:15px">
                                                <td
                                                    style="font-size: 15px; font-weight: 800; color: #0f172a; padding: 12px 0 4px;">
                                                    Total Paid
                                                </td>
                                                <td align="right"
                                                    style="font-size: 18px; font-weight: 800; color: #7a2c3e; padding: 12px 0 4px; border-top: 1px solid #e2e8f0; padding-bottom:12px">
                                                    &#8377;{{ number_format($order->total_amount, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 7. ACTION BUTTON (TRACK ORDER) -->
                    <tr>
                        <td class="mobile-padding" align="center"
                            style="padding: 10px 40px 35px; text-align: center;">
                            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td align="center"
                                        style="background-color: #7a2c3e; border-radius: 30px; box-shadow: 0 4px 15px rgba(255, 63, 108, 0.35);">
                                        <a href="{{ url('/my-orders') }}" target="_blank"
                                            style="display: inline-block; padding: 14px 36px; font-size: 14px; font-weight: 800; color: #ffffff; text-decoration: none; text-transform: uppercase; letter-spacing: 0.8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            Track Order &amp; Delivery &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 8. CUSTOMER SUPPORT BANNER -->
                    <tr>
                        <td
                            style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 22px 30px; text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 20px;">
                                Have questions about your order? Reach out to us at<br />
                                <a href="mailto:support@vastrkaya.com"
                                    style="color: #7a2c3e; font-weight: 700; text-decoration: none;">support@vastrkaya.com</a>

                            </p>
                        </td>
                    </tr>
                </table>
                <!-- /Main Email Card -->

            </td>
        </tr>
    </table>
    <!-- /Wrapper Table -->

</body>

</html>
