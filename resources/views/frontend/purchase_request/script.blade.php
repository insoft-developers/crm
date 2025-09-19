<!-- JAVASCRIPT -->
<script>
    let rowCount = 1;

    function add_product_item() {
        rowCount++;
        let newRow = $("#baris_1").clone();

        // ganti id sesuai nomor row
        newRow.attr("id", "baris_" + rowCount);

        // update semua input/select id nya
        newRow.find("select, input").each(function() {
            let oldId = $(this).attr("id");
            if (oldId) {
                let newId = oldId.replace(/\d+$/, rowCount);
                $(this).attr("id", newId);
            }
            // kosongkan value untuk row baru
            if ($(this).is("input")) {
                $(this).val("");
            } else if ($(this).is("select")) {
                $(this).val("");
            }
        });


        newRow.find(".select-product-item").attr("onchange", "selected_product(" + rowCount + ")");


        newRow.find(".selected-qty")
            .attr("onkeyup", "qty_change(" + rowCount + ", this)");



        // update tombol minus function
        newRow.find("button.btn-danger").attr("onclick", "remove_product_item(" + rowCount + ")");

        // tambahkan ke container
        $("#product_items").append(newRow);
    }

    function remove_product_item(id) {
        if (id === 1) {
            alert("Row pertama tidak bisa dihapus!");
            return;
        }
        $("#baris_" + id).remove();
    }


    $("#product_category").change(function() {
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
                HTML += '<option value="" selected disabled>Pilih Produk</option>';
                for (var i = 0; i < data.length; i++) {
                    HTML += '<option value="' + data[i].id + '">' + data[i].product_name +' ('+data[i].lebar+' x '+data[i].tebal+' x '+data[i].panjang+') </option>';
                }

                $(".select-product-item").html(HTML);

                if (typeof callback === "function") {
                    callback();
                }

            }
        });
    }


    function selected_product(id) {
        var product_id = $("#product_id_" + id).val();
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
                $("#tebal_" + id).val(data.tebal);
                $("#lebar_" + id).val(data.lebar);
                $("#panjang_" + id).val(data.panjang);
                $("#satuan_" + id).val(data.satuan);
                $("#weight_" + id).val(0);
                $("#berat_" + id).val(data.weight);
                $("#quantity_" + id).val("");

            }
        })
    }


    function qty_change(id, el) {

        // var qty = $(el).val();
        // var berat = $("#berat_" + id).val();
        // var new_weight = qty * berat;
        // var formatted_weight = ribuan(new_weight);
        // $("#weight_" + id).val(formatted_weight);
    }

    function generate_pr_number() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('generate.pr.number') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "_token": csrf_token
            },
            success: function(data) {
                $("#pr_number").val(data.pr_number);
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
            url: '{{ route('purchase.request.table') }}',
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
                data: 'pr_number',
                name: 'pr_number'
            },
            {
                data: 'request_user_id',
                name: 'request_user_id'
            },
            {
                data: 'request_date',
                name: 'request_date'
            },
            {
                data: 'description',
                name: 'description'
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
        init_add_item();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Tambah Permintaan Barang");
        $("#modal-add").modal("show");
        generate_pr_number();
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
                generate_pr_number();

            }
        })
    }

    function init_add_item() {
        var HTML = '';
        HTML += `<div id="baris_1" class="row"
            style="margin-right:-5px; margin-left:-5px;">
            <div class="col-3" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Produk</label>
                    <select onchange="selected_product(1)" class="form-control select-product-item" id="product_id_1"
                        name="product_id[]">
                        <option value="" selected disabled>Pilih Produk
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-1" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Tebal</label>
                    <input readonly type="text" class="form-control"
                        id="tebal_1" name="tebal[]">
                </div>
            </div>
            <div class="col-1" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Lebar</label>
                    <input readonly type="text" class="form-control"
                        id="lebar_1" name="lebar[]">
                </div>
            </div>
            <div class="col-1" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Panjang</label>
                    <input readonly type="text" class="form-control"
                        id="panjang_1" name="panjang[]">
                </div>
            </div>
            <div class="col-1" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Qty</label>
                    <input onkeyup="qty_change(1, this)" type="text" class="form-control selected-qty" id="quantity_1"
                        name="quantity[]">
                </div>
            </div>
            <div class="col-2" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Satuan</label>
                    <input readonly type="text" class="form-control"
                        id="satuan_1" name="satuan[]">
                </div>
            </div>
            <div class="col-2" style="padding-left:2px; padding-right:2px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label style="margin-bottom:2px;">Berat (Kg)</label>
                    <input type="number" class="form-control"
                        id="weight_1" name="weight[]">
                    <input type="hidden" id="berat_1">
                </div>
            </div>

            <div class="col-1" style="padding-left:2px; padding-right:2px;">
                <div style="display:flex; gap:4px;margin-top:30px;">
                    <button onclick="add_product_item()" type="button"
                        class="btn btn-fixing btn-success">+</button>
                    <button onclick="remove_product_item(1)" type="button"
                        class="btn btn-fixing btn-danger">-</button>
                </div>
            </div>
        </div>`;

        $("#product_items").html(HTML);


    }


    function init_edit_item(data) {
        var HTML = '';
        rowCount = 0;

        for (var i = 0; i < data.item.length; i++) {
            rowCount++;
            HTML += `
            <div id="baris_${rowCount}" class="row" style="margin-right:-5px; margin-left:-5px; border-bottom:1px solid #ddd; padding-bottom:8px; margin-bottom:8px;">
                <div class="col-3" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Produk</label>
                        <select onchange="selected_product(${rowCount})" class="form-control select-product-item" id="product_id_${rowCount}" name="product_id[]">
                            <option value="" selected disabled>Pilih Produk</option>
                        </select>
                    </div>
                </div>
                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Tebal</label>
                        <input readonly type="text" class="form-control" id="tebal_${rowCount}" name="tebal[]">
                    </div>
                </div>
                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Lebar</label>
                        <input readonly type="text" class="form-control" id="lebar_${rowCount}" name="lebar[]">
                    </div>
                </div>
                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Panjang</label>
                        <input readonly type="text" class="form-control" id="panjang_${rowCount}" name="panjang[]">
                    </div>
                </div>
                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Qty</label>
                        <input onkeyup="qty_change(${rowCount}, this)" type="text" class="form-control selected-qty" id="quantity_${rowCount}" name="quantity[]">
                    </div>
                </div>
                <div class="col-2" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Satuan</label>
                        <input readonly type="text" class="form-control" id="satuan_${rowCount}" name="satuan[]">
                    </div>
                </div>
                <div class="col-2" style="padding-left:2px; padding-right:2px;">
                    <div class="form-group" style="margin-bottom:5px;">
                        <label style="margin-bottom:2px;">Berat (Kg)</label>
                        <input type="number" class="form-control" id="weight_${rowCount}" name="weight[]">
                        <input type="hidden" id="berat_${rowCount}">
                    </div>
                </div>
                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                    <div style="display:flex; gap:4px;margin-top:30px;">
                        <button onclick="add_product_item()" type="button" class="btn btn-fixing btn-success">+</button>
                        <button onclick="remove_product_item(${rowCount})" type="button" class="btn btn-fixing btn-danger">-</button>
                    </div>
                </div>
            </div>
            `;
        }

        $("#product_items").html(HTML);
        var actions = 'edit';
        var category = data.purchase.product_category;
        get_product_list_by_category(category, actions, function() {
            for (var i = 0; i < data.item.length; i++) {
                var berat = data.item[i].weight / data.item[i].quantity;

                $("#product_id_" + (i + 1)).val(data.item[i].product_id);
                $("#tebal_" + (i + 1)).val(data.item[i].tebal);
                $("#lebar_" + (i + 1)).val(data.item[i].lebar);
                $("#panjang_" + (i + 1)).val(data.item[i].panjang);
                $("#quantity_" + (i + 1)).val(data.item[i].quantity);
                $("#satuan_" + (i + 1)).val(data.item[i].satuan);
                $("#weight_" + (i + 1)).val(data.item[i].weight);
                $("#berat_" + (i + 1)).val(berat);


            }
        });

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
                    url: "{{ route('purchase.request.propose') }}",
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
                    HTML += '<td width="*"><div class="text-kuning">Pengajuan</div></td>';
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
                    HTML += '<td>'+data.item[i].product.product_name +'</td>';
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
        $("#product_name").val("");
        $("#product_category").val("");
        $("#satuan").val("");
        $("#panjang").val("");
        $("#lebar").val("");
        $("#tebal").val("");
        $("#weight").val("");
        $("#price").val("");

    }


    function view_rejection_note(id) {
        $(".modal-title").text('Alasan Penolakan Permintaan Barang');
        $.ajax({
            url: "{{ url('purchase_request') }}" + "/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                var note = data.purchase.rejection_note_1 == null ? data.purchase.rejection_note_2 : data.purchase.rejection_note_1;
               
                var HTML = '';
                HTML += '<div class="form-group">';
                HTML += '<label>Alasan Penolakan</label>';
                HTML += '<textarea readonly class="form-control">' + note +
                    '</textarea>';
                HTML += '</div>';
                $("#modal-reason-content").html(HTML);
                $("#modal-reason").modal("show");

            }
        })
    }
</script>
