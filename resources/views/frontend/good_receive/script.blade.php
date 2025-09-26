<!-- JAVASCRIPT -->
<script>
    const locationList = @json($locations);
    let rowIndex = 1;
    let rowTitipan = 1;
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
                "po_id":id,
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




    function generate_gr_number(type) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('generate.gr.number') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "type": type,
                "_token": csrf_token
            },
            success: function(data) {
                if (type == 1) {
                    $("#gr_number").val(data.gr_number);
                } else {
                    $("#titipan_number").val(data.gr_number);
                }

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
                        whs += data.po.warehouse.rcity.city_name + ', ' + data.po.warehouse
                            .rprovince
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
                    $("#description").html(data.po.description);
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
        $("#form-add #btn-save-data").text("Processing....");
        $("#form-add #btn-save-data").attr("disabled", true);

        $("#form-titipan #btn-save-data").text("Processing....");
        $("#form-titipan #btn-save-data").attr("disabled", true);
    }

    function unloading() {
        $("#form-add #btn-save-data").text("Save");
        $("#form-add #btn-save-data").removeAttr("disabled");

        $("#form-titipan #btn-save-data").text("Save");
        $("#form-titipan #btn-save-data").removeAttr("disabled");

        $("#form-add #btn-save-data").text("Save");
        $("#form-add #btn-save-data").removeAttr("disabled");

        $("#form-titipan #btn-save-data").text("Save");
        $("#form-titipan #btn-save-data").removeAttr("disabled");
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
        generate_gr_number(1);
        unloading();
        $("#po_id").removeClass('readonly-select');
    }



    function addTitipan() {
        save_index = 'add';
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $("#titipan_status").html('<span class="text-kuning">Outstanding</span>');

        $(".modal-title").text("Tambah Penerimaan Barang Titipan");
        $("#modal-titipan").modal("show");
        generate_gr_number(2);
        unloading();
        init_titipan_item();

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
       
        $.ajax({
            url: "{{ url('/good_receive') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {


                if (data.good_status == 2) {
                    $('input[name="_method"]').val('POST');

                    $('.modal-title').text("Edit Penerimaan Barang Titipan");
                    $('#modal-titipan').modal("show");
                    $("#titipan_id").val(data.id);
                    $('#titipan_number').val(data.gr_number);
                    $("#customer_id").val(data.vendor_id).trigger('change');
                    $("#titipan_product_category").val(data.product_category);
                    $("#titipan_warehouse_id").val(data.warehouse_id).trigger('change');
                    $("#titipan_gr_date").val(data.gr_date);
                    $("#titipan_mills").val(data.mills);
                    $("#titipan_status").html('<span class="text-success">Selesai</span>');
                    edit_item_titipan(data);
                    $("#titipan_total_weight").val(ribuan(data.total_weight));
                    $("#titipan_total_weight_received").val(ribuan(data.total_weight_received));
                    $("#titipan_total_weight_outstanding").val(ribuan(data.total_weight_outstanding));
                    $("#titipan_sp_number").val(data.sp_number);
                } else {
                    $('input[name=_method]').val('PATCH');
                    $('.modal-title').text("Edit Penerimaan Barang Masuk");
                    $('#modal-add').modal("show");
                    $("#id").val(data.id);
                    $("#gr_number").val(data.gr_number);
                    get_po_data(data.po_id, 1);
                    $("#gr_date").val(data.gr_date);
                    $("#contract_number").val(data.contract_number);
                    $("#sp_number").val(data.sp_number);
                }

            }
        })
    }

    function edit_item_titipan(kirim) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $("#product_titipan").html('');

        $.ajax({
            url: "{{ route('product.category') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "category": kirim.product_category,
                "_token": csrf_token
            },
            success: function(data) {
                $.each(kirim.item, function(i, obj) {
                    show_item_edit_titipan(obj, data);
                });
            }
        });
    }


    function show_item_edit_titipan(data, prodList) {
        console.log(prodList);

        var HTML = '';

         

        
        const selectedLocation = data.location; 
        let locationOptions = `
            <option value="" ${!data.location ? 'selected' : ''}>
                Pilih Lokasi
            </option>`;

        for (let t = 0; t < locationList.length; t++) {
            const loc = locationList[t];
            const isSelected = loc.location_name === selectedLocation ? 'selected' : '';
            locationOptions += `<option value="${loc.location_name}" ${isSelected}>${loc.location_name}</option>`;
        }


        const selectedProduct = data.product_id; 
        let productOptions = '';

        for (let p = 0; p < prodList.length; p++) {
            const prod = prodList[p];
            const isSelected = prod.id === selectedProduct ? 'selected' : '';
            productOptions += `<option value="${prod.id}" ${isSelected}>${prod.product_name}</option>`;
        }

        HTML += `<div id="row_titipan_${rowTitipan}" class="row">
            
            <div class="col-1">
                <div class="form-group">
                    <label>Tgl Kirim</label>
                    <input value="${data.gr_id}" type="hidden" id="gr_id_item_titipan_${rowTitipan}" name="gr_id_item[]">
                    <input value="${data.gr_id}" type="hidden" id="good_id_item_titipan_${rowTitipan}" name="good_id_item[]">
                    <input value="${data.delivery_date}" type="date" class="form-control sm-input"
                        id="delivery_date_titipan_${rowTitipan}" name="delivery_date[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Tgl Datang</label>
                    <input value="${data.arrive_date}" type="date" class="form-control sm-input"
                        id="arrive_date_titipan_${rowTitipan}" name="arrive_date[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Nomor Coil</label>
                    <input value="${data.coil_number}" type="text" class="form-control sm-input"
                        id="coil_number_titipan_${rowTitipan}" name="coil_number[]">
                </div>
            </div>

            <div class="col-3 col-custom">
                <div class="form-group">
                    <label>Spec</label>
                    <select onchange="selected_product(${rowTitipan})" class="form-control sm-input product-id"
                        id="product_id_titipan_${rowTitipan}" name="product_id[]">
                        ${productOptions}
                    </select>
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Tebal</label>
                    <input value="${data.tebal}" readonly type="text" class="form-control sm-input"
                        id="tebal_titipan_${rowTitipan}" name="tebal[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Lebar</label>
                    <input value="${data.lebar}" readonly type="text" class="form-control sm-input"
                        id="lebar_titipan_${rowTitipan}" name="lebar[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Panjang</label>
                    <input value="${data.panjang}" readonly type="text" class="form-control sm-input"
                        id="panjang_titipan_${rowTitipan}" name="panjang[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Quantity</label>
                    <input value="${data.quantity_received}" type="number" class="form-control sm-input"
                        id="quantity_received_titipan_${rowTitipan}" name="quantity_received[]">

                </div>
            </div>
            
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Satuan</label>
                    <input value="${data.satuan}" readonly type="text" class="form-control sm-input"
                        id="satuan_titipan_${rowTitipan}" name="satuan[]">

                </div>
            </div>
            <div class="col-2 col-custom">
                <div class="form-group">
                    <label>Received</label>
                    <input value="${data.weight_received}" onkeyup="weight_titipan_onchange(${rowTitipan}, this)" type="number" class="form-control sm-input berat-titipan-diterima"
                        id="weight_received_titipan_${rowTitipan}" name="weight_received[]"
                        placeholder="Berat">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Lokasi</label>
                    <select class="form-control sm-input" id="location_titipan_${rowTitipan}"
                        name="location[]">
                      
                        ${locationOptions}
                    </select>

                </div>
            </div>
            <button type="button" class="btn btn-hapus-row2"
                onclick="hapusBarisTitipan(${rowTitipan})" title="Hapus baris">
                <i class="fa fa-remove"></i>
            </button>
            <button type="button" class="btn btn-tambah-row2"
                onclick="tambahBarisTitipan(${rowTitipan})" title="tambah/copy data produk">
                <i class="fa fa-plus"></i>
            </button>

        </div>`;


        $("#product_titipan").append(HTML);
        rowTitipan++;
    }







    function viewData(id) {

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
                HTML += '<td width="*">' + formatTanggal(data.gr.due_date) + '</td>';
                HTML += '</tr>';


                HTML += '<tr>';
                HTML += '<td width="8%">NO PO</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.po_number + '</td>';
                HTML += '<td width="8%">ID Kontrak</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.gr.contract_number + '</td>';

                HTML += '<td width="15%">SP Number</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">'+data.gr.sp_number+'</td>';
                HTML += '</tr>';

                HTML += '<tr>';
                if (data.gr.good_status == 2) {
                    HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%"><strong>' +
                        data
                        .gr.customer.nama_lengkap + '</strong><br>' + data.gr.customer.alamat_tagihan +
                        '<br>' +
                        data.gr.customer.city.city_name + '<br>' + data.gr.customer.province
                        .province_name + ' ' + data.gr.customer.postal_code + '<br>' + data.gr.customer
                        .kontak_tagihan + '</td>';
                } else {
                    HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%"><strong>' +
                        data
                        .gr.vendor.vendor_name + '</strong><br>' + data.gr.vendor.alamat_tagihan + '<br>' +
                        data.gr.vendor.city.city_name + '<br>' + data.gr.vendor.province
                        .province_name + ' ' + data.gr.vendor.postal_code + '<br>' + data.gr.vendor
                        .kontak_tagihan + '</td>';
                }


                HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%"><strong>' +
                    data
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


                HTML += '<td style="vertical-align:top;" width="15%">Deskripsi</td>';
                HTML += '<td style="vertical-align:top;" width="2%">:</td>';
                HTML += '<td style="vertical-align:top;" width="*">' + data.gr.description + '</td>';
                HTML += '</tr>';


                HTML += '<tr>';
                HTML += '<td width="8%">Nomor Pajak</td>';
                HTML += '<td width="2%">:</td>';
                if (data.gr.good_status == 2) {
                    HTML += '<td width="*">' + data.gr.customer.npwp + '</td>';
                    HTML += '<td width="8%">Nomor Pajak</td>';
                    HTML += '<td width="2%">:</td>';
                    HTML += '<td width="*">' + data.gr.customer.npwp + '</td>';
                } else {
                    HTML += '<td width="*">' + data.gr.vendor.npwp + '</td>';
                    HTML += '<td width="8%">Nomor Pajak</td>';
                    HTML += '<td width="2%">:</td>';
                    HTML += '<td width="*">' + data.gr.vendor.npwp + '</td>';
                }


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
                
                HTML += '<th>Tgl Kirim</th>';
                HTML += '<th>Tgl Datang</th>';
                HTML += '<th>Nomor Coil</th>';
                HTML += '<th>Nama Spek</th>';
                HTML += '<th>Tebal</th>';
                HTML += '<th>Lebar</th>';
                HTML += '<th>Panjang</th>';
                HTML += '<th>Quantity</th>';
                HTML += '<th>Satuan</th>';
                HTML += '<th>Berat</th>';
                HTML += '<th>Berat Received</th>';
                HTML += '<th>Lokasi</th>';
                HTML += '</tr>';

                for (var i = 0; i < data.gr.item.length; i++) {
                    HTML += '<tr>';
                    
                    HTML += '<td>' + data.gr.item[i].delivery_date + '</td>';
                    HTML += '<td>' + data.gr.item[i].arrive_date + '</td>';
                    HTML += '<td>' + data.gr.item[i].coil_number + '</td>';
                    HTML += '<td>' + data.gr.item[i].product.product_name + '</td>';
                    HTML += '<td>' + data.gr.item[i].tebal + '</td>';
                    HTML += '<td>' + data.gr.item[i].lebar + '</td>';
                    HTML += '<td>' + data.gr.item[i].panjang + '</td>';
                    HTML += '<td>' + data.gr.item[i].quantity_received + '</td>';
                    HTML += '<td>' + data.gr.item[i].satuan + '</td>';
                    HTML += '<td>' + ribuan(data.gr.item[i].weight) + '</td>';
                    HTML += '<td>' + ribuan(data.gr.item[i].weight_received) + '</td>';
                    HTML += '<td>' + data.gr.item[i].location + '</td>';
                    HTML += '</tr>';
                }

                HTML += '<tr>';
                HTML += '<th colspan="10"></th>';
                HTML += '<th>Total Berat</th>';
                HTML += '<th>' + ribuan(data.gr.total_weight) + '</th>';
                HTML += '</tr>';
                HTML += '<tr>';
                HTML += '<th colspan="10"></th>';
                HTML += '<th>Total Berat Diterima</th>';
                HTML += '<th>' + ribuan(data.gr.total_weight_received) + '</th>';
                HTML += '</tr>';
                HTML += '<tr>';
                HTML += '<th colspan="10"></th>';
                HTML += '<th>Total Berat Outstanding</th>';
                HTML += '<th>' + ribuan(data.gr.total_weight_outstanding) + '</th>';
                HTML += '</tr>';

                HTML += '</table>';
                HTML += '</div>';
                HTML += '</div>';

                $("#modal-view-content").html(HTML);
                if (data.gr.good_status == 2) {
                    $(".modal-title").text('Detail Penerimaan Barang Titipan');
                } else {
                    $(".modal-title").text('Detail Penerimaan Barang Masuk');
                }
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
        $("#sp_number").val("");

        $("#product_items").html('<center>Belum ada daftar produk</center>');
    }





    function show_items(data, save_index) {
        rowIndex = 1;

        var HTML = '';
        for (var i = 0; i < data.item.length; i++) {


            let locationOptions = `
            <option value="" ${!data.item[i].location ? 'selected' : ''}>
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
                        <label>Tgl Kirim</label>
                        <input value="${ save_index == 'edit' ? data.item[i].id :''}" type="hidden" id="gr_id_item_${rowIndex}" name="gr_id_item[]">
                        <input value="${ save_index == 'edit' ? data.item[i].po_item_id : data.item[i].id}" type="hidden" id="good_id_item_${rowIndex}" name="good_id_item[]">
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

                <div class="col-2 col-custom">
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
                        <label>Quantity</label>
                        <input value="${data.item[i].quantity_received}" type="number" class="form-control sm-input"
                            id="quantity_received_${rowIndex}" name="quantity_received[]">

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
                           
                            ${locationOptions}
                        </select>

                    </div>
                </div>
                <button type="button" class="btn btn-hapus-row2"
                    onclick="hapusBaris(${rowIndex})" title="Hapus baris">
                    <i class="fa fa-remove"></i>
                </button>
                <button type="button" class="btn btn-tambah-row2"
                    onclick="tambahBaris(${rowIndex})" title="tambah/copy data produk">
                    <i class="fa fa-plus"></i>
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
        var edit_id = $("#gr_id_item_" + index).val();
        var add_id = $("#good_id_item_" + index).val();

        var item_id = save_index == 'edit' ? edit_id : add_id;


        hitung_total_berat();
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



    function hitung_total_berat_titipan() {
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



    function hitung_total_berat_titipan() {

        let total_berat_diterima = 0;
        $(".berat-titipan-diterima").each(function() {
            var terima = Number($(this).val()) || 0;
            total_berat_diterima = total_berat_diterima + terima;
        });

        $("#titipan_total_weight").val(ribuan(total_berat_diterima));
        $("#titipan_total_weight_received").val(ribuan(total_berat_diterima));



        $("#titipan_total_weight_outstanding").val(0);

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




    function hapusBarisTitipan(index) {
        if (index == 1) {
            Swal.fire({
                icon: "warning",
                title: "",
                text: 'Baris pertama tidak boleh dihapus',
                footer: ''
            });
        } else {
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

                    let $row = $("#row_titipan_" + index);

                    if ($row.length) { // pastikan row ada
                        $row.fadeOut(200, function() {

                            $(this).remove();

                            // Cek dulu apakah fungsi hitung_subtotal ada
                            if (typeof hitung_total_berat_titipan === "function") {
                                try {
                                    hitung_total_berat_titipan();
                                } catch (err) {
                                    console.error("Error saat hitung_total_berat_titipan:", err);
                                }
                            }
                        });
                    }


                }
            });
        }


    }



    function tambahBaris(index) {
        Swal.fire({
            icon: 'question',
            title: 'Tambah data ini?',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tambah',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                init_tambah_baris(index);
            }
        });
    }


    function init_tambah_baris(index) {

        var good_id_item = $("#good_id_item_" + index).val();
        var product_name = $("#product_name_" + index).val();
        var product_id = $("#product_id_" + index).val();
        var tebal = $("#tebal_" + index).val();
        var lebar = $("#lebar_" + index).val();
        var panjang = $("#panjang_" + index).val();
        var quantity_received = $("#quantity_received_" + index).val();
        var quantity = 0;
        var satuan = $("#satuan_" + index).val();
        var weight = 0;



        var HTML = '';

        let locationOptions = `
        <option value="">
            Pilih Lokasi
        </option>`;

        // loop untuk setiap pajak yang sudah dikirim dari server
        for (let t = 0; t < locationList.length; t++) {
            const loc = locationList[t];
            locationOptions += `<option value="${loc.location_name}">${loc.location_name}</option>`;
        }


        // <input value="${ save_index == 'edit' ? data.item[i].id: ''}" type="hidden" id="gr_item_id_${rowIndex}" name="gr_item_id[]">

        HTML += `<div id="row_${rowIndex}" class="row">
            
            <div class="col-1">
                <div class="form-group">
                    <input type="hidden" id="gr_id_item_${rowIndex}" name="gr_id_item[]">
                    <input value="${good_id_item}" type="hidden" id="good_id_item_${rowIndex}" name="good_id_item[]">
                    <label>Tgl Kirim</label>
                    <input type="date" class="form-control sm-input"
                        id="delivery_date_${rowIndex}" name="delivery_date[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Tgl Datang</label>
                    <input type="date" class="form-control sm-input"
                        id="arrive_date_${rowIndex}" name="arrive_date[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Nomor Coil</label>
                    <input type="text" class="form-control sm-input"
                        id="coil_number_${rowIndex}" name="coil_number[]">
                </div>
            </div>

            <div class="col-2 col-custom">
                <div class="form-group">
                    <label>Spec</label>
                    <input value="${product_name}" readonly type="text" class="form-control sm-input"
                        id="product_name_${rowIndex}" name="product_name[]">
                    <input value="${product_id}" type="hidden" id="product_id_${rowIndex}" name="product_id[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Tebal</label>
                    <input value="${tebal}" readonly type="text" class="form-control sm-input"
                        id="tebal_${rowIndex}" name="tebal[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Lebar</label>
                    <input value="${lebar}" readonly type="text" class="form-control sm-input"
                        id="lebar_${rowIndex}" name="lebar[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Panjang</label>
                    <input value="${panjang}" readonly type="text" class="form-control sm-input"
                        id="panjang_${rowIndex}" name="panjang[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Quantity</label>
                    <input value="${quantity_received}" type="number" class="form-control sm-input"
                        id="quantity_received_${rowIndex}" name="quantity_received[]">

                </div>
            </div>
            
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Satuan</label>
                    <input value="${satuan}" readonly type="text" class="form-control sm-input"
                        id="satuan_${rowIndex}" name="satuan[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Berat</label>
                    <input value="${weight}" readonly type="text" class="form-control sm-input berat-order"
                        id="weight_${rowIndex}" name="weight[]">

                </div>
            </div>
            <div class="col-2 col-custom">
                <div class="form-group">
                    <label>Received</label>
                    <input onkeyup="weight_receive_onchange(${rowIndex}, this)" type="number" class="form-control sm-input berat-diterima"
                        id="weight_received_${rowIndex}" name="weight_received[]"
                        placeholder="Berat">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Lokasi</label>
                    <select class="form-control sm-input" id="location_${rowIndex}"
                        name="location[]">
                       
                        ${locationOptions}
                    </select>

                </div>
            </div>
            <button type="button" class="btn btn-hapus-row2"
                onclick="hapusBaris(${rowIndex})" title="Hapus baris">
                <i class="fa fa-remove"></i>
            </button>
            <button disabled type="button" class="btn btn-tambah-row2"
                onclick="tambahBaris(${rowIndex})" title="tambah/copy data produk">
                <i class="fa fa-plus"></i>
            </button>

        </div>`;

        $("#product_items").append(HTML);
        rowIndex++;
    }




    function init_titipan_item(actions = null) {

        if (actions == 1) {

        } else {
            rowTitipan = 1;
        }

        var HTML = '';

        let locationOptions = `
        <option value="">
            Pilih Lokasi
        </option>`;

        // loop untuk setiap pajak yang sudah dikirim dari server
        for (let t = 0; t < locationList.length; t++) {
            const loc = locationList[t];
            locationOptions += `<option value="${loc.location_name}">${loc.location_name}</option>`;
        }


        // <input value="${ save_index == 'edit' ? data.item[i].id: ''}" type="hidden" id="gr_item_id_${rowIndex}" name="gr_item_id[]">

        HTML += `<div id="row_titipan_${rowTitipan}" class="row">
            
            <div class="col-1">
                <div class="form-group">
                    <label>Tgl Kirim</label>
                    <input type="hidden" id="gr_id_item_titipan_${rowTitipan}" name="gr_id_item[]">
                    <input type="hidden" id="good_id_item_titipan_${rowTitipan}" name="good_id_item[]">
                    <input type="date" class="form-control sm-input"
                        id="delivery_date_titipan_${rowTitipan}" name="delivery_date[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Tgl Datang</label>
                    <input type="date" class="form-control sm-input"
                        id="arrive_date_titipan_${rowTitipan}" name="arrive_date[]">
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Nomor Coil</label>
                    <input type="text" class="form-control sm-input"
                        id="coil_number_titipan_${rowTitipan}" name="coil_number[]">
                </div>
            </div>

            <div class="col-3 col-custom">
                <div class="form-group">
                    <label>Spec</label>
                    <select onchange="selected_product(${rowTitipan})" class="form-control sm-input product-id"
                        id="product_id_titipan_${rowTitipan}" name="product_id[]">
                        <option value="">Pilih Spec</option>
                    </select>
                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Tebal</label>
                    <input readonly type="text" class="form-control sm-input"
                        id="tebal_titipan_${rowTitipan}" name="tebal[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Lebar</label>
                    <input readonly type="text" class="form-control sm-input"
                        id="lebar_titipan_${rowTitipan}" name="lebar[]">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Panjang</label>
                    <input readonly type="text" class="form-control sm-input"
                        id="panjang_titipan_${rowTitipan}" name="panjang[]">

                </div>
            </div>

            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control sm-input"
                        id="quantity_received_titipan_${rowTitipan}" name="quantity_received[]">

                </div>
            </div>
            
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Satuan</label>
                    <input readonly type="text" class="form-control sm-input"
                        id="satuan_titipan_${rowTitipan}" name="satuan[]">

                </div>
            </div>
            <div class="col-2 col-custom">
                <div class="form-group">
                    <label>Received</label>
                    <input onkeyup="weight_titipan_onchange(${rowTitipan}, this)" type="number" class="form-control sm-input berat-titipan-diterima"
                        id="weight_received_titipan_${rowTitipan}" name="weight_received[]"
                        placeholder="Berat">

                </div>
            </div>
            <div class="col-1 col-custom">
                <div class="form-group">
                    <label>Lokasi</label>
                    <select class="form-control sm-input" id="location_titipan_${rowTitipan}"
                        name="location[]">
                       
                        ${locationOptions}
                    </select>

                </div>
            </div>
            <button type="button" class="btn btn-hapus-row2"
                onclick="hapusBarisTitipan(${rowTitipan})" title="Hapus baris">
                <i class="fa fa-remove"></i>
            </button>
            <button type="button" class="btn btn-tambah-row2"
                onclick="tambahBarisTitipan(${rowTitipan})" title="tambah/copy data produk">
                <i class="fa fa-plus"></i>
            </button>

        </div>`;


        if (actions == 1) {
            $("#product_titipan").append(HTML);
            var optionList = $('#product_id_titipan_1 option:not(:first)').clone();

            $('#product_id_titipan_' + rowTitipan).not('#product_id_titipan_1').append(optionList);

        } else {
            $("#product_titipan").html(HTML);
        }

        rowTitipan++;
    }


    function weight_titipan_onchange(index, el) {
        var berat = $(el).val();
        var edit_id = $("#gr_id_item_titipan_" + index).val();
        var add_id = $("#good_id_item_titipan_" + index).val();

        var item_id = save_index == 'edit' ? edit_id : add_id;

        hitung_total_berat_titipan();
    }

    function selected_product(id) {
        var product_id = $("#product_id_titipan_" + id).val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('selected.product') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "product_id": product_id,
                "_token": csrf_token
            },
            success: function(data) {
                $("#tebal_titipan_" + id).val(data.tebal);
                $("#lebar_titipan_" + id).val(data.lebar);
                $("#panjang_titipan_" + id).val(data.panjang);
                $("#satuan_titipan_" + id).val(data.satuan);


            }
        })
    }


    function tambahBarisTitipan(id) {
        init_titipan_item(1);
    }


    $("#titipan_product_category").change(function() {
        var category = $(this).val();
        actions = 'add'
        get_product_list_by_category(category, actions);
    });


    function get_product_list_by_category(category, actions, callback) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('product.category') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "category": category,
                "_token": csrf_token
            },
            success: function(data) {
                var HTML = '';
                HTML += '<option value="" selected disabled>Pilih Spec</option>';
                for (var i = 0; i < data.length; i++) {
                    HTML += '<option value="' + data[i].id + '">' + data[i].product_name + ' (' + data[i]
                        .lebar + ' x ' + data[i].tebal + ' x ' + data[i].panjang + ') </option>';
                }

                $(".product-id").html(HTML);

                if (typeof callback === "function") {
                    callback();
                }

            }
        });
    }



    $("#customer_id").change(function() {
        var customer_id = $(this).val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('customer.detail') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "cust_id": customer_id,
                "_token": csrf_token
            },
            success: function(data) {


                var cust = '';
                cust += '<strong>' + data.nama_lengkap + '</strong><br>';
                cust += data.alamat_tagihan + '<br>';
                cust += data.city.city_name + ', ' + data.province
                    .province_name + ' ' + data.postal_code + '<br>';
                cust += 'Indonesia <br>';
                cust += data.kontak_tagihan + '<br>';
                cust += '<strong>Nomor Pajak : </strong>' + data.npwp + '<br>';
                $("#customer_note").html(cust);
            }
        })

    });



    $("#titipan_warehouse_id").change(function() {
        var whs_id = $(this).val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('warehouse.detail') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "whs_id": whs_id,
                "_token": csrf_token
            },
            success: function(data) {


                var cust = '';
                cust += '<strong>' + data.name + '</strong><br>';
                cust += data.address + '<br>';
                cust += data.rcity.city_name + ', ' + data.rprovince
                    .province_name + ' ' + data.postal_code + '<br>';
                cust += 'Indonesia <br>';
                cust += data.contact + '<br>';

                $("#warehouse_note").html(cust);
            }
        })

    });



    $("#form-titipan").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#titipan_id').val();
        if (save_method == "add") url = "{{ route('titipan.add') }}";
        else url = "{{ route('good.titipan.edit') }}";
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-titipan form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                unloading();
                if (data.success) {
                    $('#modal-titipan').modal('hide');
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
</script>
