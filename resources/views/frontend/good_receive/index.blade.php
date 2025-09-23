<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Penerimaan Barang Material Masuk</h4>

                        </div>
                        {{-- <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Penerimaan Barang</button> --}}

                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-success dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tambah Penerimaan barang
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <a onclick="addData()" class="dropdown-item" href="javasript:void(0);">Barang Stok</a>
                                <a onclick="addTitipan()" class="dropdown-item" href="javascript:void(0);">Barang Titipan</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 p-2">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" id="filter_date" class="form-control sm-input">
                                        </div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <div class="form-group">
                                            <label>Vendor</label>
                                            <select id="filter_vendor" class="form-control sm-input">
                                                <option value="" selected>Semua Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <div class="form-group">
                                            <label>Status Barang</label>
                                            <select id="filter_status" class="form-control sm-input">
                                                <option value="" selected>Semua</option>
                                                <option value="1">Dikirim</option>
                                                <option value="2">Outstanding</option>
                                                <option value="3">Proses</option>
                                                <option value="4">Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button id="btn-filter-data" style="margin-top: 38px;" type="button"
                                            class="btn btn-info">Filter</button>
                                    </div>
                                    <div class="col-1">
                                        <button id="btn-refresh-data" style="margin-top: 38px;" type="button"
                                            class="btn btn-success">Refresh</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nomor GR</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Nomor Kontrak</th>
                                        <th scope="col">Gudang</th>
                                        <th scope="col">Mill</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Total Berat Diterima</th>
                                        <th scope="col">Status Barang</th>
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

    @include('frontend.good_receive.modal_add')
    @include('frontend.good_receive.modal_titipan')
   


    <div id="modal-view" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="purchase_id_show">
                <div class="modal-body" id="modal-view-content"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
                    <button style="display: none;" id="btn-reject-data" type="button"
                        class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Revisi</button>
                    <button style="display: none;" id="btn-approve-data" type="button"
                        class="btn btn-success btn-sm"><i class="fa fa-check"></i>Setujui</button>
                    <button style="display: none;" id="btn-propose-data" style="display: none"; type="button"
                        class="btn btn-info btn-sm"><i class="fa fa-arrow-right"></i>Ajukan</button>


                </div>
            </div>
        </div>
    </div>


    <div id="modal-reason" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-reason-content"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>



@include('frontend.good_receive.script')
