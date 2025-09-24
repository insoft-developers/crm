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


    function editData(id) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/stock') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Detail Produk");
                $('#id').val(data.id);
                // $("#product_name").val(data.product_name);
                // $("#product_category").val(data.product_category);
                // $("#satuan").val(data.satuan);
                // $("#panjang").val(data.panjang);
                // $("#lebar").val(data.lebar);
                // $("#tebal").val(data.tebal);
                // $("#weight").val(data.weight);
                // $("#price").val(data.price);
                // $("#price_type").val(data.price_type);
                
            }
        })
    }
</script>