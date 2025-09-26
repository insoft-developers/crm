<script>
  

    function loading() {
        $("#btn-save-data").text("Processing....");
        $("#btn-save-data").attr("disabled", true);
    }

    function unloading() {
        $("#btn-save-data").text("Save");
        $("#btn-save-data").removeAttr("disabled");
    }

    let table = $('#table-list').DataTable({
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('titipan.table') }}',
            data: function(d) {
                // tambahin parameter filter
                d.product_name_filter = $('#product_name_filter').val();
                d.coil_number_filter = $('#coil_number_filter').val();
                d.product_number_filter = $("#product_number_filter").val();
                d.tebal_filter = $("#tebal_filter").val();
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
                data: 'quantity_received',
                name: 'quantity_received'
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


    $('#btn-filter-data').click(function() {
        table.ajax.reload();
    });

    // tombol reset filter
    $('#btn-refresh-data').click(function() {
        // kosongkan input
        $('#product_name_filter').val('');
        $('#coil_number_filter').val('');
        $('#product_number_filter').val('');
        $('#tebal_filter').val('');
        // reload datatable
        $('#table-list').DataTable().ajax.reload();
    });


    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/titipan') }}";
        else url = "{{ url('/titipan') . '/' }}" + id;
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
            url: "{{ url('/titipan') }}" + "/" + id + "/edit",
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
                $('.modal-title').text(data.product.product_name);
                $("#tebal_actual").removeAttr("readonly");
                $("#weight_actual").removeAttr("readonly");
                $("#note").removeAttr("readonly");
                $("#remark").removeAttr("readonly");
                
            }
        })
    }

    function reloadTable() {
        var table = $("#table-list").DataTable();
        table.ajax.reload(null, false);
    }

</script>
