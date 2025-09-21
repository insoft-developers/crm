<!-- JAVASCRIPT -->
<script>
    const locationList = @json($locations);
    let rowIndex = 1;
    let save_index = '';

    $(".select2").select2({
        theme: 'bootstrap-3', // optional jika pakai tema bootstrap
        dropdownParent: $('#modal-add'), // 🔑 kunci agar muncul di dalam modal
        width: '100%'
    });


    function get_po_data(id = null) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('get.po.data') }}",
            type: "POST",
            data: {
                "_token": csrf_token
            },
            success: function(data) {
                var HTML = '<option value="">Pilih Nomor Purchase Order</option>';

                for (var i = 0; i < data.length; i++) {
                    HTML += '<option value="' + data[i].id + '">' +
                        data[i].purchase_order_number + '</option>';
                }

                // isi select
                $("#po_id").html(HTML);

                // kalau id tidak null, set value dan trigger change
                if (id !== null) {
                    $("#po_id").val(id).trigger('change');
                }
            }
        });
    }




    function generate_gr_number() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('generate.gr.number') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "_token": csrf_token
            },
            success: function(data) {
                $("#gr_number").val(data.gr_number);
            }

        });
    }


    $("#po_id").change(function() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id = $("#po_id").val();
        var gr_id = $("#id").val();
        if (id == null) {

        } else {
            $.ajax({
                url: "{{ route('po.data.serve') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id": id,
                    "save_index": save_index,
                    "gr_id": gr_id,
                    "_token": csrf_token
                },
                success: function(data) {
                    console.log(data);
                    var vendors = '';
                    vendors += data.po.vendor.vendor_name + '<br>';
                    vendors += data.po.vendor.alamat_tagihan + '<br>';
                    vendors += data.po.vendor.city.city_name + ', ' + data.po.vendor.province
                        .province_name + ' ' + data.po.vendor.postal_code + '<br>';
                    vendors += 'Indonesia <br>';
                    vendors += data.po.vendor.kontak_tagihan + '<br>';
                    vendors += '<strong>Nomor Pajak : </strong>' + data.po.vendor.npwp + '<br>';
                    $("#vendor_id").html(vendors);

                    var whs = '';
                    if (save_index == 'add') {
                        
                        whs += data.po.gudang.name + '<br>';
                        whs += data.po.gudang.address + '<br>';
                        whs += data.po.gudang.rcity.city_name + ', ' + data.po.gudang.rprovince
                            .province_name + ' ' + data.po.gudang.postal_code + '<br>';
                        whs += 'Indonesia <br>';
                        whs += data.po.gudang.contact + '<br>';
                        // whs += '<strong>Nomor Pajak : </strong>'+data.po.gudang.npwp+'<br>';
                        $("#mills").text(data.po.mill);
                         var jatuh_tempo = hitungJatuhTempo(data.po.purchase_order_date, data.po
                        .payment_methods.term_days);
                        
                    } else {
                        whs += data.po.warehouse.name + '<br>';
                        whs += data.po.warehouse.address + '<br>';
                        whs += data.po.warehouse.rcity.city_name + ', ' + data.po.warehouse.rprovince
                            .province_name + ' ' + data.po.warehouse.postal_code + '<br>';
                        whs += 'Indonesia <br>';
                        whs += data.po.warehouse.contact + '<br>';

                        $("#mills").text(data.po.mills);
                         var jatuh_tempo = hitungJatuhTempo(data.po.due_date, 0);
                    }
                    
                    $("#warehouse_id").html(whs);


                   
                    $("#due_date").text(jatuh_tempo);

                    $("#payment_method").text(data.po.payment_methods.code);
                    $("#product_category").text(data.po.product_category);
                    
                    $("#delivery_method").text(data.po.delivery_methods.name);
                    $("#description").text(data.po.description);
                    var status_text = null;
                    if (data.po.status == 1) {
                        status_text = 'Dikirim';
                    } else if (data.po.status == 2) {
                        status_text = 'Outstanding';
                    } else if (data.po.status == 3) {
                        status_text = 'Proses';
                    } else if (data.po.status == 4) {
                        status_text = 'Selesai';
                    }

                    $("#status").text(status_text);


                    show_items(data.po, save_index);

                }
            });
        }


    });





    function loading() {
        $("#btn-save-data").text("Processing....");
        $("#btn-save-data").attr("disabled", true);
    }

    function unloading() {
        $("#btn-save-data").text("Save");
        $("#btn-save-data").removeAttr("disabled");
    }

    let table = $('#table-list').DataTable({
        dom: 'Bfrtip',
        buttons: ['csv', 'excel', 'pdf'],
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('good.receive.table') }}',
            data: function(d) {
                // tambahin parameter filter
                d.filter_date = $('#filter_date').val();
                d.filter_status = $('#filter_status').val();
                d.filter_vendor = $("#filter_vendor").val();
            }
        },
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'gr_number',
                name: 'gr_number'
            },
            {
                data: 'vendor_id',
                name: 'vendor_id'
            },

            {
                data: 'contract_number',
                name: 'contract_number'
            },
            {
                data: 'warehouse_id',
                name: 'warehouse_id'
            },
            {
                data: 'mills',
                name: 'mills'
            },
            {
                data: 'product_category',
                name: 'product_category'
            },
            {
                data: 'total_weight_received',
                name: 'total_weight_received'
            },
            {
                data: 'good_status',
                name: 'good_status'
            },
            {
                data: 'status',
                name: 'status'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#btn-filter-data').click(function() {
        table.ajax.reload();
    });

    // tombol reset filter
    $('#btn-refresh-data').click(function() {
        // kosongkan input
        $('#filter_date').val('');
        $('#filter_status').val('');
        $('#filter_vendor').val('');
        // reload datatable
        $('#table-list').DataTable().ajax.reload();
    });


    function addData() {
        save_index = 'add';
        resetForm();
        get_po_data();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Tambah Penerimaan Barang Masuk");
        $("#modal-add").modal("show");
        generate_gr_number();
        unloading();
        $("#po_id").removeClass('readonly-select');
    }



    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/good_receive') }}";
        else url = "{{ url('/good_receive') . '/' }}" + id;
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-add form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                unloading();
                if (data.success) {
                    $('#modal-add').modal('hide');
                    reloadTable();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                }
            }

        });
    });


    function editData(id) {
        save_method = "edit";
        save_index = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/good_receive') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Penerimaan Barang Masuk");
                $("#id").val(data.id);
                $("#gr_number").val(data.gr_number);
                get_po_data(data.po_id);
                $("#gr_date").val(data.gr_date);
                $("#contract_number").val(data.contract_number);



            }
        })
    }



    function viewData(id) {
        $(".modal-title").text('Detail Penerimaan Barang Masuk');
        $("#purchase_id_show").val(id);
        $.ajax({
            url: "{{ url('good_receive') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                var HTML = '';
                HTML += '<div class="card">';
                HTML += '<div class="card-body">';
                HTML += '<table class="table-compact">';
                HTML += '<tr>';
                HTML += '<td width="8%">NO GR</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.gr_number + '</td>';
                HTML += '<td width="8%">Tanggal Pesan</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + formatTanggal(data.gr.gr_date) + '</td>';

                HTML += '<td width="15%">Tanggal Jatuh Tempo</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">'+formatTanggal(data.gr.due_date)+'</td>';
                HTML += '</tr>';


                HTML += '<tr>';
                HTML += '<td width="8%">NO PO</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.po_number + '</td>';
                HTML += '<td width="8%">ID Kontrak</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">'+data.gr.contract_number+'</td>';

                HTML += '<td width="15%"></td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*"></td>';
                HTML += '</tr>';

                HTML += '<tr>';
                HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%"><strong>' + data
                    .gr.vendor.vendor_name + '</strong><br>' + data.gr.vendor.alamat_tagihan + '<br>' +
                    data.gr.vendor.city.city_name + '<br>' + data.gr.vendor.province
                    .province_name + ' ' + data.gr.vendor.postal_code + '<br>' + data.gr.vendor
                    .kontak_tagihan + '</td>';

                HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%"><strong>' + data
                    .gr.warehouse.name + '</strong><br>' + data.gr.warehouse.address + '<br>' + data.gr
                    .warehouse.rcity.city_name + '<br>' + data.gr.warehouse.rprovince.province_name + ' ' +
                    data.gr.warehouse.postal_code + '<br>' + data.gr.warehouse.contact + '</td>';

                HTML += '<td width="15%">Kategori</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.product_category + '</td>';
                HTML += '</tr>';



                HTML += '<tr>';

                HTML += '<td width="15%">Metode Pembayaran</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.payment_methods.code + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';


                HTML += '<td width="15%">Mill</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.mills + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';


                HTML += '<td width="15%">Metode Pengiriman</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.delivery_methods.name + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';


                HTML += '<td width="15%">Deskripsi</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.description + '</td>';
                HTML += '</tr>';


                HTML += '<tr>';
                HTML += '<td width="8%">Nomor Pajak</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.vendor.npwp + '</td>';
                HTML += '<td width="8%">Nomor Pajak</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.vendor.npwp + '</td>';

                HTML += '<td width="15%">Status</td>';
                HTML += '<td width="2%">:</td>';

                if (data.gr.status == 1) {
                    HTML += '<td width="*"><div class="text-info">Dikirim</div></td>';
                } else if (data.gr.status == 2) {
                    HTML += '<td width="*"><div class="text-kuning">Outstanding</div></td>';
                } else if (data.gr.status == 3) {
                    HTML += '<td width="*"><div class="text-danger">Proses</div></td>';
                } else if (data.gr.status == 4) {
                    HTML += '<td width="*"><div class="text-success">Selesai</div></td>';
                }
                HTML += '</tr>';

                HTML += '</table>';
                HTML += '</div>';
                HTML += '</div>';


                HTML += '<div style="margin-top:30px;"></div>';
                HTML += '<div class="card">';


                HTML += '<div class="card-body">';
                HTML += '<div class="card-title">Produk</div>';
                HTML += '<table class="table-compact">';
                HTML += '<tr>';

                HTML += '<tr>';
                HTML += '<th>Nomor SP</th>';
                HTML += '<th>Tgl Kirim</th>';
                HTML += '<th>Tgl Datang</th>';
                HTML += '<th>Nomor Coil</th>';
                HTML += '<th>Nama Spek</th>';
                HTML += '<th>Tebal</th>';
                HTML += '<th>Lebar</th>';
                HTML += '<th>Panjang</th>';
                HTML += '<th>Qty</th>';
                HTML += '<th>Qty Received</th>';
                HTML += '<th>Satuan</th>';
                HTML += '<th>Berat</th>';
                HTML += '<th>Berat Received</th>';
                HTML += '<th>Lokasi</th>';
                HTML += '</tr>';

                for (var i = 0; i < data.gr.item.length; i++) {
                    HTML += '<tr>';
                    HTML += '<td>'+data.gr.item[i].sp_number+'</td>';
                    HTML += '<td>'+data.gr.item[i].delivery_date+'</td>';
                    HTML += '<td>'+data.gr.item[i].arrive_date+'</td>';
                    HTML += '<td>'+data.gr.item[i].coil_number+'</td>';
                    HTML += '<td>'+data.gr.item[i].product.product_name+'</td>';
                    HTML += '<td>'+data.gr.item[i].tebal+'</td>';
                    HTML += '<td>'+data.gr.item[i].lebar+'</td>';
                    HTML += '<td>'+data.gr.item[i].panjang+'</td>';
                    HTML += '<td>'+data.gr.item[i].quantity+'</td>';
                    HTML += '<td>'+data.gr.item[i].quantity_received+'</td>';
                    HTML += '<td>'+data.gr.item[i].satuan+'</td>';
                    HTML += '<td>'+ribuan(data.gr.item[i].weight)+'</td>';
                    HTML += '<td>'+ribuan(data.gr.item[i].weight_received)+'</td>';
                    HTML += '<td>'+data.gr.item[i].location+'</td>';
                    HTML += '</tr>';
                }

                HTML += '<tr>';
                HTML += '<th colspan="12"></th>';
                HTML += '<th>Total Berat</th>';
                HTML += '<th>'+ribuan(data.gr.total_weight)+'</th>';
                HTML += '</tr>';
                HTML += '<tr>';
                HTML += '<th colspan="12"></th>';
                HTML += '<th>Total Berat Diterima</th>';
                HTML += '<th>'+ribuan(data.gr.total_weight_received)+'</th>';
                HTML += '</tr>';
                HTML += '<tr>';
                HTML += '<th colspan="12"></th>';
                HTML += '<th>Total Berat Outstanding</th>';
                HTML += '<th>'+ribuan(data.gr.total_weight_outstanding)+'</th>';
                HTML += '</tr>';

                HTML += '</table>';
                HTML += '</div>';
                HTML += '</div>';

                $("#modal-view-content").html(HTML);

                $("#modal-view").modal("show");
            }
        })




    }



    function reloadTable() {
        var table = $("#table-list").DataTable();
        table.ajax.reload(null, false);
    }

    function resetForm() {
        $("#id").val("");
        $("#po_id").val("").trigger('change');
        $("#vendor_id").html("");
        $("#warehouse_id").html("");
        $("#contact_number").val("");
        $("#gr_date").val("");
        $("#due_date").text("");
        $("#payment_method").html("");
        $("#product_category").text("");
        $("#mills").text("");
        $("#delivery_method").text("");
        $("#description").text("");
        $("#status").text("Outstanding");
        $("#total_weight").val("");
        $("#total_weight_received").val("");
        $("#total_weight_outstanding").val("");

        $("#product_items").html('<center>Belum ada daftar produk</center>');
    }





    function show_items(data, save_index) {
        console.log(data);
        rowIndex = 1;

        var HTML = '';
        for (var i = 0; i < data.item.length; i++) {


            let locationOptions = `
            <option value="" disabled ${!data.item[i].location ? 'selected' : ''}>
                Pilih Lokasi
            </option>`;

            // loop untuk setiap pajak yang sudah dikirim dari server
            for (let t = 0; t < locationList.length; t++) {
                const loc = locationList[t];
                const selected = data.item[i].location === loc.location_name ? 'selected' : '';
                locationOptions += `<option value="${loc.location_name}" ${selected}>${loc.location_name}</option>`;
            }


            // <input value="${ save_index == 'edit' ? data.item[i].id: ''}" type="hidden" id="gr_item_id_${rowIndex}" name="gr_item_id[]">

            HTML += `<div id="row_${rowIndex}" class="row">
                <div class="col-1">
                    <div class="form-group">
                        <label>Nomor SP</label>
                        
                        <input value="${ save_index == 'edit' ? data.item[i].id :''}" type="hidden" id="gr_id_item_${rowIndex}" name="gr_id_item[]">
                        <input value="${ save_index == 'edit' ? data.item[i].po_item_id : data.item[i].id}" type="hidden" id="good_id_item_${rowIndex}" name="good_id_item[]">
                        <input value="${ save_index == 'edit' ? data.item[i].sp_number : ''}" type="text" class="form-control sm-input"
                            id="sp_number_${rowIndex}" name="sp_number[]">
                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Tgl Kirim</label>
                        <input value="${save_index == 'edit' ? data.item[i].delivery_date :'' }" type="date" class="form-control sm-input"
                            id="delivery_date_${rowIndex}" name="delivery_date[]">
                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Tgl Datang</label>
                        <input value="${save_index == 'edit' ? data.item[i].arrive_date : ''}" type="date" class="form-control sm-input"
                            id="arrive_date_${rowIndex}" name="arrive_date[]">
                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Nomor Coil</label>
                        <input value="${save_index == 'edit'? data.item[i].coil_number : ''}" type="text" class="form-control sm-input"
                            id="coil_number_${rowIndex}" name="coil_number[]">
                    </div>
                </div>

                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Spec</label>
                        <input value="${data.item[i].product.product_name}" readonly type="text" class="form-control sm-input"
                            id="product_name_${rowIndex}" name="product_name[]">
                        <input value="${data.item[i].product_id}" type="hidden" id="product_id_${rowIndex}" name="product_id[]">
                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Tebal</label>
                        <input value="${data.item[i].tebal}" readonly type="text" class="form-control sm-input"
                            id="tebal_${rowIndex}" name="tebal[]">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Lebar</label>
                        <input value="${data.item[i].lebar}" readonly type="text" class="form-control sm-input"
                            id="lebar_${rowIndex}" name="lebar[]">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Panjang</label>
                        <input value="${data.item[i].panjang}" readonly type="text" class="form-control sm-input"
                            id="panjang_${rowIndex}" name="panjang[]">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Qty</label>
                        <input value="${save_index=='edit'?ribuan(Number(data.item[i].quantity_outstanding)+Number(data.item[i].quantity_received)):ribuan(data.item[i].quantity_outstanding)}" readonly type="number" class="form-control sm-input"
                            id="quantity_${rowIndex}" name="quantity[]">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Received</label>
                        <input value="${save_index=='edit'?data.item[i].quantity_received:' '}" type="number" class="form-control sm-input"
                            id="quantity_received_${rowIndex}" name="quantity_received[]"
                            placeholder="Qty">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Satuan</label>
                        <input value="${data.item[i].satuan}" readonly type="text" class="form-control sm-input"
                            id="satuan_${rowIndex}" name="satuan[]">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Berat</label>
                        <input value="${save_index=='edit'?ribuan(Number(data.item[i].weight_outstanding) + Number(data.item[i].weight_received)):ribuan(data.item[i].weight_outstanding)}" readonly type="text" class="form-control sm-input berat-order"
                            id="weight_${rowIndex}" name="weight[]">

                    </div>
                </div>
                <div class="col-2 col-custom">
                    <div class="form-group">
                        <label>Received</label>
                        <input value="${save_index=='edit'?data.item[i].weight_received:''}" onkeyup="weight_receive_onchange(${rowIndex}, this)" type="number" class="form-control sm-input berat-diterima"
                            id="weight_received_${rowIndex}" name="weight_received[]"
                            placeholder="Berat">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Lokasi</label>
                        <select class="form-control sm-input" id="location_${rowIndex}"
                            name="location[]">
                            <option value="" selected disabled>Pilih</option>
                            ${locationOptions}
                        </select>

                    </div>
                </div>
                <button type="button" class="btn btn-hapus-row2"
                    onclick="hapusBaris(${rowIndex})" title="Hapus baris">
                    <i class="fa fa-remove"></i>
                </button>

            </div>`;

            rowIndex++;
        }



        $("#product_items").html(HTML);
        Swal.fire({
            icon: "success",
            title: "",
            text: 'Data Produk Telah Tersedia',
            footer: ''
        });

        hitung_total_berat();
    }

    function weight_receive_onchange(index, el) {
        var berat = $(el).val();
        var edit_id = $("#gr_id_item_"+index).val();
        var add_id = $("#good_id_item_"+index).val();

        var item_id = save_index == 'edit' ? edit_id : add_id;
    
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('weight.receive.change') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "save_index":save_index,
                "item_id": item_id,
                "berat": berat,
                "_token": csrf_token
            },
            success: function(data) {
                if (data.success) {

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                    $("#weight_received_" + index).val(data.data);
                }
                hitung_total_berat();
            }
        });

    }

    function hitung_total_berat() {
        let total_berat_order = 0;
        $(".berat-order").each(function() {
            var berat = angka($(this).val());
            total_berat_order = total_berat_order + berat;
        });

        $("#total_weight").val(ribuan(total_berat_order));


        let total_berat_diterima = 0;
        $(".berat-diterima").each(function() {
            var terima = Number($(this).val()) || 0;
            total_berat_diterima = total_berat_diterima + terima;
        });

        $("#total_weight_received").val(ribuan(total_berat_diterima));


        var total_sisa = total_berat_order - total_berat_diterima;
        $("#total_weight_outstanding").val(ribuan(total_sisa));

    }


    function hapusBaris(index) {
        Swal.fire({
            icon: 'question',
            title: 'Hapus data ini?',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {

                let $row = $("#row_" + index);

                if ($row.length) { // pastikan row ada
                    $row.fadeOut(200, function() {
                        $(this).remove();

                        // Cek dulu apakah fungsi hitung_subtotal ada
                        if (typeof hitung_total_berat === "function") {
                            try {
                                hitung_total_berat();
                            } catch (err) {
                                console.error("Error saat hitung_total_berat:", err);
                            }
                        }
                    });
                }


            }
        });

    }
</script>
