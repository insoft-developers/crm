<!-- JAVASCRIPT -->
<script>
    $(".select2").select2({
        theme: 'bootstrap-3', // optional jika pakai tema bootstrap
        dropdownParent: $('#modal-add'), // 🔑 kunci agar muncul di dalam modal
        width: '100%'
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
        ajax: '{{ route('warehouse.table') }}',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'contact',
                name: 'contact'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'province_id',
                name: 'province_id'
            },
            {
                data: 'city_id',
                name: 'city_id'
            },
            {
                data: 'district_id',
                name: 'district_id'
            },
            {
                data: 'postal_code',
                name: 'postal_code'
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
        $(".modal-title").text("Tambah Data Warehouse");
        $("#modal-add").modal("show");
        unloading();
    }

    $("#form-add").submit(function(e) {
        loading();
        e.preventDefault();
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('/warehouse') }}";
        else url = "{{ url('/warehouse') . '/' }}" + id;
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
            url: "{{ url('/warehouse') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Data Warehouse");
                $('#id').val(data.id);
                $("#name").val(data.name);
                $("#contact").val(data.contact);
                $("#address").val(data.address);
                $("#province_id").val(data.province_id).trigger('change');
                $("#postal_code").val(data.postal_code);
                provinsiChange(data.province_id, data.city_id);
                changeCity(data.city_id, data.district_id);
            }
        });
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
                    url: "{{ url('/warehouse') }}" + '/' + id,
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
        $("#name").val("");
        $("#contact").val("");
        $("#address").val("");
        $("#province_id").val("");
        $("#city_id").html('<option value="" selected disabled>Pilih Provinsi Dahulu</option>');
        $("#district_id").html('<option value="" selected disabled>Pilih Kota Dahulu</option>');
        $("#postal_code").val("");
    }

    $("#province_id").change(function() {
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
                html += '<option value="" disabled selected>Pilih Kota</option>';

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

                $("#city_id").html(html);
            }
        });
    }




    $("#city_id").change(function() {
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

                var html = '';
                html += '<option value="" disabled selected>Pilih Kecamatan</option>';

                if (districtId == 0) {
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].subdistrict_id + '">' + data[i]
                            .subdistrict_name + '</option>';
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        let selected = (districtId == data[i].subdistrict_id) ? 'selected' : '';
                        html += '<option value="' + data[i].subdistrict_id + '" ' + selected + '>' +
                            data[i]
                            .subdistrict_name +
                            '</option>';
                    }
                }
                $("#district_id").html(html);
            }
        });
    }
</script>
