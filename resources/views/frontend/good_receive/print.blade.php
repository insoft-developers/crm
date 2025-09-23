<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/backend-bundle.min.css') }}"> --}}
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        @page {
            size: A4;
            margin: 5mm;
        }

        .page {
            display: flex;
            flex-wrap: wrap;
            /* penting: agar card berikutnya turun ke baris baru */
            justify-content: space-between;
        }

        .card {
            width: 45%;
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            box-sizing: border-box;
            margin-bottom: 16px;
            /* jarak vertikal antar baris */
        }

        .card h2 {
            margin-top: 0;
            font-size: 1.2rem;
        }

        .page::after {
            content: "";
            display: block;
            clear: both;
        }

        .card {
            float: left;
            width: 45%;
            margin: 0 2% 16px 0;
        }

        .card:nth-child(2n) {
            margin-right: 0;
        }

        .img-logo {
            width: 40px;
            height: auto;
            object-fit: cover;
        }

        .head-title {
            font-size: 28px;
            font-weight: bold;
            position: relative;
            top: -25px;
            margin-left: 15px;

        }

        .card-header {
            border-bottom: 2px solid #ccc;
            /* warna & ketebalan garis */
            padding-bottom: 4px;
            /* jarak teks ke garis */
            margin-bottom: 8px;
            /* jarak ke .card-body */
        }

        .card-text {
            font-weight: bold;
            font-size: 18px;
            margin-top: px;

        }

       

        .side-step {
            font-weight: 700;
            font-size: 14px;
            position: relative;
            left: 120px;
            top:-150px;
            width:250px;
            margin-bottom: -100px !important;        
        }
        

    </style>

</head>

<body>

    {{-- <!-- KOP SURAT -->
    <div class="kop-surat">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <div class="info">
            <strong><span style="font-size: 26px;">{{ $user->company_name }}</span></strong>
        </div>
    </div> --}}
    <div class="page">
        @foreach ($items as $item)
            @php
                // Hasil generate() sudah berupa biner PNG
                $qrBinary = QrCode::format('svg')->size(200)->generate($item->coil_number);

                // Baru sekali di-base64
                $qrBase64 = base64_encode($qrBinary);
            @endphp
            <div class="card">
                <h5 class="card-header">
                    <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="Logo">
                    <span class="head-title">{{ $user->company_name }}</span>
                </h5>

                <div class="card-body">
                    <img style="margin-top:10px;" src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code"
                        width="100" height="100">
                    <p class="card-text">{{ $item->sp_number }}</p>
                    <div class="side-step">
                        <p>No Coil : {{ $item->coil_number }}</p>
                        <p>Spekifikasi : {{ $item->product->product_name }}
                            {{ $item->tebal }}X{{ $item->lebar }}X{{ $item->panjang }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



</body>

</html>
