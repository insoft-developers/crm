<!-- JAVASCRIPT -->
<script>
    const locationList = @json($locations);
    let rowIndex = 1;

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
        var id = $(this).val();

        if (id == null) {

        } else {
            $.ajax({
                url: "{{ route('po.data.serve') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id": id,
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
                    whs += data.po.gudang.name + '<br>';
                    whs += data.po.gudang.address + '<br>';
                    whs += data.po.gudang.rcity.city_name + ', ' + data.po.gudang.rprovince
                        .province_name + ' ' + data.po.gudang.postal_code + '<br>';
                    whs += 'Indonesia <br>';
                    whs += data.po.gudang.contact + '<br>';
                    // whs += '<strong>Nomor Pajak : </strong>'+data.po.gudang.npwp+'<br>';
                    $("#warehouse_id").html(whs);

                    var jatuh_tempo = hitungJatuhTempo(data.po.purchase_order_date, data.po
                        .payment_methods.term_days);
                    $("#due_date").text(jatuh_tempo);

                    $("#payment_method").text(data.po.payment_methods.code);
                    $("#product_category").text(data.po.product_category);
                    $("#mills").text(data.po.mill);
                    $("#delivery_method").text(data.po.delivery_methods.name);
                    $("#description").text(data.po.description);

                    $("#status").text("Outstanding");

                    show_items(data.po);




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

        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/good_receive') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Penerimaan Barang Masuk");
                $("#gr_number").val(data.gr_number);
                get_po_data(data.po_id);
                $("#gr_date").val(data.gr_date);
                $("#contract_number").val(data.contract_number);
                


            }
        })
    }



    function viewData(id) {
        $(".modal-title").text('Detail Pembelian Barang');
        $("#purchase_id_show").val(id);
        $.ajax({
            url: "{{ url('purchase_order') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);

                var HTML = '';
                HTML += '<div class="card">';
                HTML += '<div class="card-body">';
                HTML += '<table class="table-compact">';
                HTML += '<tr>';
                HTML += '<td width="8%">NO PO</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.purchase_order_number + '</td>';
                HTML += '<td width="8%">Tanggal Pesan</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + formatTanggal(data.purchase.purchase_order_date) + '</td>';

                HTML += '<td width="15%">Tanggal Jatuh Tempo</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + hitungJatuhTempo(data.purchase.purchase_order_date, data.purchase
                    .payment_method.term_days) + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';
                HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%">' + data
                    .purchase.vendor.vendor_name + '<br>' + data.purchase.vendor.alamat_tagihan + '<br>' +
                    data.purchase.vendor.city.city_name + '<br>' + data.purchase.vendor.province
                    .province_name + ' ' + data.purchase.vendor.postal_code + '<br>' + data.purchase.vendor
                    .kontak_tagihan + '</td>';

                HTML += '<td style="vertical-align: top;" rowspan="5" colspan="3" width="8%">' + data
                    .purchase.gudang.name + '<br>' + data.purchase.gudang.address + '<br>' + data.purchase
                    .gudang.rcity.city_name + '<br>' + data.purchase.gudang.rprovince.province_name + ' ' +
                    data.purchase.gudang.postal_code + '<br>' + data.purchase.gudang.contact + '</td>';

                HTML += '<td width="15%">Kategori</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.product_category + '</td>';
                HTML += '</tr>';



                HTML += '<tr>';

                HTML += '<td width="15%">Metode Pembayaran</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.payment_methods.code + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';


                HTML += '<td width="15%">Mill</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.mill + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';


                HTML += '<td width="15%">Metode Pengiriman</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.delivery_methods.name + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';


                HTML += '<td width="15%">Deskripsi</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.description + '</td>';
                HTML += '</tr>';


                HTML += '<tr>';
                HTML += '<td width="8%">Nomor Pajak</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.vendor.npwp + '</td>';
                HTML += '<td width="8%">Nomor Pajak</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.vendor.npwp + '</td>';

                HTML += '<td width="15%">Status</td>';
                HTML += '<td width="2%">:</td>';

                if (data.purchase.status == 1) {
                    HTML += '<td width="*"><div class="text-info">Draft</div></td>';
                } else if (data.purchase.status == 2) {
                    HTML += '<td width="*"><div class="text-warning">Pengajuan</div></td>';
                } else if (data.purchase.status == 3) {
                    HTML += '<td width="*"><div class="text-success">Disetujui</div></td>';
                } else if (data.purchase.status == 4) {
                    HTML += '<td width="*"><div class="text-danger">Ditolak</div></td>';
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
                HTML += '<th>Nama Spek</th>';
                HTML += '<th>Tebal</th>';
                HTML += '<th>Lebar</th>';
                HTML += '<th>Panjang</th>';
                HTML += '<th>Kuantitas Jumlah</th>';
                HTML += '<th>Kuantitas Berat</th>';
                HTML += '<th>Satuan</th>';
                HTML += '<th>Harga</th>';
                HTML += '<th>Pajak</th>';
                HTML += '<th>Jumlah Sebelum Pajak</th>';
                HTML += '</tr>';

                for (var i = 0; i < data.item.length; i++) {
                    HTML += '<tr>';
                    HTML += '<td>' + data.item[i].product.product_name + '</td>';
                    HTML += '<td>' + data.item[i].tebal + '</td>';
                    HTML += '<td>' + data.item[i].lebar + '</td>';
                    HTML += '<td>' + data.item[i].panjang + '</td>';
                    HTML += '<td>' + ribuan(data.item[i].quantity) + '</td>';
                    HTML += '<td>' + ribuan(data.item[i].weight) + '</td>';
                    HTML += '<td>' + data.item[i].satuan + '</td>';
                    HTML += '<td>' + ribuan(data.item[i].price) + '</td>';
                    HTML += '<td>PPN ' + data.item[i].tax + '%</td>';
                    HTML += '<td>' + ribuan(data.item[i].price_before_tax) + '</td>';
                    HTML += '</tr>';
                }

                HTML += '<tr>';
                HTML += '<th colspan="8"></th>';
                HTML += '<th>Subtotal</th>';
                HTML += '<th>' + ribuan(data.purchase.subtotal) + '</th>';
                HTML += '</tr>';
                HTML += '<tr>';
                HTML += '<th colspan="8"></th>';
                HTML += '<th>Pajak</th>';
                HTML += '<th>' + ribuan(data.purchase.total_tax) + '</th>';
                HTML += '</tr>';
                HTML += '<tr>';
                HTML += '<th colspan="8"></th>';
                HTML += '<th>Jumlah Total</th>';
                HTML += '<th>' + ribuan(data.purchase.total_price) + '</th>';
                HTML += '</tr>';

                HTML += '<tr>';
                HTML += '<th colspan="8"></th>';
                HTML += '<th>Jumlah Tagihan</th>';
                HTML += '<th>' + ribuan(data.purchase.total_price) + '</th>';
                HTML += '</tr>';

                HTML += '</table>';
                HTML += '</div>';
                HTML += '</div>';

                $("#modal-view-content").html(HTML);


                $("#btn-approve-data").hide();
                $("#btn-reject-data").hide();
                $("#btn-propose-data").hide();

                if (data.purchase.status == 1) {
                    if (data.purchase.request_user_id == data.user.id) {
                        $("#btn-propose-data").show();
                    }
                } else if (data.purchase.status == 2) {
                    if (data.user.approve_1 === 1) {
                        $("#btn-approve-data").show();
                        $("#btn-reject-data").show();
                    }
                } else if (data.purchase.status == 3) {
                    if (data.user.approve_2 === 1 && data.purchase.is_approve_2 === null) {
                        $("#btn-approve-data").show();
                        $("#btn-reject-data").show();
                    }
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





    function show_items(data, mode) {

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
                const selected = Number(data.item[i].location) === Number(loc.location_name) ? 'selected' : '';
                locationOptions += `<option value="${loc.location_name}" ${selected}>${loc.location_name}</option>`;
            }


            HTML += `<div id="row_${rowIndex}" class="row">
                <div class="col-1">
                    <div class="form-group">
                        <label>Nomor SP</label>
                        <input value="${data.item[i].id}" type="hidden" id="good_id_item_${rowIndex}" name="good_id_item[]">
                        <input type="text" class="form-control sm-input"
                            id="sp_number_${rowIndex}" name="sp_number[]">
                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
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
                        <input value="${ribuan(data.item[i].quantity_outstanding)}" readonly type="number" class="form-control sm-input"
                            id="quantity_${rowIndex}" name="quantity[]">

                    </div>
                </div>
                <div class="col-1 col-custom">
                    <div class="form-group">
                        <label>Received</label>
                        <input type="number" class="form-control sm-input"
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
                        <input value="${ribuan(data.item[i].weight_outstanding)}" readonly type="text" class="form-control sm-input berat-order"
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
        var item_id = $("#good_id_item_" + index).val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('weight.receive.change') }}",
            type: "POST",
            dataType: "JSON",
            data: {
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
