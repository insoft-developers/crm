<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Kelola Permintaan Barang</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Permintaan Barang</button>

                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 p-2">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" id="filter_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select id="filter_status" class="form-control">
                                                <option value="" selected>Semua</option>
                                                <option value="1">Draft</option>
                                                <option value="2">Pengajuan</option>
                                                <option value="3">Disetujui</option>
                                                <option value="4">Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button id="btn-filter-data" style="margin-top: 38px;" type="button" class="btn btn-info">Filter</button>
                                    </div>
                                    <div class="col-1">
                                        <button id="btn-refresh-data" style="margin-top: 38px;" type="button" class="btn btn-success">Refresh</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Permintaan Barang</th>
                                        <th scope="col">Permintaan</th>
                                        <th scope="col">Tanggal Pesan</th>
                                        <th scope="col">Deskripsi</th>
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
                <form type="POST" id="form-purchase-request">
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
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nomor PR</label>
                                            <input readonly type="text" class="form-control" id="pr_number"
                                                name="pr_number">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tanggal Pesan</label>
                                            <input value="{{ date('Y-m-d') }}" type="date" class="form-control" id="request_date"
                                                name="request_date">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select id="product_category" name="product_category" class="form-control">
                                                <option value="" selected disabled>Pilih Kategori Produk</option>
                                                <option value="bahan-baku">Bahan Baku</option>
                                                <option value="bahan-setengah-jadi">Bahan Setengah Jadi</option>
                                                <option value="barang-jadi">Barang jadi</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                     <div class="card-body">
                                        <div class="card-title">Detail Produk</div>
                                        <!-- container untuk menampung semua row -->
                                        <div id="product_items">
                                            <div id="baris_1" class="row"
                                                style="margin-right:-5px; margin-left:-5px;">
                                                <div class="col-3" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Produk</label>
                                                        <select onchange="selected_product(1)" class="form-control select-product-item" id="product_id_1"
                                                            name="product_id[]">
                                                            <option value="" selected disabled>Pilih Produk
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Tebal</label>
                                                        <input readonly type="text" class="form-control"
                                                            id="tebal_1" name="tebal[]">
                                                    </div>
                                                </div>
                                                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Lebar</label>
                                                        <input readonly type="text" class="form-control"
                                                            id="lebar_1" name="lebar[]">
                                                    </div>
                                                </div>
                                                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Panjang</label>
                                                        <input readonly type="text" class="form-control"
                                                            id="panjang_1" name="panjang[]">
                                                    </div>
                                                </div>
                                                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Qty</label>
                                                        <input onkeyup="qty_change(1, this)" type="text" class="form-control selected-qty" id="quantity_1"
                                                            name="quantity[]">
                                                    </div>
                                                </div>
                                                <div class="col-2" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Satuan</label>
                                                        <input readonly type="text" class="form-control"
                                                            id="satuan_1" name="satuan[]">
                                                    </div>
                                                </div>
                                                <div class="col-2" style="padding-left:2px; padding-right:2px;">
                                                    <div class="form-group" style="margin-bottom:5px;">
                                                        <label style="margin-bottom:2px;">Berat (Kg)</label>
                                                        <input type="number" class="form-control"
                                                            id="weight_1" name="weight[]">
                                                        <input type="hidden" id="berat_1">
                                                    </div>
                                                </div>

                                                <div class="col-1" style="padding-left:2px; padding-right:2px;">
                                                    <div style="display:flex; gap:4px;margin-top:20px;">
                                                        <button onclick="add_product_item()" type="button"
                                                            class="btn btn-fixing btn-success">+</button>
                                                        <button onclick="remove_product_item(1)" type="button"
                                                            class="btn btn-fixing btn-danger">-</button>
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
                    
                    
                    <button id="btn-reject-data" style="display: none"; type="button" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Tolak</button>
                    <button id="btn-approve-data" style="display: none"; type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i>Setujui</button>
                    <button id="btn-propose-data" style="display: none"; type="button" class="btn btn-info btn-sm"><i class="fa fa-arrow-right"></i>Ajukan</button>


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



@include('frontend.purchase_request.script')
