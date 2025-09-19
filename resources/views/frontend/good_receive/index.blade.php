<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Penerimaan Barang Material Masuk</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Penerimaan Barang</button>

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
                                            <label>Vendor</label>
                                            <select id="filter_vendor" class="form-control">
                                                <option value="" selected>Semua Vendor</option>
                                                {{-- @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                                                @endforeach --}}
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select id="filter_status" class="form-control">
                                                <option value="" selected>Semua</option>
                                                <option value="1">Pengajuan</option>
                                                <option value="2">Tunda</option>
                                                <option value="3">Disetujui</option>
                                                <option value="4">Revisi</option>
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


    <div id="modal-add" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
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
                            <div class="col-9">
                                <table class="table-compact">
                                    <tr>
                                        <th width="10%">&nbsp;&nbsp;&nbsp;&nbsp;Nomor GR</th>
                                        <td width="1%">:</td>
                                        <td width="22%"><input readonly type="text" class="form-control sm-input" id="gr_number" name="gr_number"></td>
                                        <th width="12%">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Pesan</th>
                                        <td width="1%">:</td>
                                        <td width="22%"><input type="date" class="form-control sm-input" id="gr_date" name="gr_date"></td>
                                        <th width="17%">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Jatuh Tempo</th>
                                        <td width="1%">:</td>
                                        <td width="*"><span id="due_date"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Ref PO</th>
                                        <td>:</td>
                                        <td><select class="form-control sm-input" id="po_id" name="po_id">
                                                <option value="" selected disabled>Pilih Purchase Order</option>
                                            </select>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;ID Kontrak</th>
                                        <td>:</td>
                                        <td><input type="text" class="form-control sm-input" id="contact_number" name="contact_number"></td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Kategori</th>
                                        <td>:</td>
                                        <td><span id="product_category">Bahan Baku</span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Vendor</th>
                                        <td></td>
                                        <td rowspan="5"><div style="font-size:11px;line-height:16px;position:relative;top:-18px;" id="vendor_id"></div>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Tujuan</th>
                                        <td></td>
                                        <td rowspan="5"><div style="font-size:11px;line-height:16px;position:relative;top:-26px;" id="warehouse_id"></div></td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Metode Pembayaran</th>
                                        <td>:</td>
                                        <td><span id="payment_method"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Mills</th>
                                        <td>:</td>
                                        <td><span id="mills"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                    
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Metode Pengiriman</th>
                                        <td>:</td>
                                        <td><span id="delivery_method"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Deskripsi</th>
                                        <td>:</td>
                                        <td><span id="description"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Status</th>
                                        <td>:</td>
                                        <td><span id="status"></span></td>
                                    </tr>


                                </table>
                            </div>
                            <div class="col-3"></div>
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
                    <button style="display: none;" id="btn-reject-data" type="button" class="btn btn-danger btn-sm"><i
                            class="fa fa-close"></i> Revisi</button>
                    <button style="display: none;" id="btn-approve-data" type="button" class="btn btn-success btn-sm"><i
                            class="fa fa-check"></i>Setujui</button>
                    <button style="display: none;" id="btn-propose-data" style="display: none"; type="button" class="btn btn-info btn-sm"><i class="fa fa-arrow-right"></i>Ajukan</button>


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
