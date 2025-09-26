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
                            <div class="col-12">
                                <table class="table-compact">
                                    <tr>
                                        <th width="8%">&nbsp;&nbsp;&nbsp;&nbsp;Nomor GR</th>
                                        <td width="1%">:</td>
                                        <td width="18%"><input readonly type="text" class="form-control sm-input"
                                                id="gr_number" name="gr_number"></td>
                                        <th width="10%">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Pesan</th>
                                        <td width="1%">:</td>
                                        <td width="18%"><input type="date" class="form-control sm-input"
                                                id="gr_date" name="gr_date"></td>
                                        <th width="13%">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Jatuh Tempo</th>
                                        <td width="1%">:</td>
                                        <td width="18%"><span id="due_date"></span></td>
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
                                        <td><input type="text" class="form-control sm-input" id="contract_number"
                                                name="contract_number"></td>
                                                <th>&nbsp;&nbsp;&nbsp;&nbsp;SP Number</th>
                                        <td>:</td>
                                        <td><input type="text" class="form-control sm-input" id="sp_number"
                                                name="sp_number"></td>
                                        {{-- <th>&nbsp;&nbsp;&nbsp;&nbsp;Kategori</th>
                                        <td>:</td>
                                        <td><span id="product_category"></span></td> --}}
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;Vendor</th>
                                        <td style="vertical-align: top;"></td>
                                        <td style="vertical-align: top;" rowspan="5">
                                            <div style="font-size:11px;line-height:16px;margin-top:8px;"
                                                id="vendor_id"></div>
                                        </td>
                                        <th style="vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;Tujuan</th>
                                        <td style="vertical-align: top;"></td>
                                        <td style="vertical-align: top;" rowspan="5">
                                            <div style="font-size:11px;line-height:16px;margin-top:8px;"
                                                id="warehouse_id"></div>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Metode Pembayaran</th>
                                        <td>:</td>
                                        <td><span id="payment_method"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>

                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>

                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Kategori</th>
                                        <td>:</td>
                                        <td><span id="product_category"></span></td>
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

                                        <th style="vertical-align: top;">&nbsp;&nbsp;&nbsp;&nbsp;Deskripsi</th>
                                        <td style="vertical-align: top;">:</td>
                                        <td style="vertical-align: top;"><span id="description"></span></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        <td rowspan="5">
                                            <div></div>
                                        </td>
                                        <th></th>
                                        <td></td>
                                        <td>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Status</th>
                                        <td>:</td>
                                        <td><span id="status"></span></td>
                                    </tr>


                                </table>
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

                                            {{-- <center>Belum ada daftar produk</center> --}}

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8" style="padding-left:0px; padding-right:0px;"></div>
                                            <div class="col-2"
                                                style="font-size:13px;margin-left:-10px;padding-left:0px; padding-right:0px; text-align:left; display:flex; align-items:center; justify-content:flex-start;">
                                                Total Berat Order&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-2" style="padding-left:2px; padding-right:0px;">
                                                <input type="text" readonly class="form-control sm-input"
                                                    id="total_weight" name="total_weight">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-8" style="padding-left:2px; padding-right:2px;"></div>
                                            <div class="col-2"
                                                style="font-size:13px;margin-left:-10px;padding-left:0px; padding-right:0px; text-align:left; display:flex; align-items:center; justify-content:flex-start;">
                                                Total Berat Diterima&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-2" style="padding-left:2px; padding-right:0px;">
                                                <input type="text" readonly class="form-control sm-input"
                                                    id="total_weight_received" name="total_weight_received">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-8" style="padding-left:2px; padding-right:2px;"></div>
                                            <div class="col-2"
                                                style="font-size:13px;margin-left:-10px;padding-left:0px; padding-right:0px; text-align:left; display:flex; align-items:center; justify-content:flex-start;">
                                                Total Berat Outstanding&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                            <div class="col-2" style="padding-left:2px; padding-right:0px;">
                                                <input type="text" readonly class="form-control sm-input"
                                                    id="total_weight_outstanding" name="total_weight_outstanding">
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