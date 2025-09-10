<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Kelola Pembelian Barang</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Pembelian Barang</button>

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
                                        <th scope="col">Nomor PO</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Nomor Kontrak</th>
                                        <th scope="col">Tanggal Pembelian</th>
                                        <th scope="col">Gudang</th>
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
                <form type="POST" id="form-purchase-order">
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
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Permintaan Barang (PR)</label>
                                    <select id="purchase_request_id" name="purchase_request_id" class="form-control">
                                        <option value="" selected disabled>Pilih Nomor Permintaan Barang
                                        </option>
                                        @foreach ($prs as $pr)
                                            <option value="{{ $pr->id }}">{{ $pr->pr_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-1" style="margin-left: -22px;">
                                <button id="btn-proses-data" style="margin-top: 29px;" type="button"
                                    class="btn btn-info">Proses</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="bintang">Vendor</label>
                                    <select class="form-control" id="vendor_id" name="vendor_id">
                                        <option value="" selected disabled>Pilih Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label class="bintang">Tujuan</label>
                                    <select class="form-control" id="vendor_address_id" name="vendor_address_id">
                                        <option value="" selected disabled>Pilih Vendor Dahulu</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="bintang">Nomor PO</label>
                                    <input class="form-control" type="text" id="purchase_order_number"
                                        name="purchase_order_number" readonly>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="bintang">Tanggal Pesan</label>
                                    <input value="{{ date('Y-m-d') }}" class="form-control" type="date"
                                        id="purchase_order_date" name="purchase_order_date">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="bintang">Mill</label>
                                    <input value="Dexin" class="form-control" type="text" id="mill"
                                        name="mill">
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-3">
                                <div class="note-list" id="vendor-note"></div>
                            </div>
                            <div class="col-3">
                                <div class="note-list" id="vendor-address-note"></div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input readonly type="text" class="form-control" id="product_category"
                                        name="product_category">

                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label class="bintang">Metode Pembayaran</label>
                                    <select class="form-control" id="payment_method" name="payment_method">
                                        <option value="" selected disabled>Pilih Metode Pembayaran</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="bintang">Metode Pengiriman</label>
                                    <select class="form-control" id="delivery_method" name="delivery_method">
                                        <option value="" selected disabled>Pilih Metode Pengiriman</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="bintang">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="card-title" style="background: beige;padding:10px;">
                                            Detail Produk
                                        </div>
                                        <!-- container untuk menampung semua row -->
                                        <div id="product_items">
                                            <center>Belum ada daftar produk</center>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8" style="padding-left:0px; padding-right:0px;"></div>
                                            <div class="col-2"
                                                style="margin-left:-10px;padding-left:0px; padding-right:0px; text-align:right; display:flex; align-items:center; justify-content:flex-end;">
                                                Subtotal&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-2" style="padding-left:2px; padding-right:0px;">
                                                <input type="text" readonly class="form-control" id="subtotal"
                                                    name="subtotal">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-8" style="padding-left:2px; padding-right:2px;"></div>
                                            <div class="col-2"
                                                style="margin-left:-10px;padding-left:0px; padding-right:0px; text-align:right; display:flex; align-items:center; justify-content:flex-end;">
                                                Pajak&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-2" style="padding-left:2px; padding-right:0px;">
                                                <input type="text" readonly class="form-control" id="total_tax"
                                                    name="total_tax">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-8" style="padding-left:2px; padding-right:2px;"></div>
                                            <div class="col-2"
                                                style="margin-left:-10px;padding-left:0px; padding-right:0px; text-align:right; display:flex; align-items:center; justify-content:flex-end;">
                                                Jumlah Total&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-2" style="padding-left:2px; padding-right:0px;">
                                                <input type="text" readonly class="form-control" id="total_price"
                                                    name="total_price">
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
                    <button id="btn-reject-data" type="button" class="btn btn-danger btn-sm"><i
                            class="fa fa-close"></i> Tolak</button>
                    <button id="btn-approve-data" type="button" class="btn btn-success btn-sm"><i
                            class="fa fa-check"></i>Setujui</button>

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



@include('frontend.purchase_order.script')
