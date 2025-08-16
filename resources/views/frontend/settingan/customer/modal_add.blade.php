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
                    <div class="card">

                        <div class="card-body">
                            <div class="card-title">Info Dasar</div>
                            <div class="row">
                                <div class="col-2">
                                    <img id="profile-preview" class="profile-image-upload"
                                        src="{{ asset('images/avatar_foto.webp') }}">
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        placeholder="Profile Image Here.." accept=".jpg, .png, .jpeg"
                                        style="display: none;">
                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="label-insoft bintang">Nama</label>
                                                <input type="text" class="form-control" id="nama_lengkap"
                                                    name="nama_lengkap">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="label-insoft bintang">Tempat Lahir</label>
                                                <input type="text" class="form-control" id="tempat_lahir"
                                                    name="tempat_lahir">
                                            </div>

                                            <div class="form-group">
                                                <label class="label-insoft bintang">Kontak</label>
                                                <input type="text" class="form-control" id="phone"
                                                    name="phone">
                                            </div>


                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="label-insoft bintang">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir"
                                                    name="tanggal_lahir">
                                            </div>

                                            <div class="form-group">
                                                <label class="label-insoft bintang">Email</label>
                                                <input type="email" class="form-control" id="email"
                                                    name="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="label-insoft bintang">Tanggal aktif</label>
                                                <input type="date" class="form-control" id="tanggal_aktif"
                                                    name="tanggal_aktif">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="label-insoft bintang">Tipe Customer</label>
                                                <select class="form-control" id="tanggal_aktif" name="tanggal_aktif">
                                                    <option value="" selected disabled>Pilih tipe customer
                                                    </option>
                                                    <option value="distributor">Distributor</option>
                                                    <option value="retail">Retail</option>
                                                    <option value="end_user">End User</option>
                                                    <option value="distributor">Reseller</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
                                                href="#pills-home" role="tab" aria-controls="pills-home"
                                                aria-selected="true">Detail</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                                href="#pills-profile" role="tab" aria-controls="pills-profile"
                                                aria-selected="false">Alamat</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content" id="pills-tabContent-2">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                            aria-labelledby="pills-home-tab">


                                            <div class="row">

                                                <div class="col-6">
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <div class="card-title">Alamat Tagihan</div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Nama</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_tagihan" name="nama_tagihan">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Kontak</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kontak_tagihan" name="kontak_tagihan">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Alamat</label>
                                                                        <textarea class="form-control" id="alamat_tagihan" name="alamat_tagihan"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Provinsi</label>
                                                                        <select class="form-control" id="provinsi"
                                                                            name="provinsi">
                                                                            <option value="" disabled selected>
                                                                                Pilih
                                                                                provinsi</option>
                                                                            @foreach ($provinces as $province)
                                                                                <option
                                                                                    value="{{ $province->province_id }}">
                                                                                    {{ $province->province_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Kabupaten/Kota</label>
                                                                        <select class="form-control" id="kota"
                                                                            name="kota">
                                                                            <option value="" disabled selected>
                                                                                Pilih
                                                                                provinsi dahulu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Kecamatan</label>
                                                                        <select class="form-control" id="kecamatan"
                                                                            name="kecamatan">
                                                                            <option value="" disabled selected>
                                                                                Pilih
                                                                                kota dahulu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft">Kode
                                                                            Pos</label>
                                                                        <input class="form-control" type="text"
                                                                            id="postal_code" name="postal_code">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Latitude</label>
                                                                        <input class="form-control" type="text"
                                                                            id="latitude" name="latitude">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">Longitude</label>
                                                                        <input class="form-control" type="text"
                                                                            id="longitude" name="longitude">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12">

                                                                    <div id="map" style="height: 200px;"></div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <div class="card-title">Account Detail</div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft bintang">Pemegang
                                                                            Kartu</label>
                                                                        <input type="text" class="form-control"
                                                                            id="account_owner" name="account_owner">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft bintang">Nomor
                                                                            Rekening</label>
                                                                        <input type="text" class="form-control"
                                                                            id="bank_account_number"
                                                                            name="bank_account_number">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft bintang">Nama
                                                                            Bank</label>
                                                                        <select class="form-control" id="bank_name"
                                                                            name="bank_name">
                                                                            <option value="" disabled selected>
                                                                                Pilih Bank</option>
                                                                            <option value="bank-bri">Bank BRI</option>
                                                                            <option value="bank-bni">Bank BNI</option>
                                                                            <option value="bank-mandiri">Bank Mandiri
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft bintang">Nomor
                                                                            Kode Bank</label>
                                                                        <input type="text" class="form-control"
                                                                            id="bank_code" name="bank_code">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft bintang">Lokasi
                                                                            Bank</label>
                                                                        <input type="text" class="form-control"
                                                                            id="branch_account" name="branch_account">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="label-insoft bintang">NPWP</label>
                                                                        <input type="text" class="form-control"
                                                                            id="npwp" name="npwp">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="card-title">Penanggung Jawab</div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft">Nama</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_penanggung_jawab"
                                                                            name="nama_penanggung_jawab">
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft">Jabatan</label>
                                                                        <input type="text" class="form-control"
                                                                            id="jabatan_penanggung_jawab"
                                                                            name="jabatan_penanggung_jawab">
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft">Kontak</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kontak_penanggung_jawab"
                                                                            name="kontak_penanggung_jawab">
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="label-insoft">Email</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email_penanggung_jawab"
                                                                            name="email_penanggung_jawab">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>



                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                            aria-labelledby="pills-profile-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="card-title">Alamat Pengiriman</div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <button onclick="tambah_alamat_pengiriman()"
                                                                type="button" style="float: right;"
                                                                class="btn btn-sm btn-success">(+)
                                                                Tambah Alamat</button>
                                                                </div>
                                                            </div>
                                                            
                                                            

                                                            <div id="alamat_pengiriman_id">
                                                                <div class="row alamat-row" id="row_1">
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
                                                                                    <select id="provinsi_pengiriman_1"
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
                                                                                    <select id="kota_pengiriman_1"
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
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
