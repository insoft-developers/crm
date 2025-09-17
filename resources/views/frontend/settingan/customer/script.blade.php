<!-- JAVASCRIPT -->

<script>
    function detailData(id) {

        $.ajax({
            url: "{{ url('customer') }}" + "/" + id,
            type: "GET",
            success: function(data) {
                console.log(data);
                $("#customer-detail-container").html(data['html']);
                $("#alamat_tagihan_content").html(data['alamat_tagihan']);
                $("#alamat_pengiriman_content").html(data['alamat_pengiriman']);
                $("#account_detail_content").html(data['account_detail']);
                $("#tanggung_jawab_content").html(data['tanggung_jawab']);
                $(".modal-title").text("Detail Data Customer");
                $("#modal-detail").modal("show");

                setTimeout(() => {
                    updateMapDetail(data.cust.latitude, data.cust.longitude);
                }, 200);

                $('#profile-tab').on('shown.bs.tab', function() {
                    data.alamat.forEach(function(item, index) {
                        var baris = index + 1;

                        setTimeout(() => {
                            updateDeliveryMap(baris, item.latitude, item.longitude);
                        }, 200);
                    });

                });


                $('#home-tab').on('shown.bs.tab', function() {
                    updateMapDetail(data.cust.latitude, data.cust.longitude);

                });



            }
        })


    }
</script>


<script>
    function updateMapDetail(lat, lng) {
        if (!window.mapDetail) { // variabel khusus modal detail
            window.mapDetail = L.map('map-detail').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(window.mapDetail);

            window.markerDetail = L.marker([lat, lng]).addTo(window.mapDetail);

        } else {
            // Supaya map tampil sempurna setelah modal dibuka
            window.mapDetail.invalidateSize();

            // Update posisi marker
            window.mapDetail.setView([lat, lng], 13);
            window.markerDetail.setLatLng([lat, lng]);
        }
    }

    // Event ketika modal detail ditampilkan
    // $('#modal-detail').on('shown.bs.modal', function(e) {
    //     var button = $(e.relatedTarget);
    //     var lat = button.data('lat') || -6.2;
    //     var lng = button.data('lng') || 106.8167;

    //     updateMapDetail(lat, lng);

    //     // Ini penting supaya map redraw setelah modal muncul
    //     setTimeout(function() {
    //         if (window.mapDetail) {
    //             window.mapDetail.invalidateSize();
    //         }
    //     }, 200);
    // });


    $('#modal-detail').on('hidden.bs.modal', function() {
        if (window.mapDetail) {
            window.mapDetail.remove(); // hapus map dari DOM
            window.mapDetail = null; // reset variable
            window.markerDetail = null;
        }

        // Hapus semua map pengiriman
        for (let mapId in deliveryMaps) {
            if (deliveryMaps[mapId]) {
                deliveryMaps[mapId].remove();
            }
        }
        deliveryMaps = {};
        deliveryMarkers = {};
    });
</script>


