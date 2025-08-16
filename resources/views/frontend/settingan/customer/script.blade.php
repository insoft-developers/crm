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
                data: 'customer_code',
                name: 'customer_code'
            },
            {
                data: 'nama_lengkap',
                name: 'nama_lengkap'
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
                data: 'balance',
                name: 'balance',

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
        $(".modal-title").text("Tambah Data Customer");
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
                $('.modal-title').text("Edit Data Customer");
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