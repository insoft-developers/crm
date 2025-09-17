<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Manajemen Data Karyawan</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah Data
                            Karyawan</button>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NIK</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Departemen</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Tanggal Bergabung</th>
                                        <th scope="col">Terakhir Login</th>

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
                            <div class="col-2">
                                <div class="form-group">
                                    <img id="profile-preview" class="profile-image-upload"
                                        src="{{ asset('images/avatar_foto.webp') }}">
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        placeholder="Profile Image Here.." accept=".jpg, .png, .jpeg"
                                        style="display: none;">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="card">

                                    <div class="card-header">
                                        <div class="card-title">
                                            Personal
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Nama</label>
                                                    <input type="text" class="form-control" id="nama_lengkap"
                                                        name="nama_lengkap" placeholder="masukkan nama lengkap">
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" placeholder="tanggal lahir">
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Tempat Lahir</label>
                                                    <input type="text" class="form-control" id="tempat_lahir"
                                                        name="tempat_lahir" placeholder="masukkan tempat lahir">
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Agama</label>
                                                    <select class="form-control" id="agama" name="agama">
                                                        <option value="" disabled selected>Pilih agama</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Protestan">Protestan</option>
                                                        <option value="Katholik">Katholik</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Budha">Budha</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Phone</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        name="phone" placeholder="ex: 082199005656">

                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Jenis Kelamin</label>
                                                    <select class="form-control" id="jenis_kelamin"
                                                        name="jenis_kelamin">
                                                        <option value="" disabled selected>Pilih jenis kelamin
                                                        </option>
                                                        <option value="Laki-Laki">Laki-Laki</option>
                                                        <option value="Perempuan">Perempuan</option>

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label label-insoft">Status Pernikahan</label>
                                                    <select class="form-control" id="status_pernikahan"
                                                        name="status_pernikahan">
                                                        <option value="" disabled selected>Pilih Status
                                                            Pernikahan</option>
                                                        <option value="Nikah">Nikah</option>
                                                        <option value="Belum Nikah">Belum Nikah</option>
                                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                                        <option value="Cerai Mati">Cerai Mati</option>

                                                    </select>

                                                </div>

                                                <div class="form-group">
                                                    <label class="label label-insoft bintang">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder="masukkan email dengan benar ..">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Alamat</label>
                                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="masukkan alamat lengkap customer"></textarea>


                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Provinsi</label>
                                                    <select class="form-control" id="provinsi" name="provinsi">
                                                        <option value="" disabled selected>Pilih provinsi
                                                        </option>
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->province_id }}">
                                                                {{ $province->province_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Kecamatan</label>
                                                    <select class="form-control" id="kecamatan" name="kecamatan">
                                                        <option value="" disabled selected>Pilih kota dahulu
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Latitude</label>
                                                    <input type="text" class="form-control" id="latitude"
                                                        name="latitude" placeholder="bisa pilih melalui map">
                                                </div>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Kabupaten/Kota</label>
                                                    <select class="form-control" id="kota" name="kota">
                                                        <option value="" disabled selected>Pilih provinsi dahulu
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Kode Pos</label>
                                                    <input type="text" class="form-control" id="postal_code"
                                                        name="postal_code" placeholder="masukkan kode pos...">

                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude"
                                                        name="longitude" placeholder="bisa pilih melalui map">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="map" style="height: 200px;"></div>
                                                <div class="clear" style="margin-top:20px"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Perusahaan Detail</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Nomor Induk Karyawan</label>
                                                    <input type="text" class="form-control" id="nik"
                                                        name="nik" placeholder="masukkan nomor induk karyawan">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Cabang</label>
                                                    <select class="form-control" id="branch_id" name="branch_id">
                                                        <option value="" disabled selected>Pilih branch</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}">
                                                                {{ $branch->branch_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <a style="float: right;" onclick="add_branch_data()"
                                                        href="javascript:void(0);"><small>(+) tambah data
                                                            cabang</small></a>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Jabatan</label>
                                                    <select class="form-control" id="jabatan" name="jabatan">
                                                        <option value="" disabled selected>Pilih jabatan</option>
                                                        @foreach ($jabatans as $jabatan)
                                                            <option value="{{ $jabatan->id }}">
                                                                {{ $jabatan->jabatan_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <a style="float: right;" onclick="add_jabatan_data()"
                                                        href="javascript:void(0);"><small>(+) tambah data
                                                            jabatan</small></a>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Status Karyawan</label>
                                                    <select class="form-control" id="status_karyawan"
                                                        name="status_karyawan">
                                                        <option value="" disabled selected>Pilih
                                                        </option>
                                                        <option value="bekerja">Bekerja</option>
                                                        <option value="resign">Resign</option>
                                                        <option value="dipecat">Dipecat</option>
                                                        <option value="pensiun">Pensiun</option>
                                                    </select>

                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Role</label>
                                                    <select class="form-control" id="role" name="role">
                                                        <option value="" disabled selected>Pilih Role</option>
                                                        <option value="role1">Role 1</option>
                                                        <option value="role2 Nikah">Role 2</option>
                                                    </select>

                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Username</label>
                                                    <input type="text" class="form-control" name="username"
                                                        id="username" placeholder="username untuk app user">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Departemen</label>
                                                    <select class="form-control" id="departemen" name="departemen">
                                                        <option value="" disabled selected>Pilih departemen
                                                        </option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}">
                                                                {{ $department->department_name }}</option>
                                                        @endforeach

                                                    </select>
                                                    <a style="float: right;" onclick="add_department_data()"
                                                        href="javascript:void(0);"><small>(+) tambah data
                                                            departemen</small></a>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Gabung dalam perusahaan</label>
                                                    <input type="date" class="form-control" id="tanggal_masuk"
                                                        name="tanggal_masuk" placeholder="tanggal masuk">
                                                    <div style="margin-top:30px"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="label-insoft">Keluar dari perusahaan</label>
                                                    <input type="date" class="form-control" id="tanggal_keluar"
                                                        name="tanggal_keluar"
                                                        placeholder="tanggal berhenti dari perusahaan">

                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Status user</label>

                                                    <select class="form-control" id="status" name="status">
                                                        <option value="" disabled selected>pilih status</option>
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Tidak Aktif</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft">Password</label>
                                                    <input type="text" class="form-control" id="password"
                                                        name="password" placeholder="masukkan user password">

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="card">
                                    <div class="card-header">
                                        <span class="card-title">Document</span>
                                        <button id="add-row" style="float: right;" type="button"
                                            class="btn btn-sm btn-outline-success rounded-pill btn-with-icon"><i
                                                class="fa fa-plus"></i> Tambah Dokumen</button>
                                    </div>
                                    <div class="card-body">
                                        <div id="document-container">

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="card">
                                    <div class="card-header">
                                        <span class="card-title">Bank Account Detail</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Pemegang Kartu</label>
                                                    <input type="text" class="form-control" id="account_owner"
                                                        name="account_owner">
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Nama Bank</label>
                                                    <select class="form-control" id="bank_name" name="bank_name">
                                                        <option value="" selected disabled>Pilih bank</option>
                                                        <option value="bri">Bank BRI</option>
                                                        <option value="bca">Bank BCA</option>
                                                        <option value="cimb">Bank CIMB NIAGA</option>
                                                        <option value="mandiri">Bank Mandiri</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Lokasi Bank</label>
                                                    <input type="text" class="form-control" id="branch_account"
                                                        name="branch_account">
                                                </div>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Nomor Rekening</label>
                                                    <input type="text" class="form-control"
                                                        id="bank_account_number" name="bank_account_number">
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">Nomor Kode Bank</label>
                                                    <input type="text" class="form-control" id="bank_code"
                                                        name="bank_code">
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-insoft bintang">NPWP</label>
                                                    <input type="text" class="form-control" id="npwp"
                                                        name="npwp">
                                                </div>
                                            </div>

                                        </div>
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

    @include('frontend.settingan.modals.modal_cabang')

    @include('frontend.settingan.modals.modal_jabatan')

    @include('frontend.settingan.modals.modal_department')
    @include('frontend.settingan.karyawan.modal_detail')



</x-app-layout>



<!-- JAVASCRIPT -->

<script>
    function detailData(id) {
        $.ajax({
            url: "{{ url('karyawan') }}" + "/" + id,
            type: "GET",
            success: function(data) {
                console.log(data);
                $("#karyawan-detail-container").html(data.html);
                $(".modal-title").text('Detail Data Karyawan');
                $("#modal-detail").modal('show');


                setTimeout(function() {
                    var mapDetail = null;
                    var markerDetail = null;

                    if (!mapDetail) {
                        mapDetail = L.map('map-detail').setView([data.emp.latitude, data.emp
                                .longitude
                            ],
                            15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 12
                        }).addTo(mapDetail);
                        L.marker([data.emp.latitude, data.emp.longitude]).addTo(mapDetail)
                            .bindPopup("Lokasi Karyawan")
                            .openPopup();
                    } else {
                        mapDetail.setView([data.emp.latitude, data.emp.longitude], 15);
                        L.marker([data.emp.latitude, data.emp.longitude]).addTo(mapDetail)
                            .bindPopup("Lokasi Karyawan")
                            .openPopup();
                    }
                }, 300);

            }
        })



    }
</script>

<script>
    let rowCount = 1;

    $("#add-row").click(function() {
        rowCount++;

        let newRow = `
        <div class="row mb-2" id="row_${rowCount}">
            <div class="col-3">
                <img onclick="document_click(${rowCount})" id="document_preview_${rowCount}"
                    class="doc-image-upload"
                    src="{{ asset('storage/doc_icon.png') }}">
                <input onchange="image_onchange(this, ${rowCount})" style="display: none;"
                    type="file" id="document_image_${rowCount}" name="document_image[]"
                    placeholder="foto dokumen" accept=".jpg, .jpeg, .png">
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="document_name_${rowCount}"
                    name="document_name[]" placeholder="nama dokumen">
            </div>


            <div class="col-4">
                <input type="text" class="form-control" id="document_number_${rowCount}"
                    name="document_number[]" placeholder="nomor dokumen">
            </div>
            <div class="col-1">
                <a title="Delete Data" href="javascript:void(0);"
                    onclick="document_remove(${rowCount})"><i
                        class="fa fa-trash fa-tombol-delete"></i></a>
            </div>
        </div>`;

        $("#document-container").append(newRow);
    });


    function document_remove(id) {
        $("#row_" + id).remove();
    }



    function init_document_container() {
        let newRow = `
        <div class="row mb-2" id="row_1">
            <div class="col-3">
                <img onclick="document_click(1)" id="document_preview_1"
                    class="doc-image-upload"
                    src="{{ asset('storage/doc_icon.png') }}">
                <input onchange="image_onchange(this, 1)" style="display: none;"
                    type="file" id="document_image_1" name="document_image[]"
                    placeholder="foto dokumen" accept=".jpg, .jpeg, .png">
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="document_name_1"
                    name="document_name[]" placeholder="nama dokumen">
            </div>


            <div class="col-4">
                <input type="text" class="form-control" id="document_number_1"
                    name="document_number[]" placeholder="nomor dokumen">
            </div>
            <div class="col-1">
                <a title="Delete Data" href="javascript:void(0);"><i
                        class="fa fa-trash fa-tombol-delete"></i></a>
            </div>
        </div>`;

        $("#document-container").html(newRow);

    }
</script>
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
        ajax: '{{ route('karyawan.table') }}',
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
                data: 'nik',
                name: 'nik',


            },
            {
                data: 'nama_lengkap',
                name: 'nama_lengkap'
            },

            {
                data: 'email',
                name: 'email',


            },
            {
                data: 'branch_id',
                name: 'branch_id',


            },
            {
                data: 'departemen',
                name: 'departemen',


            },
            {
                data: 'jabatan',
                name: 'jabatan',


            },
            {
                data: 'tanggal_masuk',
                name: 'tanggal_masuk',


            },
            {
                data: 'updated_at',
                name: 'updated_at',


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
        $(".modal-title").text("Tambah Data Karyawan");
        $("#modal-add").modal("show");
        init_document_container();
        unloading();
    }

    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/karyawan') }}";
        else url = "{{ url('/karyawan') . '/' }}" + id;
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
            url: "{{ url('/karyawan') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data Karyawan");
                $('#id').val(data.karyawan.id);
                $("#branch_id").val(data.karyawan.branch_id);
                $("#nama_lengkap").val(data.karyawan.nama_lengkap);
                $("#nik").val(data.karyawan.nik);
                $("#jabatan").val(data.karyawan.jabatan);
                $("#departemen").val(data.karyawan.departemen);
                $("#agama").val(data.karyawan.agama);
                $("#jenis_kelamin").val(data.karyawan.jenis_kelamin);
                $("#status_pernikahan").val(data.karyawan.status_pernikahan);
                $("#tanggal_lahir").val(data.karyawan.tanggal_lahir);
                $("#tanggal_masuk").val(data.karyawan.tanggal_masuk);
                $("#alamat").val(data.karyawan.alamat);
                $("#provinsi").val(data.karyawan.provinsi);
                provinsiChange(data.karyawan.provinsi, data.karyawan.kota);
                changeCity(data.karyawan.kota, data.karyawan.kecamatan);
                $("#postal_code").val(data.karyawan.postal_code);
                $("#phone").val(data.karyawan.phone);
                $("#phone2").val(data.karyawan.phone2);
                $("#email").val(data.karyawan.email);
                $("#status").val(data.karyawan.status);
                $("#no_ktp").val(data.karyawan.no_ktp);
                $("#npwp").val(data.karyawan.npwp);
                $("#description").val(data.karyawan.description);
                $("#bank_account_number").val(data.karyawan.bank_account_number);
                $("#account_owner").val(data.karyawan.account_owner);
                $("#bank_name").val(data.karyawan.bank_name);
                $("#branch_account").val(data.karyawan.branch_account);
                $("#bank_code").val(data.karyawan.bank_code);
                $("#status_karyawan").val(data.karyawan.status_karyawan);
                $("#role").val(data.karyawan.role);
                $("#tanggal_keluar").val(data.karyawan.tanggal_keluar);
                $("#tempat_lahir").val(data.karyawan.tempat_lahir);
                $("#username").val(data.karyawan.username);
                $("#password").val(data.karyawan.password);
                $("#foto").val(null);

                if (data.karyawan.foto == null) {
                    var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
                } else {
                    var avatarURL = "{{ asset('storage/karyawan') }}" + "/" + data.karyawan.foto;
                }

                $('#profile-preview').attr('src', avatarURL);
                $("#latitude").val(data.karyawan.latitude);
                $("#longitude").val(data.karyawan.longitude);
                updateMap(data.karyawan.latitude, data.karyawan.longitude);

                var data_documents = data.document;

                if (data_documents.length > 0) {
                    $("#document-container").empty(); // clear container
                    rowCount = 1; // reset counter
                    for (var i = 0; i < data_documents.length; i++) {
                        var src_gambar = '';
                        if (data_documents[i].document_image == null) {
                            src_gambar = "{{ asset('storage/doc_icon.png') }}";
                        } else {
                            src_gambar = "{{ asset('storage/documents') }}" + "/" + data_documents[i]
                                .document_image;
                        }
                        rowCount++;
                        let newRow = `
        <div class="row mb-2" id="row_${rowCount}">
            <div class="col-3">
                <input type="hidden" name="document_id[]" value="${data_documents[i].id}">
                <img onclick="document_click(${rowCount})" id="document_preview_${rowCount}"
                    class="doc-image-upload"
                    src="${src_gambar}">
                <input onchange="image_onchange(this, ${rowCount})" style="display: none;"
                    type="file" id="document_image_${rowCount}" name="document_image[]"
                    placeholder="foto dokumen" accept=".jpg, .jpeg, .png">
            </div>
            <div class="col-4">
                <input value="${data_documents[i].document_name}" type="text" class="form-control" id="document_name_${rowCount}"
                    name="document_name[]" placeholder="nama dokumen">
            </div>


            <div class="col-4">
                <input value="${data_documents[i].document_number}" type="text" class="form-control" id="document_number_${rowCount}"
                    name="document_number[]" placeholder="nomor dokumen">
            </div>
            <div class="col-1">
                <a title="Delete Data" href="javascript:void(0);"
                    onclick="document_remove(${rowCount})"><i
                        class="fa fa-trash fa-tombol-delete"></i></a>
            </div>
        </div>`;

                        $("#document-container").append(newRow);

                    }
                }

                console.log(data_documents);


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
                    url: "{{ url('/karyawan') }}" + '/' + id,
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
        $("#nik").val("");
        $("#jabatan").val("");
        $("#departemen").val("");
        $("#agama").val("");
        $("#jenis_kelamin").val("");
        $("#status_pernikahan").val("");
        $("#tanggal_lahir").val("");
        $("#tanggal_masuk").val("");
        $("#alamat").val("");
        $("#provinsi").val("");
        $("#kota").html('<option value="" disabled selected>pilih provinsi dahulu</option>');
        $("#kecamatan").html('<option value="" disabled selected>pilih kota dahulu</option>');
        $("#postal_code").val("");
        $("#phone").val("");
        $("#phone2").val("");
        $("#email").val("");
        $("#status").val("");
        $("#no_ktp").val("");
        $("#npwp_induk").val("");
        $("#npwp").val("");
        $("#description").val("");
        $("#bank_account_number").val("");
        $("#account_owner").val("");
        $("#bank_name").val("");
        $("#branch_account").val("");
        $("#status_karyawan").val("");
        $("#tempat_lahir").val("");
        $("#role").val("");
        $("#username").val("");
        $("#password").val("");
        $("#tanggal_keluar").val("");
        $("#foto").val(null);
        $("#bank_code").val("");
        $("#latitude").val(-6.2);
        $("#longitude").val(106.8167);
        updateMap(-6.2, 106.8167);
       
        var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
        $('#profile-preview').attr('src', avatarURL);
    }
