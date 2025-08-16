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