<!-- JAVASCRIPT -->
<script>
    $('#profile-preview').click(function() {
        $('#profile_image').trigger('click');
    });

    $("#profile_image").change(function() {
        document.getElementById('profile-preview').src = window.URL.createObjectURL(this.files[0]);

    });

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
        ajax: '{{ route('product.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'product_code',
                name: 'product_code'
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'product_category',
                name: 'product_category'
            },
            {
                data: 'satuan',
                name: 'satuan'
            },
            {
                data:'hpp',
                name:'hpp'
            },
            {
                data:'price',
                name:'price'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },

            {
                data: 'lebar',
                name: 'lebar'
            },
            {
                data: 'tebal',
                name: 'tebal'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: 'weight',
                name: 'weight'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },

        ]
    });

    function viewData(id) {
        $(".modal-title").text("Detail Driver Data");
        $.ajax({
            url: "{{ url('driver') }}" + "/" + id,
            type: "GET",
            success: function(data) {
                $("#modal-view-content").html(data);
                $("#modal-view").modal("show");
            }
        });
    }

    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Tambah Data Produk");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-product").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/product') }}";
        else url = "{{ url('/product') . '/' }}" + id;
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
            url: "{{ url('/product') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data Produk");
                $('#id').val(data.id);
                $("#product_name").val(data.product_name);
                $("#product_category").val(data.product_category);
                $("#satuan").val(data.satuan);
                $("#panjang").val(data.panjang);
                $("#lebar").val(data.lebar);
                $("#tebal").val(data.tebal);
                $("#weight").val(data.weight);
                $("#price").val(data.price);
                $("#price_type").val(data.price_type);
                
            }
        })
    }


    
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
        $("#price-type").val("");
        
    }
</script>

