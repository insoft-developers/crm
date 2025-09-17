<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-6 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Vehicle Merk</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            Vehicle Merk</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">#</th>
                                        <th scope="col">Vehicle Merk</th>
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
                            <h4 class="card-title">Vehicle Jenis</h4>

                        </div>
                        <button onclick="addDataJenis()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            Vehicle Jenis</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list-jenis">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">#</th>
                                        <th scope="col">Vehicle Jenis</th>
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
                            <h4 class="card-title">Vehicle Type</h4>

                        </div>
                        <button onclick="addDataType()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            Vehicle Type</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list-type">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">#</th>
                                        <th scope="col">Vehicle Type</th>
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
                            <h4 class="card-title">Location</h4>

                        </div>
                        <button onclick="addDataLocation()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Add
                            Location</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list-location">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">#</th>
                                        <th scope="col">Location Name</th>
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
                            <label>Vehicle Merk:</label>
                            <input type="text" class="form-control" id="vehicle_merk" name="vehicle_merk"
                                placeholder="Vehicle Merk Here..">
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


    <div id="modal-add-jenis" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form type="POST" id="form-add-jenis">
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
                            <label>Vehicle Jenis:</label>
                            <input type="text" class="form-control" id="vehicle_jenis" name="vehicle_jenis"
                                placeholder="Vehicle Jenis Here..">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button id="btn-save-data-jenis" type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-add-type" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form type="POST" id="form-add-type">
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
                            <label>Vehicle Type:</label>
                            <input type="text" class="form-control" id="vehicle_type" name="vehicle_type"
                                placeholder="Vehicle Type Here..">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button id="btn-save-data-type" type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="modal-add-location" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form type="POST" id="form-add-location">
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
                            <label>Location Name:</label>
                            <input type="text" class="form-control" id="location_name" name="location_name"
                                placeholder="Location Name Here..">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button id="btn-save-data-location" type="submit" class="btn btn-success btn-sm">Save</button>
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
        ajax: '{{ route('vehicle.merk.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'vehicle_merk',
                name: 'vehicle_merk'
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
        $(".modal-title").text("Add Vehicle Merk Data");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/vehicle_merk') }}";
        else url = "{{ url('/vehicle_merk') . '/' }}" + id;
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
            url: "{{ url('/vehicle_merk') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Vehicle Merk Data");
                $('#id').val(data.id);
                $("#vehicle_merk").val(data.vehicle_merk);
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
                    url: "{{ url('/vehicle_merk') }}" + '/' + id,
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
        $("#vehicle_merk").val("");
    }
</script>


{{-- JENIS --}}
<script>
    function loadingJenis() {
        $("#btn-save-data-jenis").text("Processing....");
        $("#btn-save-data-jenis").attr("disabled", true);
    }

    function unloadingJenis() {
        $("#btn-save-data-jenis").text("Save");
        $("#btn-save-data-jenis").removeAttr("disabled");
    }

    $('#table-list-jenis').DataTable({
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('vehicle.jenis.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'vehicle_jenis',
                name: 'vehicle_jenis'
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

    function addDataJenis() {
        resetFormJenis();
        save_method_jenis = "add";
        $('#form-add-jenis input[name="_method"]').val('POST');

        $(".modal-title").text("Add Vehicle Jenis Data");
        $("#modal-add-jenis").modal("show");
        unloadingJenis();
    }

    $("#form-add-jenis").submit(function(e) {
        loadingJenis();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method_jenis == "add") url = "{{ url('/vehicle_jenis') }}";
        else url = "{{ url('/vehicle_jenis') . '/' }}" + id;
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-add-jenis form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                unloadingJenis();
                if (data.success) {
                    $('#modal-add-jenis').modal('hide');
                    reloadTableJenis();
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


    function editDataJenis(id) {
        save_method_jenis = "edit";
        // $('input[name=_method]').val('PATCH');
        $('#form-add-jenis input[name="_method"]').val('PATCH');

        $.ajax({
            url: "{{ url('/vehicle_jenis') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add-jenis').modal("show");
                $('.modal-title').text("Edit Vehicle Jenis Data");
                $('#id').val(data.id);
                $("#vehicle_jenis").val(data.vehicle_jenis);
            }
        })
    }

    function deleteDataJenis(id) {
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
                    url: "{{ url('/vehicle_jenis') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTableJenis();
                    }
                });
            }
        });
    }


    function reloadTableJenis() {
        var table = $("#table-list-jenis").DataTable();
        table.ajax.reload(null, false);
    }

    function resetFormJenis() {
        $("#vehicle_jenis").val("");
    }
