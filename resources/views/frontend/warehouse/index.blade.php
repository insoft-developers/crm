<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Warehouse (Gudang)</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Data Warehouse</button>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kontak</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Provinsi</th>
                                        <th scope="col">Kota</th>
                                        <th scope="col">Kecamatan</th>
                                        <th scope="col">Kode Pos</th>
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
                    <input type="hidden" id="id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Warehouse (Gudang):</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="masukkan nama gudang..">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kontak:</label>
                                    <input type="text" class="form-control" id="contact" name="contact"
                                        placeholder="masukkan nomor kontak..">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea id="address" name="address" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select style="width: 100%;" id="province_id" name="province_id" class="form-control select2">
                                        <option value="" selected disabled>Pilih Provinsi</option>
                                        @foreach($provinces as $pro)
                                            <option value="{{ $pro->province_id }}">{{ $pro->province_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <select id="city_id" name="city_id" class="form-control select2">
                                        <option value="" selected disabled>Pilih Provinsi Dahulu</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select id="district_id" name="district_id" class="form-control select2">
                                        <option value="" selected disabled>Pilih Kota Dahulu</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kode POS</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code">
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



@include('frontend.warehouse.script')
