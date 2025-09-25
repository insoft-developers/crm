<!-- JAVASCRIPT -->
<script>
    
    function loading() {
        $("#btn-save-data").text("Processing....");
        $("#btn-save-data").attr("disabled", true);
    }

    function unloading() {
        $("#btn-save-data").text("Save");
        $("#btn-save-data").removeAttr("disabled");
    }

    $('#table-list').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('prefix.setting.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'purchase_request',
                name: 'purchase_request'
            },
            {
                data: 'purchase_order',
                name: 'purchase_order'
            },
            {
                data: 'good_receive',
                name: 'good_receive'
            },
            {
                data: 'titipan',
                name: 'titipan'
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
        if (save_method == "add") url = "{{ url('/prefix_setting') }}";
        else url = "{{ url('/prefix_setting') . '/' }}" + id;
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
            url: "{{ url('/prefix_setting') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data Prefix"); 
                $('#id').val(data.id);
                $("#purchase_request").val(data.purchase_request);
                $("#purchase_order").val(data.purchase_order);
                $("#good_receive").val(data.good_receive);
                $("#titipan").val(data.titipan);
            }
        });
    }

    
    function reloadTable() {
        var table = $("#table-list").DataTable();
        table.ajax.reload(null, false);
    }
    
</script>
