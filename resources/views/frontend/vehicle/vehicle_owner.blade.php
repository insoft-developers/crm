<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-6 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Vehicle Owner</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            Vehicle Owner</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Vehicle Owner</th>
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


            <div class="col-sm-6 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Vehicle Ownership</h4>

                        </div>
                        <button onclick="addDataOwnership()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            Vehicle Ownership</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list-ownership">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Vehicle Ownership</th>
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
                <form type="POST" id="form-add">
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
                            <label>Vehicle Owner:</label>
                            <input type="text" class="form-control" id="vehicle_owner" name="vehicle_owner"
                                placeholder="Vehicle Owner Here..">
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


    <div id="modal-add-ownership" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form type="POST" id="form-add-ownership">
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
                            <label>Vehicle Ownership:</label>
                            <input type="text" class="form-control" id="vehicle_ownership" name="vehicle_ownership"
                                placeholder="Vehicle Ownership Here..">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button id="btn-save-data-ownership" type="submit" class="btn btn-success btn-sm">Save</button>
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
        ajax: '{{ route('vehicle.owner.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'vehicle_owner',
                name: 'vehicle_owner'
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
        $(".modal-title").text("Add Vehicle Owner Data");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/vehicle_owner') }}";
        else url = "{{ url('/vehicle_owner') . '/' }}" + id;
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
            url: "{{ url('/vehicle_owner') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Vehicle Owner Data");
                $('#id').val(data.id);
                $("#vehicle_owner").val(data.vehicle_owner);
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
                    url: "{{ url('/vehicle_owner') }}" + '/' + id,
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
        $("#vehicle_owner").val("");
    }
</script>


<!-- JAVASCRIPT OWNERSHIP-->
<script>
    function loadingOwnership() {
        $("#btn-save-data-ownership").text("Processing....");
        $("#btn-save-data-ownership").attr("disabled", true);
    }

    function unloadingOwnership() {
        $("#btn-save-data-ownership").text("Save");
        $("#btn-save-data-ownership").removeAttr("disabled");
    }

    $('#table-list-ownership').DataTable({
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('vehicle.ownership.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'vehicle_ownership',
                name: 'vehicle_ownership'
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

    function addDataOwnership() {
        resetFormOwnership();
        save_method_ownership = "add";
        // $('input[name=_method]').val('POST');
        $('#form-add-ownership input[name="_method"]').val('POST');
        $(".modal-title").text("Add Vehicle Ownership Data");
        $("#modal-add-ownership").modal("show");
        unloadingOwnership();
    }

    $("#form-add-ownership").submit(function(e) {
        loadingOwnership();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method_ownership == "add") url = "{{ url('/vehicle_ownership') }}";
        else url = "{{ url('/vehicle_ownership') . '/' }}" + id;
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-add-ownership form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                unloadingOwnership();
                if (data.success) {
                    $('#modal-add-ownership').modal('hide');
                    reloadTableOwnership();
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


    function editDataOwnership(id) {
        save_method_ownership = "edit";
        $('#form-add-ownership input[name="_method"]').val('PATCH');;
        $.ajax({
            url: "{{ url('/vehicle_ownership') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add-ownership').modal("show");
                $('.modal-title').text("Edit Vehicle Ownership Data");
                $('#id').val(data.id);
                $("#vehicle_ownership").val(data.vehicle_ownership);
            }
        })
    }

    function deleteDataOwnership(id) {
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
                    url: "{{ url('/vehicle_ownership') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTableOwnership();
                    }
                });
            }
        });
    }


    function reloadTableOwnership() {
        var table = $("#table-list-ownership").DataTable();
        table.ajax.reload(null, false);
    }

    function resetFormOwnership() {
        $("#vehicle_ownership").val("");
    }
</script>