</script>



{{-- TYPE --}}
<script>

    function loadingType() {
        $("#btn-save-data-type").text("Processing....");
        $("#btn-save-data-type").attr("disabled", true);
    }

    function unloadingType() {
        $("#btn-save-data-type").text("Save");
        $("#btn-save-data-type").removeAttr("disabled");
    }
    $('#table-list-type').DataTable({
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('vehicle.type.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'vehicle_type',
                name: 'vehicle_type'
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

    function addDataType() {
        resetFormType();
        save_method_type = "add";
        // $('input[name=_method]').val('POST');
        $('#form-add-type input[name="_method"]').val('POST');

        $(".modal-title").text("Add Vehicle Type Data");
        $("#modal-add-type").modal("show");
        unloadingType();
    }

    $("#form-add-type").submit(function(e) {
        loadingType();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method_type == "add") url = "{{ url('/vehicle_type') }}";
        else url = "{{ url('/vehicle_type') . '/' }}" + id;
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-add-type form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                unloadingType();
                if (data.success) {
                    $('#modal-add-type').modal('hide');
                    reloadTableType();
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


    function editDataType(id) {
        save_method_type = "edit";
        // $('input[name=_method]').val('PATCH');
        $('#form-add-type input[name="_method"]').val('PATCH');

        $.ajax({
            url: "{{ url('/vehicle_type') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add-type').modal("show");
                $('.modal-title').text("Edit Vehicle Type Data");
                $('#id').val(data.id);
                $("#vehicle_type").val(data.vehicle_type);
            }
        })
    }

    function deleteDataType(id) {
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
                    url: "{{ url('/vehicle_type') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTableType();
                    }
                });
            }
        });
    }


    function reloadTableType() {
        var table = $("#table-list-type").DataTable();
        table.ajax.reload(null, false);
    }

    function resetFormType() {
        $("#vehicle_type").val("");
    }
</script>

{{-- LOCATION  --}}


<script>
    $('#table-list-location').DataTable({
        dom: 'Bfrtip', // 'B' = buttons
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,
        ajax: '{{ route('location.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'location_name',
                name: 'location_name'
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


    function loadingLocation() {
        $("#btn-save-data-location").text("Processing....");
        $("#btn-save-data-location").attr("disabled", true);
    }

    function unloadingLocation() {
        $("#btn-save-data-location").text("Save");
        $("#btn-save-data-location").removeAttr("disabled");
    }


    function addDataLocation() {
        resetFormLocation();
        save_method_location = "add";
        // $('input[name=_method]').val('POST');
        $('#form-add-location input[name="_method"]').val('POST');

        $(".modal-title").text("Add Location Data");
        $("#modal-add-location").modal("show");
        unloadingLocation();
    }

    $("#form-add-location").submit(function(e) {
        loadingLocation();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method_location == "add") url = "{{ url('/location') }}";
        else url = "{{ url('/location') . '/' }}" + id;
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-add-location form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                unloadingLocation();
                if (data.success) {
                    $('#modal-add-location').modal('hide');
                    reloadTableLocation();
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


    function editDataLocation(id) {
        save_method_location = "edit";
        // $('input[name=_method]').val('PATCH');
        $('#form-add-location input[name="_method"]').val('PATCH');

        $.ajax({
            url: "{{ url('/location') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add-location').modal("show");
                $('.modal-title').text("Edit Location Data");
                $('#id').val(data.id);
                $("#location_name").val(data.location_name);
            }
        })
    }

    function deleteDataLocation(id) {
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
                    url: "{{ url('/location') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function($data) {
                        reloadTableLocation();
                    }
                });
            }
        });
    }


    function reloadTableLocation() {
        var table = $("#table-list-location").DataTable();
        table.ajax.reload(null, false);
    }

    function resetFormLocation() {
        $("#location_name").val("");
    }

</script>
