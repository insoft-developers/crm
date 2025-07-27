<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Lincese Type</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            License Type</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">License Name</th>
                                        <th scope="col">Created Date</th>
                                        <th scope="col">Updated Date</th>
                                        <th style="width: 200px;" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="modal-add" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form type="POST" id="form-license">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label>License Name:</label>
                            <input type="text" class="form-control" id="license_name" name="license_name"
                                placeholder="License Name Here..">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button id="btn-save-data" type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>



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
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('license.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'license_name',
                name: 'license_name'
            },
            {
                data: 'created_at',
                name: 'created_at',
                visible: false,
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                visible: false,
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add License Data");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-license").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/license') }}";
        else url = "{{ url('/license') . '/' }}" + id;
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
            url: "{{ url('/license') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit License Data");
                $('#id').val(data.id);
                $("#license_name").val(data.license_name);
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
                    url: "{{ url('/license') }}" + '/' + id,
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
        $("#license_name").val("");
    }
</script>
</script>
