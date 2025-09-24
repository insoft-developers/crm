<script>
    let rowIndex = 1;

    function loading() {
        $("#btn-save-data").text("Processing....");
        $("#btn-save-data").attr("disabled", true);
    }

    function unloading() {
        $("#btn-save-data").text("Save");
        $("#btn-save-data").removeAttr("disabled");
    }

    $('#table-list').DataTable({
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('stock.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'product_id',
                name: 'product_id'
            },
            {
                data: 'tebal',
                name: 'tebal'
            },
            {
                data: 'lebar',
                name: 'lebar'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },
            {
                data: 'mills',
                name: 'mills'
            },
            {
                data: 'location',
                name: 'location'
            },
            {
                data: 'tebal_actual',
                name: 'tebal_actual'
            },
            {
                data: 'product_number',
                name: 'product_number'
            },
            {
                data: 'coil_number',
                name: 'coil_number'
            },
            {
                data: 'weight_received',
                name: 'weight_received'
            },
            {
                data: 'weight_actual',
                name: 'weight_actual'
            },
            {
                data: 'note',
                name: 'note'
            },
            {
                data: 'stock_status',
                name: 'stock_status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },

        ]
    });


    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/stock') }}";
        else url = "{{ url('/stock') . '/' }}" + id;
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


    function editData(id, actions) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/stock') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");

                $('#id').val(data.id);
                $("#product_name").val(data.product.product_name);
                $("#tebal").val(data.tebal);
                $("#lebar").val(data.lebar);
                $("#panjang").val(data.panjang);
                $("#mills").val(data.good_receive.mills);
                $("#location").val(data.location);
                $("#tebal_actual").val(data.tebal_actual);
                $("#product_number").val(data.product_number);
                $("#coil_number").val(data.coil_number);
                $("#weight_received").val(data.weight_received);
                $("#weight_actual").val(data.weight_actual);
                $("#note").val(data.note);
                $("#remark").val(data.remark);

                if (actions == 2) {
                    show_item(data.retur, 0);
                    $('.modal-title').text("Detail Produk Retur");
                    $("#aksi").val("retur");
                    $("#tebal_actual").attr("readonly", true);
                    $("#weight_actual").attr("readonly", true);
                    $("#note").attr("readonly", true);
                    $("#remark").attr("readonly", true);
                } else {
                    $('.modal-title').text(data.product.product_name);
                    $("#return-item").html("");
                    $("#aksi").val("update");
                    $("#tebal_actual").removeAttr("readonly");
                    $("#weight_actual").removeAttr("readonly");
                    $("#note").removeAttr("readonly");
                    $("#remark").removeAttr("readonly");
                }
            }
        })
    }

    function reloadTable() {
        var table = $("#table-list").DataTable();
        table.ajax.reload(null, false);
    }

    function tambah_return_note(id) {
        show_item([], 1);
    }

    function hapus_return_note(id) {
        $("#row_" + id).remove();
    }


    function show_item(items, tambah = null) {
        if (tambah == 1) {
            // Tambah baris tunggal
            $("#return-item").append(buildRow(rowIndex));
            rowIndex++;
        } else {
            if (items.length > 0) {
                rowIndex = 1;
                var LIST = '';
                $.each(items, function(i, item) {
                    LIST += buildRow(rowIndex, item);
                    rowIndex++;
                });
                $("#return-item").html(LIST);
            } else {
                rowIndex = 1;
                $("#return-item").html(buildRow(rowIndex));
                rowIndex++;
            }
        }
    }

    // fungsi pembuat row agar id/atribut selalu sesuai
    function buildRow(idx, data = null) {

        const defaultImg = "{{ asset('images/product/1.png') }}";
        const imgSrc = (data && data.return_image) ?
            `/storage/${data.return_image}` :
            defaultImg;
        let input_id = null;
        if (data == null) {
            input_id = `<input type="hidden" id="list_id_${idx}" name="list_id[]">`;
        } else {
            input_id = `<input value="${data.id}" type="hidden" id="list_id_${idx}" name="list_id[]">`;
        }


        return `
        <div id="row_${idx}" class="row">
            <div class="col-1">
                <div class="tombol-return-container">
                    <a title="Tambah Catatan" href="javascript:void(0);" onclick="tambah_return_note(${idx})"><i class="fa fa-plus return-tambah"></i></a>
                    <a title="Hapus Catatan" href="javascript:void(0);" onclick="hapus_return_note(${idx})"><i class="fa fa-trash return-hapus"></i></a>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Note:</label>
                    ${input_id}
                    <textarea class="form-control" id="return_note_${idx}" name="return_note[]">${data == null ? '': data.note}</textarea>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Foto Barang Retur:</label>
                    <input style="display: none;" accept=".jpg, .jpeg, .png" type="file"
                           class="sm-input return-file" id="return_image_${idx}" name="return_image[]">
                    <br>
                    <img data-row="${idx}" src="${imgSrc}"
                         id="return_image_preview_${idx}" class="return-image-preview">
                </div>
            </div>
            <div class="col-5"></div>
        </div>`;
    }



    $(document).on('click', '.return-image-preview', function() {
        // Ambil index baris dari atribut data-row
        var idx = $(this).data('row');
        // Trigger klik pada input file yang sesuai
        $('#return_image_' + idx).trigger('click');
    });

    $(document).on('change', '.return-file', function(e) {
        // Ambil index baris dari ID input
        var idx = this.id.replace('return_image_', '');
        var file = this.files[0];

        if (file) {
            // Tampilkan pratinjau di <img> yang sesuai
            var reader = new FileReader();
            reader.onload = function(ev) {
                $('#return_image_preview_' + idx).attr('src', ev.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
