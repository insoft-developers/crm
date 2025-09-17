<!DOCTYPE html>
<html>

    <head>
        <title>{{ $title }}</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
            }

            .kop-surat {
                width: 100%;
                border-bottom: 2px solid #000;
                margin-bottom: 20px;
                padding-bottom: 10px;
            }

            .kop-surat img {
                float: left;
                height: 60px;
                margin-right: 15px;
            }

            .kop-surat .info {
                text-align: left;
            }

            h1 {
                text-align: center;
                margin: 20px 0;
                font-size: 16px;
                text-transform: uppercase;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #333;
                padding: 5px;
                vertical-align: top;
            }

            table.no-border {
                width: 100%;
                border-collapse: collapse;
            }

            table.no-border th,
            table.no-border td {
                border: none;
                /* hilangkan border */
                padding: 8px 10px;
                text-align: left;
            }

            table.no-border th {
                background-color: #f5f5f5;
                font-weight: bold;
            }

            table.no-border tr:nth-child(even) {
                background-color: #fafafa;
                /* zebra striping opsional */
            }

            .footer {
                position: fixed;
                bottom: 0px;
                left: 0px;
                right: 0px;
                text-align: center;
            }

            @page {
                margin-bottom: 120px;
                /* kasih jarak bawah biar footer tidak nutup konten */
            }
        </style>
    </head>

    <body>

        <!-- KOP SURAT -->
        <div class="kop-surat">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo">
            <div class="info">
                <strong><span style="font-size: 26px;">{{ $user->company_name }}</span></strong><br>
                <span>{{ $user->company_address }}<br>
                    Telp: {{ $user->phone_number }}, Email: {{ $user->email }}</span>
            </div>
        </div>



        <!-- DETAIL PEMBELIAN -->
        <table class="no-border">
            <tr>
                <td width="2%">No<br>Hal</td>
                <td width="1%">:<br>:</td>
                <td width="20%">{{ $purchase->purchase_order_number }}<br>Purchase Order</td>
                <td width="*" style="text-align: right;">{{ $user->city }},
                    {{ date('d F Y', strtotime($purchase->purchase_order_date)) }}</td>
            </tr>
            <tr>
                <td colspan="4">Kepada
                    Yth:<br><strong>{{ $purchase->vendor->vendor_name }}</strong><br>{{ $purchase->vendor->alamat_tagihan }}<br>{{ $purchase->vendor->province->province_name }}
                </td>

            </tr>
            <tr>
                <td colspan="4">Dengan Hormat,</td>
            </tr>
            <tr>
                <td colspan="4">Bersama surat ini kami sampaikan pesanan material sebagai berikut:</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>NO</th>
                <th>SPEC</th>
                <th colspan="3">UKURAN</th>
                <th>QTY</th>
                <th>BERAT</th>
                <th>HARGA/KG</th>
                <th>SUBTOTAL</th>
                <th>PPN</th>
                <th>KETERANGAN</th>

            </tr>
            @php
                $total_qty = 0;
                $total_weight = 0;

            @endphp
            @foreach ($items as $index => $item)
                @php
                    $total_qty = $total_qty + $item->quantity;
                    $total_weight = $total_weight + $item->weight;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->tebal }}</td>
                    <td>{{ $item->lebar }}</td>
                    <td>{{ $item->panjang }}</td>
                    <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->weight, 0, ',', '.') }}</td>
                    {{-- <td>{{ $item->satuan }}</td> --}}
                    <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->price_before_tax, 0, ',', '.') }}</td>
                    <td>{{ $item->tax }}%</td>
                    @if ($index == 0)
                        <td rowspan="{{ count($items) }}">
                            {{ $index == 0 ? 'Mill : ' . $purchase->mill : '' }}<br>{{ $index == 0 ? $purchase->delivery_methods->name : '' }}
                        </td>
                    @endif
                    {{-- <td>{{ number_format($item->price_before_tax, 0, ',', '.') }}</td> --}}
                </tr>
            @endforeach

            <tr style="background: rgb(217, 213, 213);">
                <th colspan="5" style="text-align: left;">TOTAL</th>
                <th style="text-align: left;">{{ $total_qty }}</th>
                <th style="text-align: left;">{{ $total_weight }}</th>
                <th></th>
                <th style="text-align: left;">SUBTOTAL</th>
                <th>:</th>
                <th style="text-align: left;">{{ number_format($purchase->subtotal, 0, ',', '.') }}</th>
            </tr>

            <tr style="background: rgb(217, 213, 213);">
                <th colspan="5" style="text-align: left;"></th>
                <th style="text-align: left;"></th>
                <th style="text-align: left;"></th>
                <th></th>
                <th style="text-align: left;">PAJAK</th>
                <th>:</th>
                <th style="text-align: left;">{{ number_format($purchase->total_tax, 0, ',', '.') }}</th>
            </tr>

            <tr style="background: rgb(217, 213, 213);">
                <th colspan="5" style="text-align: left;"></th>
                <th style="text-align: left;"></th>
                <th style="text-align: left;"></th>
                <th></th>
                <th style="text-align: left;">TOTAL PO</th>
                <th>:</th>
                <th style="text-align: left;">{{ number_format($purchase->total_price, 0, ',', '.') }}</th>
            </tr>
        </table>
        <table class="no-border">
            <tr>
                <td>Ketentuan : </td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; *{{ $purchase->payment_methods->code }} -
                    {{ $purchase->payment_methods->description }}</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $purchase->description }}</td>
            </tr>
            <tr>
                    <td>Demikian kami sampaikan, atas perhatian dan kerjasamanya<br>kami ucapkan terima kasih.</td>
                </tr>
        </table>
        <div class="footer">
            <table class="no-border">
                
                <tr>
                    <td style="padding-bottom: 100px;">
                        <strong>{{ $user->company_name }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>({{ $user->leader_name }})</strong>
                    </td>
                </tr>
            </table>
        </div>

    </body>

</html>
