<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
<link rel="stylesheet" href="{{ asset('css/backend-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


<link rel="stylesheet" href="{{ asset('vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}">
<!-- DataTables -->
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />




<style>
    .sm-input {
        padding: 0px 10px 0px 10px !important;
        height: 30px;
        font-size: 12px !important;

    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 49px;
        font-size: 13px !important;
        user-select: none;
        -webkit-user-select: none;
        border: 1px solid #d3d3d3;
        padding: 11px 0px 0px 3px !important;
        background: #f5f5f5;
        border-radius: 7px;
    }

    /* Perkecil font teks di dalam dropdown Select2 */
    .select2-container--default .select2-results__option {
        font-size: 12px;
        /* atur ukuran sesuai kebutuhan */
        padding: 4px 8px;
        /* opsional, supaya lebih rapat */
    }

    /* Batasi tinggi dropdown agar muncul scroll */
    .select2-container .select2-results {
        max-height: 150px;
        /* tinggi maksimum dropdown */
        overflow-y: auto;

        list-style: none;
        margin: 0;
        padding: 0px 5px;
        font-size: 13px !important;
        /* aktifkan scroll vertikal */
    }



    #product_items .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 33px !important;
        font-size: 13px !important;
        user-select: none;
        -webkit-user-select: none;
        border: 1px solid #d3d3d3;
        padding: 0px 0px 0px 3px !important;
        background: #f5f5f5;
        border-radius: 7px;
    }

    /* Perkecil font teks di dalam dropdown Select2 */
    #product_items .select2-container--default .select2-results__option {
        font-size: 12px;
        /* atur ukuran sesuai kebutuhan */
        padding: 4px 8px;
        /* opsional, supaya lebih rapat */
    }

    /* Batasi tinggi dropdown agar muncul scroll */
    #product_items .select2-container .select2-results {
        max-height: 150px;
        /* tinggi maksimum dropdown */
        overflow-y: auto;

        list-style: none;
        margin: 0;
        padding: 0px 5px;
        font-size: 13px !important;
        /* aktifkan scroll vertikal */
    }

    .label-insoft {
        margin-bottom: -4px !important;
        font-size: 15px !important;
    }

    .karyawan-id {
        background: green;
        text-align: center;
        color: white;
        padding: 0px 20px;
        border-radius: 4px;
    }

    .bintang::after {
        content: " *";
        color: red;
    }

    .control-label {
        font-size: 14px !important;
        font-weight: 500;
    }

    .modal-xl {
        max-width: 90%;
    }

    .modal-body {
        max-height: 80vh;
        overflow-y: auto;
    }

    #map {
        height: 300px;
        /* atau ubah sesuai kebutuhan */
        width: 100%;
    }

    .side-menu-title {
        font-size: 13px;
    }

    .subtitle {
        font-size: 12px;
    }

    .list-subtitle {}

    #table-list,
    #table-list-jenis,
    #table-list-type,
    #table-list-location,
    #table-list-ownership {
        font-size: 14px;
        /* atau ukuran lain seperti 1rem, 12px, dll */
    }

    #table-list-jenis thead th,
    #table-list-type thead th,
    #table-list-location thead th,
    #table-list-ownership thead th,
    #table-list thead th {
        font-size: 14px;
        font-weight: bold;
    }

    #table-list-jenis tbody td,
    #table-list-type tbody td,
    #table-list-location tbody td,
    #table-list-ownership tbody td,
    #table-list tbody td {
        font-size: 14px;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }


    #table-list-jenis tfoot th,
    #table-list-type tfoot th,
    #table-list-location tfoot th,
    #table-list-ownership tfoot th,
    #table-list tfoot th {
        font-size: 14px;
        font-style: italic;
    }

    /* .modal-content {
        background: #f3f3f3 !important;
    } */

    .form-control {
        border: 1px solid lightgrey !important;
        background-color: whitesmoke !important;
    }



    .profile-image {
        height: 40px;
        width: 30px;
        border-radius: 4px;
    }

    .fa-tombol-view {
        color: white;
        background: green;
        padding: 6px 6px;
        font-size: 12px;
        border-radius: 15px;
    }

    .fa-tombol-edit {
        color: white;
        background: orange;
        padding: 6px 6px;
        font-size: 12px;
        border-radius: 15px;
    }

    .fa-tombol-delete {
        color: white;
        background: red;
        padding: 6px 7px;
        font-size: 12px;
        border-radius: 13px;
    }

    .fa-tombol-copy {
        color: white;
        background: blue;
        padding: 6px 7px;
        font-size: 12px;
        border-radius: 13px;
    }

    .table-view {
        width: 100%;
    }

    .table-view td {
        padding: 10px;
        border: 1px solid whitesmoke;
        border-collapse: collapse;
        font-size: 14px;
    }



    .img-view-profile {
        width: 80px;
        height: 100px;
        border-radius: 5px;
        border: 2px solid whitesmoke;
        object-fit: cover;
    }

    .profile-image-upload {
        width: 180px;
        height: 224px;
        object-fit: cover;
        display: block;
        background: lightgrey;
        border: 2px solid beige;
        border-radius: 7px;
        cursor: pointer;
        padding: 10px;

    }

    .modal-body {
        background: url(http://127.0.0.1:8000/images/background.png);
        background-attachment: fixed;
        background-size: cover;
    }

    .doc-image-upload {
        width: 153px;
        border: 2px solid lightgrey;
        height: 109px;
        border-radius: 10px;
        cursor: pointer;
        padding: 10px;
        object-fit: contain;
    }


    .table-compact {
        font-size: 12px;
        /* ukuran font kecil */
        border-collapse: collapse;
        /* rapatkan border */
        width: 100%;

    }

    .table-compact th,
    .table-compact td {
        padding: 4px 4px;
        /* padding kecil */
        /* border: 1px solid #ddd; */
        /* garis tipis */
        vertical-align: middle;
        /* white-space: nowrap; */
        overflow: hidden;
        /* tengah vertikal */
    }

    .table-compact th {
        /* background-color: #f8f9fa; */
        /* warna header */
        font-weight: bold;
    }



    .table-compact-border {
        font-size: 12px;
        /* ukuran font kecil */
        border-collapse: collapse;
        /* rapatkan border */
        width: 100%;

    }

    .table-compact-border th,
    .table-compact-border td {
        padding: 4px 4px;
        /* padding kecil */
        border: 1px solid #ddd;
        /* garis tipis */
        vertical-align: middle;
        /* white-space: nowrap; */
        overflow: hidden;
        /* tengah vertikal */
    }

    .table-compact-border th {
        /* background-color: #f8f9fa; */
        /* warna header */
        font-weight: bold;
    }

    .karyawan-detail-document-image {
        width: 100px;
        height: auto;
        border-radius: 5px;
        background: orange;
        padding: 3px;
        object-fit: cover;
        cursor: pointer;
    }


    .tab-pane .card-body {
        /* padding-left: 0; */
        /* padding-right: 0; */
    }

    .alamat-row {
        border-bottom: 1px solid #dee2e6;
        /* abu tipis Bootstrap */
        margin-bottom: 1rem;
        padding-bottom: 1rem;
    }

    input[readonly] {
        background-color: lightgray !important;
    }

    #product_items .row {
        border-bottom: 1px solid #ddd;
        padding-bottom: 8px;
        margin-bottom: 8px;
    }

    label {
        margin-bottom: -10px !important;
    }

    a.disabled {
        pointer-events: none;
        /* biar tidak bisa diklik */
        opacity: 0.3;
        /* tampil lebih pucat */
        cursor: not-allowed;
        /* icon cursor silang */
    }

    .note-list {
        font-size: 14px;
        padding: 0px 10px 0px 10px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* ===== Modal Styling ===== */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        background: linear-gradient(135deg, #ffffff, #d584ab);
        color: #fff;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 15px 20px;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 600;
    }

    .modal-body {
        padding: 20px;
        background-color: #f9f9f9;
    }

    /* ===== Form Styling ===== */
    .form-group label {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 4px;
        color: #333;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 6px 10px;
        font-size: 13px;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.4);
    }

    /* Required field */
    label.bintang::after {
        content: " *";
        color: red;
    }

    /* ===== Card Section ===== */
    .card {
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }

    .card-title {
        font-weight: bold;
        font-size: 14px;
        background: #f0f0f0;
        padding: 8px 12px;
        border-radius: 8px 8px 0 0;
    }

    /* ===== Table-like product detail ===== */
    #product_items .row {
        margin-bottom: 8px;
        padding: 6px;
        border-bottom: 1px solid #eee;
    }

    #product_items .form-control {
        height: 32px;
        font-size: 12px;
        padding: 4px 8px;
    }

    /* ===== Footer Buttons ===== */
    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid #eee;
    }

    .modal-footer .btn {
        border-radius: 8px;
        padding: 5px 14px;
        font-size: 13px;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border: none;
    }

    .btn-default {
        background: #f5f5f5;
        border: 1px solid #ccc;
        color: #333;
    }

    /* Tombol hapus elegan */
    .btn-hapus-row {
        position: absolute;
        left: -21px;
        background: red;
        color: white;
        padding: 4px 4px 2px 9px !important;
        top: -52px;
        border-radius: 23px;
    }

    .readonly-select {
        pointer-events: none;
        /* tidak bisa di-klik */
        background-color: lightgrey !important;
        /* mirip input readonly */
    }

    table {
        width: 100% !important;

    }

    /* contoh: semua teks di tabel #table-list */
    #table-list,
    #table-list th,
    #table-list td {
        font-size: 12px !important;
        line-height: 1.5;
    }

    #btn-filter-data {
        margin-left: -4px !important;
    }

    /* kurangi jarak antar item menu utama */
    .iq-sidebar .iq-menu>li>a {
        padding-top: 6px;
        /* default biasanya 12–15px */
        padding-bottom: 6px;
        line-height: 1.5;
        /* rapatkan teks */
    }

    /* kurangi jarak pada submenu */
    .iq-sidebar .iq-submenu>li>a {
        padding-top: 4px;
        padding-bottom: 4px;
        line-height: 1.5;
    }

    /* opsional: kurangi margin antar <li> */
    .iq-sidebar .iq-menu>li,
    .iq-sidebar .iq-submenu>li {
        margin-bottom: 2px;
        /* default bisa 8–10px */
    }

    .dataTables_info,
    .dataTables_paginate,
    .dataTables_processing {
        font-size: 13px !important;
    }

    .form-group label {
        font-size: 12px !important;
    }

    .btn-fixing {
        padding: 1px 8px;
    }

    .text-kuning {
        color: orange;
    }

    .dataTables_filter label {
        font-size: 12px !important;
    }
</style>
