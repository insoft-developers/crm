 <div id="modal-titipan" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form type="POST" id="form-titipan">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" id="titipan_id" name="titipan_id">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-10">
                                <table class="table-compact">
                                    <tr>
                                        <th width="11%">&nbsp;&nbsp;&nbsp;&nbsp;Nomor Titipan</th>
                                        <td width="1%">:</td>
                                        <td width="18%"><input readonly type="text" class="form-control sm-input"
                                                id="titipan_number" name="titipan_number"></td>
                                        <th width="8%">&nbsp;&nbsp;&nbsp;&nbsp;Kategori</th>
                                        <td width="1%">:</td>
                                        <td width="18%">
                                            <select id="titipan_product_category" name="titipan_product_category" class="form-control sm-input">
                                                <option value="" selected="" disabled="">Pilih Kategori Produk</option>
                                                <option value="bahan-baku">Bahan Baku</option>
                                                <option value="bahan-setengah-jadi">Bahan Setengah Jadi</option>
                                                <option value="barang-jadi">Barang jadi</option>
                                            </select>

                                        </td>
                                        <th width="8%">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal</th>
                                        <td width="1%">:</td>
                                        <td width="15%">
                                            <input type="date" class="form-control sm-input" id="titipan_gr_date" name="titipan_gr_date"> 
                                            
                                        </td>
                                        <th width="8%">&nbsp;&nbsp;&nbsp;&nbsp;Mill</th>
                                        <td width="1%">:</td>
                                        <td width="20%">
                                            <select id="titipan_mills" name="titipan_mills" class="form-control sm-input">
                                                <option value="" selected="" disabled="">Pilih Mills</option>
                                                @foreach($mills as $mill)
                                                <option value="{{ $mill->mills_name }}">{{ $mill->mills_name }}</option>
                                                @endforeach
                                            </select>    
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Pelanggan</th>
                                        <td>:</td>
                                        <td><select class="form-control sm-input" id="customer_id" name="customer_id">
                                                <option value="" selected disabled>Pilih  Pelanggan</option>
                                                @foreach($customers as $cust)
                                                    <option value="{{ $cust->id }}">{{ $cust->nama_lengkap  }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Tujuan</th>
                                        <td>:</td>
                                        <td><select class="form-control sm-input" id="titipan_warehouse_id" name="titipan_warehouse_id">
                                                <option value="" selected disabled>Pilih  Tujuan</option>
                                                @foreach($warehouse as $whs)
                                                    <option value="{{ $whs->id }}">{{ $whs->name  }}</option>
                                                @endforeach
                                            </select></td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Status</th>
                                        <td>:</td>
                                        <td><span id="titipan_status"></span></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        <td rowspan="5">
                                            <div style="font-size:11px;line-height:16px;position:relative;top:0px;"
                                                id="customer_note"></div>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        <td rowspan="5">
                                            <div style="font-size:11px;line-height:16px;position:relative;top:0px;"
                                                id="warehouse_note"></div>
                                        </td>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <td></td>
                                        <td></span></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    


                                </table>
                            </div>
                            <div class="col-2">

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
                                        <div id="product_titipan">

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
                                                    id="titipan_total_weight" name="total_weight">
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
                                                    id="titipan_total_weight_received" name="total_weight_received">
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
                                                    id="titipan_total_weight_outstanding" name="total_weight_outstanding">
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