</script>


<script>
    function add_branch_data() {
        $("#modal-cabang").modal("show");
        $(".modal-title").text('Tambah data cabang');
        $("#branch_name").val("");
    }

    $("#form-cabang").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ url('form-add-cabang') }}",
            type: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            success: function(data) {
                if (data.success) {
                    $("#modal-cabang").modal('hide');
                    var html = '';
                    html += '<option value="" selected disabled>Pilih branch</option>';
                    for (var i = 0; i < data.data.length; i++) {
                        html += '<option value="' + data.data[i].id + '">' + data.data[i]
                            .branch_name + '</option>';
                    }

                    $("#branch_id").html(html);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                }
            }
        })
    })
</script>


<script>
    function add_jabatan_data() {
        $("#modal-jabatan").modal("show");
        $(".modal-title").text('Tambah data jabatan');
        $("#jabatan_name").val("");
    }

    $("#form-jabatan").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ url('form-add-jabatan') }}",
            type: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            success: function(data) {
                if (data.success) {
                    $("#modal-jabatan").modal('hide');
                    var html = '';
                    html += '<option value="" selected disabled>Pilih jabatan</option>';
                    for (var i = 0; i < data.data.length; i++) {
                        html += '<option value="' + data.data[i].id + '">' + data.data[i]
                            .jabatan_name + '</option>';
                    }

                    $("#jabatan").html(html);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                }
            }
        })
    })
</script>


<script>
    function add_department_data() {
        $("#modal-department").modal("show");
        $(".modal-title").text('Tambah data departemen');
        $("#department_name").val("");
    }

    $("#form-department").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ url('form-add-department') }}",
            type: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            success: function(data) {
                if (data.success) {
                    $("#modal-department").modal('hide');
                    var html = '';
                    html += '<option value="" selected disabled>Pilih departemen</option>';
                    for (var i = 0; i < data.data.length; i++) {
                        html += '<option value="' + data.data[i].id + '">' + data.data[i]
                            .department_name + '</option>';
                    }

                    $("#departemen").html(html);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "",
                        html: data.message,
                        footer: ''
                    });
                }
            }
        })
    })
</script>
<script>
    function image_onchange(input, id) {
        if (input.files && input.files[0]) {
            document.getElementById('document_preview_' + id).src = URL.createObjectURL(input.files[0]);
        }
    }



    function document_click(id) {
        $('#document_image_' + id).trigger('click');
    }
</script>
