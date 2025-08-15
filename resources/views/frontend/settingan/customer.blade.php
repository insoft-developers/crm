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
                        <div class="table-responsive">

                            <table class="table table-bordered nowrap" id="table-list">
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
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="branch_id">Branch</label>
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
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="nama_lengkap">Nama
                                        Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                            placeholder="masukkan nama lengkap customer">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="customer_type">Tipe
                                        Customer</label>
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
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="alamat">Alamat
                                        Lengkap</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="alamat" name="alamat" placeholder="masukkan alamat lengkap customer"></textarea>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="latitude">Latitude</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="latitude" name="latitude"
                                            placeholder="bisa pilih melalui map">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="longitude">Longitude</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="longitude" name="longitude"
                                            placeholder="bisa pilih melalui map">

                                    </div>
                                </div>

                                <div id="map" style="height: 400px;"></div>
                                <div class="clear" style="margin-top:20px"></div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="provinsi">Provinsi</label>
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
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="kota">Kabupaten/Kota</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="kota" name="kota">
                                            <option value="" disabled selected>Pilih provinsi dahulu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="kecamatan">Kecamatan</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="kecamatan" name="kecamatan">
                                            <option value="" disabled selected>Pilih kota dahulu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="postal_code">Kode
                                        Pos</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="postal_code"
                                            name="postal_code" placeholder="masukkan kode pos...">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center bintang" for="phone">No
                                        Telepon/Whatsapp</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="ex: 082199005656">

                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="phone2" name="phone2"
                                            placeholder="ex: 082199005656">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center bintang"
                                        for="email">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="masukkan email dengan benar ..">

                                    </div>


                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="contact_person">Contact Person</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="contact_person"
                                            name="contact_person" placeholder="masukkan contact person ..">

                                    </div>


                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="email_contact_person">Email Contact Person</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email_contact_person"
                                            name="email_contact_person"
                                            placeholder="masukkan email contact person ..">

                                    </div>


                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="contact_person_phone">No Telepon/Whatsapp Contact Person</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="contact_person_phone"
                                            name="contact_person_phone" placeholder="ex: 082199005656">

                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="contact_person_phone2"
                                            name="contact_person_phone2" placeholder="ex: 082199005656">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="status">Status
                                        Customer</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="status" name="status">
                                            <option value="" disabled selected>pilih status</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>




                            </div>
                            <div class="col-6">

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="akun_hutang">Akun
                                        Hutang</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="akun_hutang" name="akun_hutang">
                                            <option value="" disabled selected>pilih akun hutang</option>
                                            <option value="1">Akun Hutang Contoh 1</option>
                                            <option value="2">Akun Hutang Contoh 2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="akun_piutang">Akun
                                        Piutang</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="akun_piutang" name="akun_piutang">
                                            <option value="" disabled selected>pilih akun piutang</option>
                                            <option value="1">Akun Piutang Contoh 1</option>
                                            <option value="2">Akun Piutang Contoh 2</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="akun_piutang_sementara">Akun Piutang Sementara</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="akun_piutang_sementara"
                                            name="akun_piutang_sementara">
                                            <option value="" disabled selected>pilih akun piutang sementara
                                            </option>
                                            <option value="1">Akun Piutang Sementara Contoh 1</option>
                                            <option value="2">Akun Piutang Sementara Contoh 2</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="limit_hutang">Limit
                                        Hutang</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="limit_hutang"
                                            name="limit_hutang" placeholder="masukkan limit hutang..">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="no_ktp">No
                                        KTP/NIK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                            placeholder="masukkan no KTP / NIK..">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="npwp_induk">No NPWP
                                        Induk</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="npwp_induk" name="npwp_induk"
                                            placeholder="masukkan no NPWP Induk">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="npwp">No
                                        NPWP</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="npwp" name="npwp"
                                            placeholder="masukkan no NPWP">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="description">Deskripsi</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="description" name="description" placeholder="masukkan Deskripsi pelanggan...">
                                        </textarea>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="bank_account_number">Bank Account Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="bank_account_number"
                                            name="bank_account_number"
                                            placeholder="masukkan no rekening pelanggan...">

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="account_owner">Bank
                                        Account Owner</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="account_owner"
                                            name="account_owner" placeholder="masukkan atas nama rekening...">


                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="bank_name">Bank
                                        Name</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="bank_name" name="bank_name">
                                            <option value="" disabled selected>pilih bank</option>
                                            <option value="bank-bri">Bank BRI</option>
                                            <option value="bank-bni">Bank BNI</option>
                                            <option value="bank-mandiri">Bank Mandiri</option>
                                        </select>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center"
                                        for="branch_account">Branch Account</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="branch_account"
                                            name="branch_account"
                                            placeholder="masukkan bank cabang mana rekening pelanggan terdaftar...">


                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-sm-4 align-self-center" for="foto">Foto
                                        Pelanggan</label>
                                    <div class="col-sm-8">
                                        <img id="profile-preview" class="profile-image-upload"
                                            src="{{ asset('images/avatar_foto.webp') }}">
                                        <input type="file" class="form-control" id="foto" name="foto"
                                            placeholder="Profile Image Here.." accept=".jpg, .png, .jpeg"
                                            style="display: none;">


                                    </div>
                                </div>





                            </div>
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
    $('#limit_hutang').on('input', function() {
        let nilai = $(this).val();
        let nilaiBaru = formatRibuan(nilai);
        $(this).val(nilaiBaru);
    });


    function updateMap(lat, lng) {
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
            // Resize map jika misalnya ditaruh di dalam modal
            map.invalidateSize();

            // Perbarui tampilan peta dan marker
            map.setView([lat, lng], 13);
            marker.setLatLng([lat, lng]);

            // Update input juga
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        }
    }

    $('#profile-preview').click(function() {
        $('#foto').trigger('click');
    });

    $("#foto").change(function() {
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

    $("#provinsi").change(function() {
        var provinceId = $(this).val();
        provinsiChange(provinceId, 0);
    });


    function provinsiChange(provinceId, cityId) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('kota.get') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "province_id": provinceId,
                "_token": csrf_token
            },
            success: function(data) {
                console.log(data);
                var html = '';
                html += '<option value="" disabled selected>pilih kota</option>';

                if (cityId == 0) {
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].city_id + '">' + data[i].city_name +
                            '</option>';
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        let selected = (cityId == data[i].city_id) ? 'selected' : '';
                        html += '<option value="' + data[i].city_id + '" ' + selected + '>' + data[i]
                            .city_name +
                            '</option>';
                    }
                }


                $("#kota").html(html);
                $("#kecamatan").html(
                    '<option value="" disabled selected>pilih kota dahulu</option>');


            }
        });
    }




    $("#kota").change(function() {
        var cityId = $(this).val();
        changeCity(cityId, 0);

    });


    function changeCity(cityId, districtId) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('kecamatan.get') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                "city_id": cityId,
                "_token": csrf_token
            },
            success: function(data) {
                console.log(data);
                var html = '';
                html += '<option value="" disabled selected>pilih kecamatan</option>';

                if (districtId == 0) {
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].subdistrict_id + '">' + data[i]
                            .subdistrict_name + '</option>';
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        let selected = (districtId == data[i].subdistrict_id) ? 'selected' : '';
                        html += '<option value="' + data[i].subdistrict_id + '" ' + selected + '>' + data[i]
                            .subdistrict_name +
                            '</option>';
                    }
                }


                $("#kecamatan").html(html);


            }
        });
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
        if (save_method == "add") url = "{{ url('/customer') }}";
        else url = "{{ url('/customer') . '/' }}" + id;
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
            url: "{{ url('/customer') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Customer Data");
                $('#id').val(data.id);
                $("#branch_id").val(data.branch_id);
                $("#nama_lengkap").val(data.nama_lengkap);
                $("#customer_type").val(data.customer_type);
                $("#alamat").val(data.alamat);
                $("#provinsi").val(data.provinsi);
                provinsiChange(data.provinsi, data.kota);
                changeCity(data.kota, data.kecamatan);
                $("#postal_code").val(data.postal_code);
                $("#phone").val(data.phone);
                $("#phone2").val(data.phone2);
                $("#email").val(data.email);
                $("#contact_person").val(data.contact_person);
                $("#email_contact_person").val(data.email_contact_person);
                $("#contact_person_phone").val(data.contact_person_phone);
                $("#contact_person_phone2").val(data.contact_person_phone2);
                $("#status").val(data.status);
                $("#akun_hutang").val(data.akun_hutang);
                $("#akun_piutang").val(data.akun_piutang);
                $("#akun_piutang_sementara").val(data.akun_piutang_sementara);
                var limitHutang = data.limit_hutang;
                limitHutang = limitHutang.toString();
                var limit = formatRibuan(limitHutang);
                $("#limit_hutang").val(limit);
                $("#no_ktp").val(data.no_ktp);
                $("#npwp_induk").val(data.npwp_induk);
                $("#npwp").val(data.npwp);
                $("#description").val(data.description);
                $("#bank_account_number").val(data.bank_account_number);
                $("#account_owner").val(data.account_owner);
                $("#bank_name").val(data.bank_name);
                $("#branch_account").val(data.branch_account);
                $("#foto").val(null);

                if (data.foto == null) {
                    var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
                } else {
                    var avatarURL = "{{ asset('storage/customers') }}" + "/" + data.foto;
                }

                $('#profile-preview').attr('src', avatarURL);
                $("#latitude").val(data.latitude);
                $("#longitude").val(data.longitude);
                updateMap(data.latitude, data.longitude);

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
                    url: "{{ url('/customer') }}" + '/' + id,
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
        $("#branch_id").val("");
        $("#nama_lengkap").val("");
        $("#customer_type").val("");
        $("#alamat").val("");
        $("#provinsi").val("");
        $("#kota").html('<option value="" disabled selected>pilih provinsi dahulu</option>');
        $("#kecamatan").html('<option value="" disabled selected>pilih kota dahulu</option>');
        $("#postal_code").val("");
        $("#phone").val("");
        $("#phone2").val("");
        $("#email").val("");
        $("#contact_person").val("");
        $("#email_contact_person").val("");
        $("#contact_person_phone").val("");
        $("#contact_person_phone2").val("");
        $("#status").val("");
        $("#akun_hutang").val("");
        $("#akun_piutang").val("");
        $("#akun_piutang_sementara").val("");
        $("#limit_hutang").val("");
        $("#no_ktp").val("");
        $("#npwp_induk").val("");
        $("#npwp").val("");
        $("#description").val("");
        $("#bank_account_number").val("");
        $("#account_owner").val("");
        $("#bank_name").val("");
        $("#branch_account").val("");
        $("#foto").val(null);

        var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
        $('#profile-preview').attr('src', avatarURL);
    }
</script>

