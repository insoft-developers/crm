<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Driver Data</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Data Driver</button>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col" style="white-space: normal;">Alamat</th>
                                        <th scope="col">Kota</th>
                                        <th scope="col">No. HP</th>
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
                <form type="POST" id="form-driver">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">

                                <input type="hidden" id="id" name="id">

                                <div class="form-group">
                                    <label>Upload Foto Anda:</label>
                                    <center><img id="profile-preview" class="profile-image-upload"
                                            src="{{ asset('images/avatar_foto.webp') }}"></center>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image"
                                        placeholder="Profile Image Here.." accept=".jpg, .png, .jpeg"
                                        style="display: none;">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nama Driver:</label>
                                    <input type="text" class="form-control" id="driver_name" name="driver_name"
                                        placeholder="masukkan nama driver..">
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir:</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                        placeholder="masukkan tempat lahir..">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir:</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                        placeholder="masukkan tanggal lahir..">
                                </div>


                                <div class="form-group">
                                    <label>Alamat:</label>
                                    <textarea style="height: 155px;" class="form-control" id="address" name="address" placeholder="masukkan alamat.."></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>RT</label>
                                            <input type="text" id="rt" name="rt" class="form-control"
                                                placeholder="masukkan no RT">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>RW</label>
                                            <input type="text" id="rw" name="rw" class="form-control"
                                                placeholder="masukkan no RW">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kecamatan:</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                        placeholder="masukkan nama kecamatan..">
                                </div>
                                <div class="form-group">
                                    <label>Kota:</label>
                                    <input type="text" class="form-control" id="kota" name="kota"
                                        placeholder="masukkan nama kota..">
                                </div>
                                <div class="form-group">
                                    <label>Provinsi:</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi"
                                        placeholder="masukkan nama provinsi..">
                                </div>

                                <div class="form-group">
                                    <label>Nomor KTP/SIM/Paspor:</label>
                                    <input type="text" maxlength="16" pattern="\d{1,16}" inputmode="numeric"
                                        class="form-control" id="personal_identity_number"
                                        name="personal_identity_number" placeholder="masukkan nomor KTP/SIM/Paspor..">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Identitas:</label>
                                    <select class="form-control" id="personal_identity_type"
                                        name="personal_identity_type">
                                        <option value="">Pilih</option>
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="PASPOR">PASPOR</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Foto KTP/SIM/Paspor:</label>
                                    <input type="file" class="form-control" id="personal_identity_image"
                                        name="personal_identity_image" placeholder="masukkan foto identitas diri.."
                                        accept="*.jpg, *.png, *.jpeg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>No HP:</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="masukkan no hp..">
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="masukkan email..">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin:</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="">Pilih</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Agama:</label>
                                    <select class="form-control" id="agama" name="agama">
                                        <option value="">Pilih</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Protestan">Protestan</option>
                                        <option value="Katholik">Katholik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Kong Hu Cu">Kong Hu Cu</option>
                                        <option value="Aliran Kepercayaan">Aliran Kepercayaan</option>
                                        <option value="Lainnya">Lainnya</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Departemen:</label>
                                    <select class="form-control" id="department_id" name="department_id">
                                        <option value="">Pilih</option>
                                        @foreach ($department as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nomor SIM:</label>
                                    <input type="text" class="form-control" id="license_number"
                                        name="license_number" placeholder="masukkan no SIM..">
                                </div>
                                <div class="form-group">
                                    <label>Jenis SIM:</label>
                                    <select class="form-control" id="license_type" name="license_type">
                                        <option value="">Select</option>
                                        @foreach ($license as $l)
                                            <option value="{{ $l->id }}">{{ $l->license_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Foto SIM:</label>
                                    <input type="file" class="form-control" id="license_image"
                                        name="license_image" placeholder="masukkan foto SIM.."
                                        accept="*.jpg, *.png, *.jpeg">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Terbit SIM:</label>
                                    <input type="date" class="form-control" id="license_issue_date"
                                        name="license_issue_date" placeholder="masukkan tanggal terbit SIM..">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Habis Berlaku SIM:</label>
                                    <input type="date" class="form-control" id="license_expired_date"
                                        name="license_expired_date" placeholder="masukkan tanggal habis berlaku SIM.">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk Kerja:</label>
                                    <input type="date" class="form-control" id="joining_date" name="joining_date"
                                        placeholder="masukkan tanggal masuk kerja..">
                                </div>
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select class="form-control" id="is_active" name="is_active">
                                        <option value="">Pilih </option>
                                        <option value="1">Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
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


    <div id="modal-view" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-view-content"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>



<!-- JAVASCRIPT -->
<script>
    const input = document.getElementById('personal_identity_number');

    input.addEventListener('input', function() {
        // Hapus semua karakter non-angka, dan batasi ke 16 digit
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });

    const input_sim = document.getElementById('license_number');

    input_sim.addEventListener('input', function() {
        // Hapus semua karakter non-angka, dan batasi ke 16 digit
        this.value = this.value.replace(/\D/g, '');
    });

    const input_phone = document.getElementById('phone_number');

    input_phone.addEventListener('input', function() {
        // Hapus semua karakter non-angka, dan batasi ke 16 digit
        this.value = this.value.replace(/\D/g, '').slice(0, 13);
    });

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
        ajax: '{{ route('driver.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'driver_name',
                name: 'driver_name'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'kota',
                name: 'kota'
            },
            {
                data: 'phone_number',
                name: 'phone_number'
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
        $(".modal-title").text("Tambah Data Driver");
        $("#modal-add").modal("show");
        var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
        $('#profile-preview').attr('src', avatarURL);

        unloading();
    }

    $("#form-driver").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/driver') }}";
        else url = "{{ url('/driver') . '/' }}" + id;
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
            url: "{{ url('/driver') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data Driver");
                $('#id').val(data.id);
                $("#driver_name").val(data.driver_name);
                $("#phone_number").val(data.phone_number);
                $("#profile_image").val(null);
                $("#gender").val(data.gender);
                $("#is_active").val(data.is_active);
                $("#address").val(data.address);
                $("#personal_identity_number").val(data.personal_identity_number);
                $("#personal_identity_type").val(data.personal_identity_type);
                $("#personal_identity_image").val(null);
                $("#department_id").val(data.department_id);
                $("#joining_date").val(data.joining_date);
                $("#license_number").val(data.license_number);
                $("#license_type").val(data.license_type);
                $("#license_image").val(null);
                $("#license_issue_date").val(data.license_issue_date);
                $("#license_expired_date").val(data.license_expired_date);
                $("#tempat_lahir").val(data.tempat_lahir);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#agama").val(data.agama);
                $("#email").val(data.email);
                $("#rt").val(data.rt);
                $("#rw").val(data.rw);
                $("#kecamatan").val(data.kecamatan);
                $("#kota").val(data.kota);
                $("#provinsi").val(data.provinsi);

                if (data.profile_image == null) {
                    var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
                } else {
                    var avatarURL = "{{ asset('storage/drivers') }}" + "/" + data.profile_image;
                }

                $('#profile-preview').attr('src', avatarURL);
            }
        })
    }


    function copyData(id) {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $.ajax({
            url: "{{ url('/driver') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Copy Data Driver");
                $('#id').val(data.id);
                $("#driver_name").val(data.driver_name);
                $("#phone_number").val(data.phone_number);
                $("#profile_image").val(null);
                $("#gender").val(data.gender);
                $("#is_active").val(data.is_active);
                $("#address").val(data.address);
                $("#personal_identity_number").val(data.personal_identity_number);
                $("#personal_identity_type").val(data.personal_identity_type);
                $("#personal_identity_image").val(null);
                $("#department_id").val(data.department_id);
                $("#joining_date").val(data.joining_date);
                $("#license_number").val(data.license_number);
                $("#license_type").val(data.license_type);
                $("#license_image").val(null);
                $("#license_issue_date").val(data.license_issue_date);
                $("#license_expired_date").val(data.license_expired_date);
                $("#tempat_lahir").val(data.tempat_lahir);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#agama").val(data.agama);
                $("#email").val(data.email);
                $("#rt").val(data.rt);
                $("#rw").val(data.rw);
                $("#kecamatan").val(data.kecamatan);
                $("#kota").val(data.kota);
                $("#provinsi").val(data.provinsi);

                
                var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
                
                $('#profile-preview').attr('src', avatarURL);
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
                    url: "{{ url('/driver') }}" + '/' + id,
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
        $("#driver_name").val("");
        $("#phone_number").val("");
        $("#profile_image").val(null);
        $("#gender").val("");
        $("#is_active").val("");
        $("#address").val("");
        $("#personal_identity_number").val("");
        $("#personal_identity_type").val("");
        $("#personal_identity_image").val(null);
        $("#department_id").val("");
        $("#joining_date").val("");
        $("#license_number").val("");
        $("#license_type").val("");
        $("#license_image").val(null);
        $("#license_issue_date").val("");
        $("#license_expired_date").val("");
        $("#tempat_lahir").val("");
        $("#tanggal_lahir").val("");
        $("#agama").val("");
        $("#email").val("");
        $("#rt").val("");
        $("#rw").val("");
        $("#kecamatan").val("");
        $("#kota").val("");
        $("#provinsi").val("");
    }
</script>
</script>
