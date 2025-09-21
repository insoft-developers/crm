<!-- JAVASCRIPT -->
<script>
    const taxList = @json($taxes);


    $(".select2").select2({
        theme: 'bootstrap-3', // optional jika pakai tema bootstrap
        dropdownParent: $('#modal-add'), // 🔑 kunci agar muncul di dalam modal
        width: '100%'
    });


    function get_pr_data() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('get.pr.data') }}",
            type: "POST",
            data: {
                "_token": csrf_token
            },
            success: function(data) {
                console.log(data);
                var HTML = '';
                HTML += '<option value="">Pilih Nomor PR </option>';
                for (var i = 0; i < data.length; i++) {
                    HTML += '<option value="' + data[i].id + '">' + data[i].pr_number + '</option>';
                }

                $("#purchase_request_id").html(HTML);


            }
        });
    }

    function qty_change(id, el, mode) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var qty = $(el).val();
        var pr_item_id = $("#pr_item_id_" + id).val();
        var price = $("#price_" + id).val();
        price = price ? price : 0;
        var pt = $("#price_type_" + id).val();
        var po_id = $("#id").val();
        $.ajax({
            url: "{{ route('check.pr.quantity') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "qty": qty,
                "pr_item_id": pr_item_id,
                "mode": mode,
                "po_id": po_id,
                "_token": csrf_token
            },
            success: function(data) {
                if (data.success) {
                    console.log(data);
                    hitung_price_before_tax(id, qty, price, data.weight, pt);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                    $("#quantity_" + id).val(data.data);
                    hitung_price_before_tax(id, data.data, price, data.weight, pt);
                }
            }
        })
    }


    function weight_change(id, el, mode) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var berat = $(el).val();
        var pr_item_id = $("#pr_item_id_" + id).val();
        var price = $("#price_" + id).val();
        var qty = $("#quantity_" + id).val();
        price = price ? price : 0;
        var pt = $("#price_type_" + id).val();
        var po_id = $("#id").val();
        $.ajax({
            url: "{{ route('check.pr.weight') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "qty": qty,
                "berat": berat,
                "pr_item_id": pr_item_id,
                "mode": mode,
                "po_id": po_id,
                "_token": csrf_token
            },
            success: function(data) {
                if (data.success) {
                    console.log(data);
                    hitung_price_before_tax(id, qty, price, data.weight, pt);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                    $("#quantity_" + id).val(data.data);
                    hitung_price_before_tax(id, data.data, price, data.weight, pt, 1);
                }
            }
        })
    }


    function hitung_price_before_tax(i, qty, price, w, pt, er = null) {
        console.log(w);
        if (pt == 1) {
            var price_before_tax = w * price;
            $("#price_before_tax_" + i).val(ribuan(price_before_tax));
            if (er == 1) {
                $("#weight_" + i).val(w);
            }

        } else {
            var price_before_tax = qty * price;
            $("#price_before_tax_" + i).val(ribuan(price_before_tax));
            if (er == 1) {
                $("#weight_" + i).val(w);
            }
        }
        hitung_subtotal();

    }

    function generate_po_number() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('generate.po.number') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "_token": csrf_token
            },
            success: function(data) {
                $("#purchase_order_number").val(data.purchase_order_number);
            }

        });
    }


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
            url: '{{ route('purchase.order.table') }}',
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
                data: 'purchase_order_number',
                name: 'purchase_order_number'
            },
            {
                data: 'vendor_id',
                name: 'vendor_id'
            },

            {
                data: 'purchase_order_date',
                name: 'purchase_order_date'
            },
            {
                data: 'request_user_id',
                name: 'request_user_id'
            },
            {
                data: 'gudang',
                name: 'gudang'
            },
            {
                data: 'mill',
                name: 'mill'
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
        get_pr_data();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Tambah Pembelian Barang");
        $("#modal-add").modal("show");
        generate_po_number();
        unloading();
        $("#purchase_request_id").removeClass('readonly-select');
        $("#btn-proses-data").removeAttr("disabled");

    }

    $("#form-purchase-order").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/purchase_order') }}";
        else url = "{{ url('/purchase_order') . '/' }}" + id;
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
            url: "{{ url('/purchase_order') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Pembelian Barang");
                $('#id').val(data.purchase.id);
                $("#purchase_request_id").val(data.purchase.purchase_request_id);
                $("#purchase_request_id").addClass('readonly-select');
                $("#btn-proses-data").attr("disabled", true);
                $("#purchase_request_number").val(data.purchase.purchase_request_number);
                $("#purchase_order_number").val(data.purchase.purchase_order_number);
                $("#purchase_order_date").val(data.purchase.purchase_order_date);
                $("#mill").val(data.purchase.mill);
                $("#product_category").val(data.purchase.product_category);
                $("#payment_method").val(data.purchase.payment_method);
                $("#delivery_method").val(data.purchase.delivery_method);
                $("#description").val(data.purchase.description);
                // set vendor_id dulu
                $("#vendor_id")
                    .val(data.purchase.vendor_id)
                    .trigger("change");

                // kasih jeda supaya ajax isi data selesai dulu
                setTimeout(function() {
                    $("#vendor_address_id")
                        .val(data.purchase.vendor_address_id)
                        .trigger("change");
                }, 1000); // 300ms bisa disesuaikan
                $("#subtotal").val(ribuan(data.purchase.subtotal));
                $("#total_tax").val(ribuan(data.purchase.total_tax));
                $("#total_price").val(ribuan(data.purchase.total_price));
                show_items(data, 1);


            }
        })
    }



    $("#btn-approve-data").click(function() {
        var id = $("#purchase_id_show").val();
        Swal.fire({
            icon: 'question',
            title: 'Setujui data ini?',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('purchase.order.approve') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTable();
                        $("#modal-view").modal("hide");
                    }
                });
            }
        });
    });


    $("#btn-reject-data").click(function() {
        var id = $("#purchase_id_show").val(); // ambil ID PR
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $("#modal-view").modal("hide");

        Swal.fire({
            title: 'Revisi Pembelian Barang?',
            input: 'textarea',
            inputLabel: 'Alasan Revisi',
            inputPlaceholder: 'Tuliskan alasan di sini...',
            inputValue: '',
            showCancelButton: true,
            confirmButtonText: 'Revisi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            zIndex: 2000,
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('Alasan wajib diisi!');
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('purchase.order.reject') }}",
                    type: "POST",
                    data: {
                        id: id,
                        reason: result.value, // alasan penolakan dari swal
                        _token: csrf_token
                    },
                    success: function(data) {
                        Swal.fire('Revisi!', 'Data berhasil disimpan.', 'success');
                        reloadTable();
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal simpan data.', 'error');
                    }
                });
            }
        });
    });


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

                if(data.purchase.status == 1) {
                    if(data.purchase.request_user_id == data.user.id) {
                        $("#btn-propose-data").show();
                    }
                }
                else if(data.purchase.status == 2) {
                    if(data.user.approve_1 === 1) { 
                        $("#btn-approve-data").show();
                        $("#btn-reject-data").show();
                    }
                }
                else if(data.purchase.status == 3) {
                    if(data.user.approve_2 === 1 && data.purchase.is_approve_2 === null) { 
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
        $("#purchase_request_id").val("").trigger('change');
        $("#purchase_request_number").val("");
        $("#vendor_id").val("");
        $("#vendor_address_id").val("");
        $("#vendor-note").html('');
        $("#vendor-address-note").html('');
        $("#product_category").val("");
        $("#payment_method").val("");
        $("#delivery_method").val("");
        $("#description").val("");
        $("#subtotal").val("");
        $("#total_tax").val("");
        $("#total_price").val("");
        $("#purchase_order_date").val("");
        $("#product_items").html('<center>Belum ada daftar produk</center>');
    }


    function view_rejection_note(id) {
        $(".modal-title").text('Alasan Revisi Pembelian Barang');
        $.ajax({
            url: "{{ url('purchase_order') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                
                var note = data.purchase.rejection_note_1 === null ? data.purchase.rejection_note_2 : $data.purchase.rejection_note_1;
                
                var HTML = '';


                HTML += '<div class="form-group">';
                HTML += '<label>Alasan Revisi</label>';
                HTML += '<textarea readonly class="form-control">' + note +
                    '</textarea>';
                HTML += '</div>';
                $("#modal-reason-content").html(HTML);
                $("#modal-reason").modal("show");

            }
        })
    }

    $("#vendor_id").change(function() {
        var vendor_id = $(this).val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('vendor.note') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "vendor_id": vendor_id,
                "_token": csrf_token
            },
            success: function(data) {
                console.log(data);
                var HTML = '';
                HTML += '<p>';
                HTML += data.vendor_name + '<br>';
                HTML += data.kontak_tagihan + '<br>';
                HTML += data.alamat_tagihan + '<br>';
                HTML += 'Indonesia, ' + data.city.city_name + ', ';
                HTML += data.province.province_name + ', ';

                HTML += '</p>';
                $("#vendor-note").html(HTML);
            }
        })
    });


    $("#vendor_address_id").change(function() {
        var vai = $(this).val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('vendor.address') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "id": vai,
                "_token": csrf_token
            },
            success: function(data) {
                console.log(data);
                var HTML = '';
                HTML += '<p>';
                HTML += data.name + '<br>';
                HTML += data.contact + '<br>';
                HTML += data.address + '<br>';
                HTML += 'Indonesia, ' + data.rcity.city_name + ', ';
                HTML += data.rprovince.province_name + ', ';

                HTML += '</p>';
                $("#vendor-address-note").html(HTML);
            }
        })
    })

    $("#btn-proses-data").click(function() {

        var pr_number = $("#purchase_request_id").val();
        if (pr_number == null) {
            Swal.fire({
                icon: "error",
                title: "",
                text: 'Maaf Nomor PR Harus Dipilih terlebih dahulu !',
                footer: ''
            });


        } else {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('purchase.request.data') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    "id": pr_number,
                    "_token": csrf_token
                },
                success: function(data) {
                    console.log(data);
                    $("#product_category").val(data.purchase.product_category);
                    show_items(data, 0);
                }
            })
        }
    });


    function show_items(data, mode) {
        var HTML = '';
        for (var i = 0; i < data.items.length; i++) {


            let taxOptions = `
            <option value="" disabled ${!data.items[i].tax ? 'selected' : ''}>
                Pilih Tax
            </option>`;

            // loop untuk setiap pajak yang sudah dikirim dari server
            for (let t = 0; t < taxList.length; t++) {
                const tax = taxList[t];
                const selected = Number(data.items[i].tax) === Number(tax.tax) ? 'selected' : '';
                taxOptions += `<option value="${tax.tax}" ${selected}>${tax.tax_name}</option>`;
            }


            HTML += `
            <div id="baris_${i}" class="row align-items-end" 
                style="margin-right:-5px; margin-left:-5px; margin-bottom:8px; border-bottom:1px solid #eee; padding-bottom:6px;">

                <div class="col-2" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group mb-2">
                        <label class="mb-1">Produk</label>
                        <input value="${mode==1 ? data.items[i].pr_item_id:data.items[i].id}" type="hidden" id="pr_item_id_${i}" name="pr_item_id[]">
                        <input value="${data.items[i].product.price_type}" type="hidden" id="price_type_${i}" name="price_type[]">
                        <input value="${data.items[i].product_id}" type="hidden" id="product_id_${i}" name="product_id[]">
                        <input type="text" value="${data.items[i].product.product_name}" class="form-control form-control-sm" id="product_name_${i}" readonly>
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Tebal</label>
                        <input value="${data.items[i].tebal}" readonly type="text" class="form-control form-control-sm"
                            id="tebal_${i}" name="tebal[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Lebar</label>
                        <input value="${data.items[i].lebar}" readonly type="text" class="form-control form-control-sm"
                            id="lebar_${i}" name="lebar[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Panjang</label>
                        <input value="${data.items[i].panjang}" readonly type="text" class="form-control form-control-sm"
                            id="panjang_${i}" name="panjang[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Qty</label>
                        <input value="${mode==1?data.items[i].quantity:data.items[i].quantity_outstanding}" onkeyup="qty_change(${i}, this, ${mode})" type="number"
                            class="form-control form-control-sm selected-qty" id="quantity_${i}" name="quantity[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Satuan</label>
                        <input value="${data.items[i].satuan}" readonly type="text" class="form-control form-control-sm"
                            id="satuan_${i}" name="satuan[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Berat (Kg)</label>
                        <input onkeyup="weight_change(${i}, this, ${mode})" value="${mode == 1 ? data.items[i].weight : data.items[i].weight_outstanding}" type="number" class="form-control form-control-sm"
                            id="weight_${i}" name="weight[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Harga</label>
                        <input value="${mode == 1 ? data.items[i].price : ''}" onkeyup="on_price_change(${i}, this)" type="number" class="form-control form-control-sm"
                            id="price_${i}" name="price[]">
                    </div>
                </div>

                <div class="col-1 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Tax</label>
                        <select onchange="on_tax_change(${i}, this)" class="form-control form-control-sm"
                            id="tax_${i}" name="tax[]">
                            <option value="" disabled ${!data.items[i].tax ? "selected" : ""}>Pilih Tax</option>
                            ${taxOptions}
                        </select>
                    </div>
                </div>

                <div class="col-2 px-1">
                    <div class="form-group mb-2">
                        <label class="mb-1">Jumlah Sebelum Pajak</label>
                        <input value="${mode == 1 ? ribuan(data.items[i].price_before_tax) : ''}" readonly type="text" class="form-control form-control-sm"
                            id="price_before_tax_${i}" name="price_before_tax[]">
                    </div>
                </div>

                <!-- Tombol hapus row di ujung kanan -->
                <div class="col-auto d-flex align-items-end justify-content-end">
                    <button type="button" class="btn btn-hapus-row"
                            onclick="hapusBaris(${i})" title="Hapus baris">
                        <i class="fa fa-remove"></i>
                    </button>

                </div>
            </div>`;
        }


        $("#product_items").html(HTML);
        Swal.fire({
            icon: "success",
            title: "",
            text: 'Data Produk Telah Tersedia',
            footer: ''
        });
    }


    function loadTaxOptions(i, selectedValue = null) {
        const $select = $(`#tax_${i}`);

        // kosongkan & tambahkan placeholder
        $select.empty().append(
            $('<option>', {
                value: '',
                text: 'Pilih Tax',
                disabled: true,
                selected: true
            })
        );

        // isi dari taxList yang sudah ada
        taxList.forEach(item => {
            const opt = $('<option>', {
                value: item.tax,
                text: item.tax_name
            });

            if (selectedValue !== null && Number(selectedValue) === Number(item.tax)) {
                opt.prop('selected', true);
            }
            $select.append(opt);
        });

        // kalau pakai select2:
        // $select.trigger('change');
    }


    function on_price_change(i, el) {
        var qty = $("#quantity_" + i).val();
        var price = $(el).val();
        var weight = $("#weight_" + i).val();
        var pt = $("#price_type_" + i).val();
        var wa = angka(weight);
        hitung_price_before_tax(i, qty, price, wa, pt);

    }

    function on_tax_change(i, el) {
        hitung_subtotal();
    }

    function hitung_subtotal() {
        let total = 0;
        let pajak = 0;

        $("input[id^='price_before_tax_']").each(function() {
            // Ambil index langsung dari ID
            let id = $(this).attr("id"); // contoh: price_before_tax_3
            let idx = id.split("_").pop(); // ambil angka terakhir → "3"

            let tax = $("#tax_" + idx).val();
            tax = tax ? parseFloat(tax) : 0;

            let price_before_tax = angka($(this).val());

            if (tax > 0) {
                let tpajak = (tax * price_before_tax) / 100;
                pajak += tpajak;
            }

            total += price_before_tax;
        });

        // tampilkan hasil format ribuan
        $("#subtotal").val(ribuan(total));
        $("#total_tax").val(ribuan(pajak));
        $("#total_price").val(ribuan(total + pajak));
    }



    $("#purchase_request_id").change(function() {
        var purchase_request_number = $("#purchase_request_id option:selected").text();
        $("#purchase_request_number").val(purchase_request_number);

    });

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

                let $row = $("#baris_" + index);

                if ($row.length) { // pastikan row ada
                    $row.fadeOut(200, function() {
                        $(this).remove();

                        // Cek dulu apakah fungsi hitung_subtotal ada
                        if (typeof hitung_subtotal === "function") {
                            try {
                                hitung_subtotal();
                            } catch (err) {
                                console.error("Error saat hitung_subtotal:", err);
                            }
                        }
                    });
                }


            }
        });

    }


    $("#btn-propose-data").click(function() {
        var id = $("#purchase_id_show").val();
        Swal.fire({
            icon: 'question',
            title: 'Ajukan data ini?',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ajukan',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('purchase.order.propose') }}",
                    type: "POST",
                    data: {
                        'id': id,
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTable();
                        $("#modal-view").modal("hide");
                    }
                });
            }
        });
    });
</script>
