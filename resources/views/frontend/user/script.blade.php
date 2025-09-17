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
        ajax: '{{ route('user.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [
            {
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone_number',
                name: 'phone_number'
            },
            {
                data: 'user_level',
                name: 'user_level'
            },
            {
                data:'position_id',
                name:'position_id'
            },
            {
                data:'approve_1',
                name:'approve_1'
            },
            {
                data: 'is_active',
                name: 'is_active'
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
        $(".modal-title").text("Tambah Data User");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/user') }}";
        else url = "{{ url('/user') . '/' }}" + id;
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
            url: "{{ url('/user') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data User");
                $('#id').val(data.id);
                $("#first_name").val(data.first_name);
                $("#last_name").val(data.last_name);
                $("#email").val(data.email);
                $("#phone_number").val(data.phone_number);
                $("#position_id").val(data.position_id);
                $("#user_level").val(data.user_level);
                $("#is_active").val(data.is_active);
                let approve = 0;
                if(data.approve_1 == 0 && data.approve_2 == 0) {
                    approve = 0;
                }

                else if(data.approve_1 == 1 && data.approve_2 == 0) {
                    approve = 1;
                }

                else if(data.approve_1 == 0 && data.approve_2 == 1) {
                    approve = 2;
                }

                $("#approve_level").val(approve);      
                $("#password").val("");          
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
                    url: "{{ url('/user') }}" + '/' + id,
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
        $("#first_name").val("");
        $("#last_name").val("");
        $("#email").val("");
        $("#phone_number").val("");
        $("#user_level").val("");
        $("#position_id").val("");
        $("#approve_level").val("");
        $("#is_active").val("");
        $("#password").val("");
        
    }
</script>

