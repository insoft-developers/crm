<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Customer Data</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Customer</button>

                    </div>
                    <div class="card-body">
                        <div class="">
                            <table class="table table-bordered noWrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Customer</th>
                                        <th scope="col">Tipe Custumer</th>
                                        <th scope="col">No Telp</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Status</th>

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
        <div class="modal-dialog modal-xl">
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="branch_id">Branch:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="branch_id" name="branch_id">
                                            <option value="" disabled selected>Pilih branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="nama_lengkap">Nama
                                        Lengkap:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                            placeholder="masukkan nama lengkap customer">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="customer_type">Tipe
                                        Customer:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="customer_type" name="customer_type">
                                            <option value="" disabled selected>Pilih type</option>
                                            <option value="distributor">Distributor</option>
                                            <option value="retail">Retail</option>
                                            <option value="end_user">End User</option>
                                            <option value="distributor">Reseller</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="alamat">Alamat
                                        Lengkap:</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="alamat" name="alamat" placeholder="masukkan alamat lengkap customer"></textarea>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="latitude">Latitude:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="latitude" name="latitude"
                                            placeholder="bisa pilih melalui map">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="longitude">Longitude:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="longitude" name="longitude"
                                            placeholder="bisa pilih melalui map">

                                    </div>
                                </div>

                                <div id="map" style="height: 400px;"></div>
                                <div class="clear" style="margin-top:20px"></div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="provinsi">Provinsi:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="provinsi" name="provinsi">
                                            <option value="" disabled selected>Pilih provinsi</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->province_id }}">
                                                    {{ $province->province_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="kota">Kabupaten/Kota:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="kota" name="kota">
                                            <option value="" disabled selected>Pilih provinsi dahulu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="kecamatan">Kecamatan:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="kecamatan" name="kecamatan">
                                            <option value="" disabled selected>Pilih kota dahulu</option>
                                        </select>
                                    </div>
                                </div>




                            </div>
                            <div class="col-6"></div>
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
    var map;
    var marker;

    $('#modal-add').on('shown.bs.modal', function() {
        // Titik awal
        var lat = -6.2;
        var lng = 106.8167;

        // Hanya buat map jika belum dibuat
        if (!map) {
            map = L.map('map').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // Isi input saat awal
            $('#latitude').val(lat);
            $('#longitude').val(lng);

            // Update koordinat saat marker digeser
            marker.on('dragend', function() {
                var pos = marker.getLatLng();
                $('#latitude').val(pos.lat.toFixed(6));
                $('#longitude').val(pos.lng.toFixed(6));
            });
        } else {
            // Jika map sudah ada, perbarui ukurannya
            map.invalidateSize();
        }

        map.on('dblclick', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);

            // Pindahkan marker ke lokasi klik
            marker.setLatLng([lat, lng]);

            // Perbarui input koordinat
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });

        $('#latitude, #longitude').on('change', function() {
            const lat = parseFloat($('#latitude').val());
            const lng = parseFloat($('#longitude').val());
            if (!isNaN(lat) && !isNaN(lng)) {
                const latLng = L.latLng(lat, lng);
                marker.setLatLng(latLng);
                map.setView(latLng); // opsional
            }
        });

    });
</script>


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
        ajax: '{{ route('customer.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false,
            },
            {
                data: 'nama_lengkap',
                name: 'nama_lengkap'
            },
            {
                data: 'customer_type',
                name: 'customer_type',


            },
            {
                data: 'phone',
                name: 'phone',

            },
            {
                data: 'email',
                name: 'email',

            },
            {
                data: 'alamat',
                name: 'alamat',

            },
            {
                data: 'status',
                name: 'status',

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
        $(".modal-title").text("Tambah Customer Data");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/branch') }}";
        else url = "{{ url('/branch') . '/' }}" + id;
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
            url: "{{ url('/branch') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Customer Data");
                $('#id').val(data.id);
                $("#branch_name").val(data.branch_name);
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
                    url: "{{ url('/branch') }}" + '/' + id,
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
        $("#branch_name").val("");
    }
</script>
</script>
