<!-- JAVASCRIPT -->
<script>
    function qty_change(id, el) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var qty = $(el).val();
        var pr_item_id = $("#pr_item_id_" + id).val();
        var price = $("#price_" + id).val();
        price = price ? price : 0;
        var pt = $("#price_type_" + id).val();
        $.ajax({
            url: "{{ route('check.pr.quantity') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "qty": qty,
                "pr_item_id": pr_item_id,
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


    function hitung_price_before_tax(i, qty, price, w, pt) {
        console.log(w);
        if (pt == 1) {
            var price_before_tax = w * price;
            $("#price_before_tax_" + i).val(ribuan(price_before_tax));
            $("#weight_" + i).val(ribuan(w));
        } else {
            var price_before_tax = qty * price;
            $("#price_before_tax_" + i).val(ribuan(price_before_tax));
            $("#weight_" + i).val(ribuan(w));
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
                data: 'contract_number',
                name: 'contract_number'
            },
            {
                data: 'purchase_order_date',
                name: 'purchase_order_date'
            },
            {
                data: 'gudang',
                name: 'gudang'
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

        // reload datatable
        $('#table-list').DataTable().ajax.reload();
    });



    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Tambah Pembelian Barang");
        $("#modal-add").modal("show");
        generate_po_number();
        unloading();
    }

    $("#form-purchase-request").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/purchase_request') }}";
        else url = "{{ url('/purchase_request') . '/' }}" + id;
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
            url: "{{ url('/purchase_request') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Permintaan Barang");
                $('#id').val(data.purchase.id);
                $("#pr_number").val(data.purchase.pr_number);
                $("#request_date").val(data.purchase.request_date);
                $("#description").val(data.purchase.description);
                $("#product_category").val(data.purchase.product_category);
                init_edit_item(data);

            }
        })
    }



    function copyData(id) {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $.ajax({
            url: "{{ url('/purchase_request') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Copy Permintaan Barang");
                $('#id').val(data.purchase.id);
                $("#pr_number").val(data.purchase.pr_number);
                $("#request_date").val(data.purchase.request_date);
                $("#description").val(data.purchase.description);
                $("#product_category").val(data.purchase.product_category);
                init_edit_item(data);
                generate_po_number();

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
                    url: "{{ route('purchase.request.approve') }}",
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
            title: 'Tolak Permintaan Barang?',
            input: 'textarea',
            inputLabel: 'Alasan Penolakan',
            inputPlaceholder: 'Tuliskan alasan di sini...',
            inputValue: '',
            showCancelButton: true,
            confirmButtonText: 'Tolak',
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
                    url: "{{ route('purchase.request.reject') }}",
                    type: "POST",
                    data: {
                        id: id,
                        reason: result.value, // alasan penolakan dari swal
                        _token: csrf_token
                    },
                    success: function(data) {
                        Swal.fire('Ditolak!', 'Data berhasil ditolak.', 'success');
                        reloadTable();
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menolak data.', 'error');
                    }
                });
            }
        });
    });


    function deleteData(id) {
        Swal.fire({
            icon: 'question',
            title: 'Delete this data?',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('/product') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTable();
                    }
                });
            }
        });
    }

    function viewData(id) {
        $(".modal-title").text('Detail Permintaan Barang');
        $("#purchase_id_show").val(id);
        $.ajax({
            url: "{{ url('purchase_request') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);

                var HTML = '';
                HTML += '<div class="card">';
                HTML += '<div class="card-body">';
                HTML += '<table class="table-compact">';
                HTML += '<tr>';
                HTML += '<td width="20%">NO PR</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.pr_number + '</td>';
                HTML += '<td width="20%">Tanggal Pesan</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.request_date + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';
                HTML += '<td width="20%">Kategori</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.product_category + '</td>';
                HTML += '<td width="20%">Permintaan</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.request_user_name + '</td>';
                HTML += '</tr>';

                HTML += '<tr>';
                HTML += '<td width="20%">Status</td>';
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


                HTML += '<td width="20%">Deskripsi</td>';
                HTML += '<td width="2%">:</td>';
                HTML += '<td width="*">' + data.purchase.description + '</td>';
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
                    HTML += '</tr>';
                }


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
        $("#product_name").val("");
        $("#product_category").val("");
        $("#satuan").val("");
        $("#panjang").val("");
        $("#lebar").val("");
        $("#tebal").val("");
        $("#weight").val("");
        $("#price").val("");
        $("#product_items").html('<center>Belum ada daftar produk</center>');
    }


    function view_rejection_note(id) {
        $(".modal-title").text('Alasan Penolakan Permintaan Barang');
        $.ajax({
            url: "{{ url('purchase_request') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                var HTML = '';
                HTML += '<div class="form-group">';
                HTML += '<label>Alasan Penolakan</label>';
                HTML += '<textarea readonly class="form-control">' + data.purchase.rejection_note_1 +
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

                var AL = '';

                AL += '<option value="" selected disabled>Pilih Tujuan</option>';
                for (var i = 0; i < data.alamat.length; i++) {
                    AL += '<option value="' + data.alamat[i].id + '">' + data.alamat[i].nama +
                        '</option>';
                }

                $("#vendor_address_id").html(AL);

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
                HTML += data.nama + '<br>';
                HTML += data.kontak + '<br>';
                HTML += data.alamat + '<br>';
                HTML += 'Indonesia, ' + data.city.city_name + ', ';
                HTML += data.province.province_name + ', ';

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
                    var HTML = '';
                    for (var i = 0; i < data.items.length; i++) {

                        HTML += `<div id="baris_${i}" class="row"
                        style="margin-right:-5px; margin-left:-5px;">
                        <div class="col-2" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Produk</label>
                                <input value="${data.items[i].id}" type="hidden" id="pr_item_id_${i}" name="pr_item_id[]">
                                <input value="${data.items[i].product.price_type}" type="hidden" id="price_type_${i}" name="price_type[]">
                                <input value="${data.items[i].product_id}" type="hidden" id="product_id_${i}" name="product_id[]">
                                <input type="text" value="${data.items[i].product.product_name}"
                                    class="form-control" id="product_name_${i}" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Tebal</label>
                                <input value="${data.items[i].tebal}" readonly type="text" class="form-control"
                                    id="tebal_${i}" name="tebal[]">
                            </div>
                        </div>
                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Lebar</label>
                                <input value="${data.items[i].lebar}" readonly type="text" class="form-control"
                                    id="lebar_${i}" name="lebar[]">
                            </div>
                        </div>
                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Panjang</label>
                                <input value="${data.items[i].panjang}" readonly type="text" class="form-control"
                                    id="panjang_${i}" name="panjang[]">
                            </div>
                        </div>
                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Qty</label>
                                <input value="${data.items[i].quantity_outstanding}" onkeyup="qty_change(${i}, this)" type="number"
                                    class="form-control selected-qty" id="quantity_${i}"
                                    name="quantity[]">
                            </div>
                        </div>
                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Satuan</label>
                                <input value="${data.items[i].satuan}" readonly type="text" class="form-control"
                                    id="satuan_${i}" name="satuan[]">
                            </div>
                        </div>
                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Berat (Gr)</label>
                                <input value="${ribuan(data.items[i].weight_outstanding)}" readonly type="text" class="form-control"
                                    id="weight_${i}" name="weight[]">
                                
                            </div>
                        </div>

                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Harga</label>
                                <input onkeyup="on_price_change(${i}, this)" type="number" class="form-control"
                                    id="price_${i}" name="price[]">
                                
                            </div>
                        </div>

                        <div class="col-1" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Tax</label>
                                <select onchange="on_tax_change(${i}, this)" class="form-control"
                                    id="tax_${i}" name="tax[]">
                                    <option value="" selected disabled>Pilih Tax</option>
                                    <option value="10">10%</option>
                                    <option value="11">11%</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-2" style="padding-left:2px; padding-right:2px;">
                            <div class="form-group" style="margin-bottom:5px;">
                                <label style="margin-bottom:2px;">Jumlah Sebelum Pajak</label>
                                <input readonly type="text" class="form-control"
                                    id="price_before_tax_${i}" name="price_before_tax[]">
                                
                            </div>
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
            })
        }
    });

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
        // cari semua input yang id diawali dengan "a_"
        $("input[id^='price_before_tax_']").each(function(index, el) {
            var tax = $("#tax_"+index).val();
            tax = tax ? tax : 0;
            var price_before_tax = angka($(this).val());
            if(tax > 0) {
                var tpajak = (tax * price_before_tax) / 100;
                pajak += tpajak;
            }

            total += angka($(this).val());
        });

        // tampilkan hasil format ribuan
        $("#subtotal").val(ribuan(total));
        $("#total_tax").val(ribuan(pajak));
        var total_price = total + pajak;
        $("#total_price").val(ribuan(total_price));

    }
</script>