<script>
    function hapus_alamat(id) {
        if (id != 1) {
            $("#row_" + id).remove();
        }

    }

    function init_alamat_pengiriman() {
        let newAlamat = `<div class="row alamat-row" id="row_1">
            <div class="col-6">
                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Nama</label>
                            <input class="form-control"
                                type="text"
                                id="nama_pengiriman_1"
                                name="nama_pengiriman[]">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Kontak</label>
                            <input class="form-control"
                                type="text"
                                id="kontak_pengiriman_1"
                                name="kontak_pengiriman[]">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Alamat</label>
                            <textarea id="alamat_pengiriman_1" name="alamat_pengiriman[]" class="form-control">
                </textarea>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Provinsi</label>
                            <select onchange="province_onchange(this)" id="provinsi_pengiriman_1"
                                name="provinsi_pengiriman[]"
                                class="form-control">
                                <option value="" selected
                                    disabled>
                                    Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option
                                        value="{{ $province->province_id }}">
                                        {{ $province->province_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Kabupaten/Kota</label>
                            <select onchange="kota_onchange(this)" id="kota_pengiriman_1"
                                name="kota_pengiriman[]"
                                class="form-control">
                                <option value="" selected
                                    disabled>
                                    Pilih Provinsi Dahulu
                                </option>

                            </select>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Kecamatan</label>
                            <select id="kecamatan_pengiriman_1"
                                name="kecamatan_pengiriman[]"
                                class="form-control">
                                <option value="" selected
                                    disabled>
                                    Pilih Kota Dahulu</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft">Kode
                                Pos</label>
                            <input type="text"
                                id="postal_code_pengiriman_1"
                                name="postal_code_pengiriman[]"
                                class="form-control">

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Latitude</label>
                            <input type="text"
                                class="form-control"
                                id="latitude_pengiriman_1"
                                name="latitude_pengiriman[]">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="label-insoft bintang">Longitude</label>
                            <input type="text"
                                class="form-control"
                                id="longitude_pengiriman_1"
                                name="longitude_pengiriman[]">
                        </div>
                    </div>

                    <div class="col-12">
                        <div id="map_1"
                            style="height: 200px;">
                        </div>
                        <button onclick="hapus_alamat(1)" type="button" class="btn btn-hapus-alamat btn-danger btn-sm mt-2">(-) Hapus Alamat</button>
                    </div>
                </div>
            </div>
            
        </div>`;

        $("#alamat_pengiriman_id").html(newAlamat);

    }


    let alamatIndex = 1;

    function tambah_alamat_pengiriman() {


        alamatIndex++;

        // clone row pertama
        let newRow = $('#row_1').clone();

        // update ID di semua input/select/textarea/map
        newRow.attr('id', 'row_' + alamatIndex);
        newRow.find('[id]').each(function() {
            let oldId = $(this).attr('id');
            let newId = oldId.replace(/\d+$/, alamatIndex);
            $(this).attr('id', newId).val(''); // reset value juga
        });


        // update tombol hapus agar memanggil index baru
        newRow.find('.btn-hapus-alamat').attr('onclick', 'hapus_alamat(' + alamatIndex + ')');
        // ganti ID map
        let mapId = 'map_' + alamatIndex;
        newRow.find('div[id^=map_]').attr('id', mapId);

        // append ke wrapper
        $('#alamat_pengiriman_id').append(newRow);

        // Panggil initMap() untuk row baru

        setTimeout(() => {
            initMap(alamatIndex);
        }, 100);

    }







    function edit_alamat_pengiriman(listData) {
        if (listData.length > 0) {
            let html = "";

            listData.forEach((data, index) => {
                let rowIndex = index + 1;
                alamatIndex++;

                html += `<div class="row alamat-row" id="row_${rowIndex}">
            <div class="col-6">
                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <input type="hidden" id="alamat_id_${rowIndex}" name="alamat_id[]" value="${data.id}">
                            <label class="label-insoft bintang">Nama</label>
                            <input class="form-control"
                                type="text"
                                id="nama_pengiriman_${rowIndex}"
                                name="nama_pengiriman[]"
                                value="${data.nama || ''}">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft bintang">Kontak</label>
                            <input class="form-control"
                                type="text"
                                id="kontak_pengiriman_${rowIndex}"
                                name="kontak_pengiriman[]"
                                value="${data.kontak || ''}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="label-insoft bintang">Alamat</label>
                            <textarea id="alamat_pengiriman_${rowIndex}" 
                                name="alamat_pengiriman[]" 
                                class="form-control">${data.alamat || ''}</textarea>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft bintang">Provinsi</label>
                            <select onchange="province_onchange(this)" 
                                id="provinsi_pengiriman_${rowIndex}"
                                name="provinsi_pengiriman[]"
                                class="form-control">
                                <option value="" disabled>Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->province_id }}"
                                        ${data.province_id == "{{ $province->province_id }}" ? 'selected' : ''}>
                                        {{ $province->province_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft bintang">Kabupaten/Kota</label>
                            <select onchange="kota_onchange(this)"
                                id="kota_pengiriman_${rowIndex}"
                                name="kota_pengiriman[]"
                                class="form-control">
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft bintang">Kecamatan</label>
                            <select id="kecamatan_pengiriman_${rowIndex}"
                                name="kecamatan_pengiriman[]"
                                class="form-control">
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft">Kode Pos</label>
                            <input type="text"
                                id="postal_code_pengiriman_${rowIndex}"
                                name="postal_code_pengiriman[]"
                                class="form-control"
                                value="${data.postal_code || ''}">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft bintang">Latitude</label>
                            <input type="text"
                                class="form-control"
                                id="latitude_pengiriman_${rowIndex}"
                                name="latitude_pengiriman[]"
                                value="${data.latitude || ''}">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-insoft bintang">Longitude</label>
                            <input type="text"
                                class="form-control"
                                id="longitude_pengiriman_${rowIndex}"
                                name="longitude_pengiriman[]"
                                value="${data.longitude || ''}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div id="map_${rowIndex}" style="height: 200px;"></div>
                        <button onclick="hapus_alamat(${rowIndex})" type="button" class="btn btn-hapus-alamat btn-danger btn-sm mt-2">(-) Hapus Alamat</button>
                    </div>
                </div>
            </div>
        </div>`;
            });

            $("#alamat_pengiriman_id").html(html);


            listData.forEach((data, index) => {
                let rowIndex = index + 1;
                let lat = data.latitude || -6.200; // fallback Jakarta
                let lng = data.longitude || 106.816; // fallback Jakarta

                setTimeout(() => {
                    updateDeliveryMap(rowIndex, lat, lng);
                }, 200);
            });
        } else {
            init_alamat_pengiriman();

            setTimeout(() => {
                $("#latitude_pengiriman_1").val(-6.200);
                $("#longitude_pengiriman_1").val(106.816);
                updateDeliveryMap(1, -6.200, 106.816);
            }, 200);
        }


    }


    // object untuk simpan semua map dan marker pengiriman
    let deliveryMaps = {};
    let deliveryMarkers = {};

    function updateDeliveryMap(rowIndex, lat, lng) {
        let mapId = `map_${rowIndex}`;

        // kalau map sudah ada → hapus dulu biar tidak duplicate
        if (deliveryMaps[mapId]) {
            deliveryMaps[mapId].remove();
        }

        // inisialisasi map baru
        let map = L.map(mapId).setView([lat, lng], 15);

        // tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 6,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // tambahkan marker draggable
        let marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);

        // simpan map & marker ke object global
        deliveryMaps[mapId] = map;
        deliveryMarkers[mapId] = marker;

        // update input saat marker digeser
        marker.on('dragend', function() {
            let pos = marker.getLatLng();
            $(`#latitude_pengiriman_${rowIndex}`).val(pos.lat.toFixed(6));
            $(`#longitude_pengiriman_${rowIndex}`).val(pos.lng.toFixed(6));
        });

        // update marker saat user double click di peta
        map.on('dblclick', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);

            marker.setLatLng([lat, lng]);
            $(`#latitude_pengiriman_${rowIndex}`).val(lat);
            $(`#longitude_pengiriman_${rowIndex}`).val(lng);
        });

        // update marker saat input lat/long diubah manual
        $(`#latitude_pengiriman_${rowIndex}, #longitude_pengiriman_${rowIndex}`).off('change').on('change', function() {
            const newLat = parseFloat($(`#latitude_pengiriman_${rowIndex}`).val());
            const newLng = parseFloat($(`#longitude_pengiriman_${rowIndex}`).val());
            if (!isNaN(newLat) && !isNaN(newLng)) {
                const latLng = L.latLng(newLat, newLng);
                marker.setLatLng(latLng);
                map.setView(latLng);
            }
        });

        // fix tampilan map kalau ada di tab/modal
        setTimeout(() => {
            map.invalidateSize();
        }, 200);
    }



    var maps = {}; // simpan semua map berdasarkan index
    var markers = {}; // simpan semua marker berdasarkan index

    // fungsi inisialisasi map
    function initMap(index) {
        var lat = -6.2;
        var lng = 106.8167;

        var mapId = 'map_' + index;
        var latId = '#latitude_pengiriman_' + index;
        var lngId = '#longitude_pengiriman_' + index;

        if (!maps[index]) {
            var map = L.map(mapId).setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            maps[index] = map;
            markers[index] = marker;

            // isi awal
            $(latId).val(lat);
            $(lngId).val(lng);

            // drag
            marker.on('dragend', function() {
                var pos = marker.getLatLng();
                $(latId).val(pos.lat.toFixed(6));
                $(lngId).val(pos.lng.toFixed(6));
            });

            // double click
            map.on('dblclick', function(e) {
                var newLat = e.latlng.lat.toFixed(6);
                var newLng = e.latlng.lng.toFixed(6);
                marker.setLatLng([newLat, newLng]);
                $(latId).val(newLat);
                $(lngId).val(newLng);
            });

            // input manual
            $(latId + ', ' + lngId).off('change.map' + index).on('change.map' + index, function() {
                var la = parseFloat($(latId).val());
                var lo = parseFloat($(lngId).val());
                if (!isNaN(la) && !isNaN(lo)) {
                    var latLng = L.latLng(la, lo);
                    marker.setLatLng(latLng);
                    map.setView(latLng);
                }
            });
        } else {
            setTimeout(function() {
                maps[index].invalidateSize();
            }, 300);
        }
    }

    // Saat modal dibuka → init map pertama
    $('#modal-add').on('shown.bs.modal', function() {
        initMap(1);
    });

    // Saat tab dibuka → resize semua map
    $('a[data-toggle="pill"]').on('shown.bs.tab', function() {
        Object.values(maps).forEach(function(map) {
            setTimeout(() => map.invalidateSize(), 300);
        });
    });
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
        } else {
            // Resize map jika misalnya ditaruh di dalam modal
            map.invalidateSize();

            // Perbarui tampilan peta dan marker
            map.setView([lat, lng], 13);
            marker.setLatLng([lat, lng]);

            // Update input juga
            $('#latitude').val(lat);
            $('#longitude').val(lng);

            marker.on('dragend', function() {
                var pos = marker.getLatLng();
                $('#latitude').val(pos.lat.toFixed(6));
                $('#longitude').val(pos.lng.toFixed(6));
            });

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


    function provinsiChange(provinceId, cityId, angka) {
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


                if (angka == null) {
                    $("#kota").html(html);
                    $("#kecamatan").html(
                        '<option value="" disabled selected>pilih kota dahulu</option>');

                } else {
                    $("#kota_pengiriman_" + angka).html(html);
                    $("#kecamatan_pengiriman_" + angka).html(
                        '<option value="" disabled selected>pilih kota dahulu</option>');
                }



            }
        });
    }




    $("#kota").change(function() {
        var cityId = $(this).val();
        changeCity(cityId, 0);

    });


    function changeCity(cityId, districtId, angka) {
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

                if (angka == null) {
                    $("#kecamatan").html(html);
                } else {
                    $("#kecamatan_pengiriman_" + angka).html(html);
                }
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

        init_alamat_pengiriman();
        unloading();
    }

    $("#form-add").submit(function(e) {
        // loading();
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
                $('#id').val(data.customer.id);

                $("#nama_lengkap").val(data.customer.nama_lengkap);
                $("#tempat_lahir").val(data.customer.tempat_lahir);
                $("#tanggal_lahir").val(data.customer.tanggal_lahir);
                $("#tanggal_aktif").val(data.customer.tanggal_aktif);
                $("#customer_type").val(data.customer.customer_type);
                $("#alamat").val(data.customer.alamat);

                $("#phone").val(data.customer.phone);
                $("#email").val(data.customer.email);
                $("#customer_code").val(data.customer.customer_code);
                $("#nama_tagihan").val(data.customer.nama_tagihan);
                $("#kontak_tagihan").val(data.customer.kontak_tagihan);
                $("#alamat_tagihan").val(data.customer.alamat_tagihan);
                $("#provinsi").val(data.customer.provinsi);
                provinsiChange(data.customer.provinsi, data.customer.kota);
                changeCity(data.customer.kota, data.customer.kecamatan);
                $("#postal_code").val(data.customer.postal_code);

                $("#latitude").val(data.customer.latitude);
                $("#longitude").val(data.customer.longitude);

                $("#status").val(data.customer.status);
                $("#customer_grade").val(data.customer.customer_grade);


                $("#npwp").val(data.customer.npwp);
                $("#bank_account_number").val(data.customer.bank_account_number);
                $("#account_owner").val(data.customer.account_owner);
                $("#bank_name").val(data.customer.bank_name);
                $("#branch_account").val(data.customer.branch_account);
                $("#bank_code").val(data.customer.bank_code);

                $("#nama_penanggung_jawab").val(data.customer.nama_penanggung_jawab);
                $("#kontak_penanggung_jawab").val(data.customer.kontak_penanggung_jawab);
                $("#jabatan_penanggung_jawab").val(data.customer.jabatan_penanggung_jawab);
                $("#email_penanggung_jawab").val(data.customer.email_penanggung_jawab);

                $("#foto").val(null);

                if (data.customer.foto == null) {
                    var avatarURL = "{{ asset('images/avatar_foto.webp') }}";
                } else {
                    var avatarURL = "{{ asset('storage/customers') }}" + "/" + data.customer.foto;
                }

                $('#profile-preview').attr('src', avatarURL);

                setTimeout(() => {
                    updateMap(data.customer.latitude, data.customer.longitude);


                }, 200);

                // ==============================
                // Tab 2 (alamat pengiriman)
                // ==============================
                // if (data.alamat && data.alamat.length > 0) {
                // Render alamat langsung
                edit_alamat_pengiriman(data.alamat);

                data.alamat.forEach(function(item, index) {
                    var baris = index + 1;
                    provinsiChange(item.province_id, item.city_id, baris);
                    changeCity(item.city_id, item.district_id, baris);

                });
                // }

                $('#pills-profile-tab').on('shown.bs.tab', function() {


                    data.alamat.forEach(function(item, index) {
                        var baris = index + 1;
                        setTimeout(() => {
                            updateDeliveryMap(baris, item.latitude, item.longitude);
                        }, 200);

                    });

                });




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
        $("#nama_lengkap").val("");
        $("#customer_type").val("");
        $("#alamat").val("");
        $("#provinsi").val("");
        $("#kota").html('<option value="" disabled selected>pilih provinsi dahulu</option>');
        $("#kecamatan").html('<option value="" disabled selected>pilih kota dahulu</option>');
        $("#postal_code").val("");
        $("#phone").val("");
        $("#email").val("");
        $("#status").val("");
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


    function province_onchange(el) {
        let indeks = el.id;
        let angka = indeks.replace(/\D/g, ""); // hasil: "1"
        let provinceId = el.value;

        provinsiChange(provinceId, 0, angka);
    }



    function kota_onchange(el) {
        let indeks = el.id;
        let angka = indeks.replace(/\D/g, ""); // hasil: "1"
        let cityId = el.value;

        changeCity(cityId, 0, angka);
    }


    let mapss = {};
    let markerss = {};

    function updateMaps(mapIndex, lat, lng) {
        let mapId = "map_" + mapIndex;
        let latInput = "#latitude_pengiriman_" + mapIndex;
        let lngInput = "#longitude_pengiriman_" + mapIndex;

        if (!mapss[mapId]) {
            // Buat map baru
            mapss[mapId] = L.map(mapId).setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapss[mapId]);

            // Tambahkan marker draggable
            markerss[mapId] = L.marker([lat, lng], {
                draggable: true
            }).addTo(mapss[mapId]);

            // Isi input awal
            $(latInput).val(lat);
            $(lngInput).val(lng);

            // Event marker digeser
            markerss[mapId].on('dragend', function() {
                const pos = markerss[mapId].getLatLng();
                $(latInput).val(pos.lat.toFixed(6));
                $(lngInput).val(pos.lng.toFixed(6));
            });

            // Event double click → pindah marker
            mapss[mapId].on('dblclick', function(e) {
                const newLat = e.latlng.lat.toFixed(6);
                const newLng = e.latlng.lng.toFixed(6);
                markerss[mapId].setLatLng([newLat, newLng]);

                $(latInput).val(newLat);
                $(lngInput).val(newLng);
            });

            // Event input manual
            $(latInput + ", " + lngInput).on('change', function() {
                const newLat = parseFloat($(latInput).val());
                const newLng = parseFloat($(lngInput).val());
                if (!isNaN(newLat) && !isNaN(newLng)) {
                    const latLng = L.latLng(newLat, newLng);
                    markerss[mapId].setLatLng(latLng);
                    mapss[mapId].setView(latLng);
                }
            });

        } else {
            // Kalau map sudah ada → update saja
            mapss[mapId].invalidateSize();
            mapss[mapId].setView([lat, lng], 13);
            markerss[mapId].setLatLng([lat, lng]);

            $(latInput).val(lat);
            $(lngInput).val(lng);
        }
    }

    $('#modal-detail').on('shown.bs.modal', function() {
        // Aktifkan tab "Home"
        $('#home-tab').tab('show');
    });
</script>
