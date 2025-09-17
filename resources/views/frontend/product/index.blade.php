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
                                        <th scope="col">Weight(Kg)</th>
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
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="pcs">Pieces</option>
                                        <option value="batang">Batang</option>
                                        <option value="lembar">Lembar</option>
                                        
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

                            <div style="display: none;" class="col-6">
                                <div class="form-group">
                                    <label>Berat (Kilogram):</label>
                                    <input type="text" id="weight" name="weight" class="form-control"
                                        placeholder="berat produk">
                                </div>
                            </div>

                            <div style="display: none;" class="col-6">
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
