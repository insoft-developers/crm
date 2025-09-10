<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Product Data</h4>

                        </div>
                        <button onclick="addData()" style="float: right;" type="button"
                            class="btn btn-sm btn-success rounded-pill mt-2">+ Tambah
                            Data Product</button>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Hpp(Rp)</th>
                                        <th scope="col">Price(Rp)</th>
                                        <th scope="col">Panjang(cm)</th>
                                        <th scope="col">Lebar(cm)</th>
                                        <th scope="col">Tebal(cm)</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Weight(gr)</th>
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
                <form type="POST" id="form-product">
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
                                <div class="form-group">
                                    <label>Nama Produk:</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        placeholder="masukkan nama produk..">
                                </div>




                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kategori Produk:</label>
                                    <select class="form-control" id="product_category" name="product_category">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="bahan-baku">Bahan Baku</option>
                                        <option value="bahan-setengah-jadi">Bahan Setengah Jadi</option>
                                        <option value="barang-jadi">Barang Jadi</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Satuan Produk:</label>
                                    <select name="satuan" id="satuan" class="form-control">
                                        <option value="" disabled selected>Pilih satuan…</option>

                                        <optgroup label="Hitungan (Unit)">
                                            <option value="pcs">pcs (piece)</option>
                                            <option value="unit">unit</option>
                                            <option value="buah">buah</option>
                                            <option value="lembar">lembar</option>
                                            <option value="pasang">pasang</option>
                                            <option value="set">set</option>
                                            <option value="paket">paket</option>
                                            <option value="lusin">lusin (12)</option>
                                            <option value="kodi">kodi (20)</option>
                                            <option value="gross">gross (144)</option>
                                            <option value="rim">rim (500 lembar)</option>
                                        </optgroup>

                                        <optgroup label="Kemasan / Packaging">
                                            <option value="box">box / dus</option>
                                            <option value="carton">karton / carton</option>
                                            <option value="case">case</option>
                                            <option value="coli">coli</option>
                                            <option value="pack">pack</option>
                                            <option value="pak">pak</option>
                                            <option value="bungkus">bungkus</option>
                                            <option value="renteng">renteng</option>
                                            <option value="bal">bal</option>
                                            <option value="ikat">ikat / bundle</option>
                                            <option value="sak">sak</option>
                                            <option value="karung">karung</option>
                                            <option value="pouch">pouch</option>
                                            <option value="sachet">sachet</option>
                                            <option value="botol">botol</option>
                                            <option value="kaleng">kaleng</option>
                                            <option value="toples">toples / jar</option>
                                            <option value="tube">tube</option>
                                            <option value="roll">roll</option>
                                            <option value="tray">tray</option>
                                            <option value="krat">krat</option>
                                            <option value="peti">peti</option>
                                            <option value="palet">palet / pallet</option>
                                            <option value="drum">drum</option>
                                            <option value="jerigen">jerigen</option>
                                            <option value="ember">ember</option>
                                            <option value="kontainer">kontainer</option>
                                        </optgroup>

                                        <optgroup label="Berat (Massa)">
                                            <option value="mg">mg (miligram)</option>
                                            <option value="g">g (gram)</option>
                                            <option value="ons">ons (100 g)</option>
                                            <option value="kg">kg (kilogram)</option>
                                            <option value="kwintal">kwintal (100 kg)</option>
                                            <option value="ton">ton (1000 kg)</option>
                                            <option value="lb">lb (pound)</option>
                                        </optgroup>

                                        <optgroup label="Volume (Cairan)">
                                            <option value="ml">mL (mililiter)</option>
                                            <option value="l">L (liter)</option>
                                            <option value="kl">kL (kiloliter)</option>
                                            <option value="galon">galon (≈19 L Indonesia)</option>
                                        </optgroup>

                                        <optgroup label="Panjang">
                                            <option value="mm">mm (milimeter)</option>
                                            <option value="cm">cm (sentimeter)</option>
                                            <option value="m">m (meter)</option>
                                            <option value="km">km (kilometer)</option>
                                            <option value="inchi">inci</option>
                                            <option value="ft">ft (kaki)</option>
                                        </optgroup>

                                        <optgroup label="Luas">
                                            <option value="cm2">cm²</option>
                                            <option value="m2">m²</option>
                                            <option value="are">are</option>
                                            <option value="ha">hektar (ha)</option>
                                        </optgroup>

                                        <optgroup label="Volume (Ruang)">
                                            <option value="cm3">cm³</option>
                                            <option value="m3">m³</option>
                                        </optgroup>

                                        <optgroup label="Panjang Kain & Kertas">
                                            <option value="yard">yard</option>
                                            <option value="meter_lari">meter lari</option>
                                            <option value="roll_kain">roll kain</option>
                                        </optgroup>

                                        <optgroup label="Lainnya (Kontekstual)">
                                            <option value="batang">batang</option>
                                            <option value="butir">butir</option>
                                            <option value="kantong">kantong</option>
                                            <option value="ikat_sayur">ikat (sayur)</option>
                                            <option value="potong">potong</option>
                                            <option value="biji">biji</option>
                                            <option value="helai">helai</option>
                                            <option value="porsi">porsi</option>
                                            <option value="cup">cup</option>
                                            <option value="slice">slice</option>
                                            <option value="stick">stick</option>
                                            <option value="batang_rokok">batang (rokok)</option>
                                        </optgroup>
                                    </select>

                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="bintang">Tipe Harga</label>
                                    <select class="form-control" id="price_type" name="price_type">
                                        <option value="" selected disabled>Pilih Tipe Harga</option>
                                        <option value="0">Harga x Quantity</option>
                                        <option value="1">Harga x Berat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Panjang (cm):</label>
                                    <input type="text" id="panjang" name="panjang" class="form-control"
                                        placeholder="panjang produk">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Lebar (cm):</label>
                                    <input type="text" id="lebar" name="lebar" class="form-control"
                                        placeholder="lebar produk">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tebal (cm):</label>
                                    <input type="text" id="tebal" name="tebal" class="form-control"
                                        placeholder="tebal produk">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Berat (gram):</label>
                                    <input type="text" id="weight" name="weight" class="form-control"
                                        placeholder="berat produk">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Harga:</label>
                                    <input type="number" id="price" name="price" class="form-control"
                                        placeholder="harga jual produk">
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



@include('frontend.product.script')
