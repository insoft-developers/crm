<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
<link rel="stylesheet" href="{{ asset('css/backend-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend.css?v=1.0.1') }}">
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
        font-size: 14px;
    }

    .subtitle {
        font-size: 14px;
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

    
</style>
