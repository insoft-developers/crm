<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Kelola Stok Opname</h4>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2 p-2">
                                        <div class="form-group">
                                            <label>Nama Spec</label>
                                            <input type="text" id="product_name_filter" class="form-control sm-input">
                                        </div>
                                    </div>
                                    <div class="col-2 p-2">
                                        <div class="form-group">
                                            <label>Nomor Coil</label>
                                            <input type="text" id="coil_number_filter" class="form-control sm-input">
                                                
                                        </div>
                                    </div>
                                    <div class="col-2 p-2">
                                        <div class="form-group">
                                            <label>Nomor Barang</label>
                                            <input type="text" id="product_number_filter" class="form-control sm-input">
                                                
                                        </div>
                                    </div>
                                    <div class="col-2 p-2">
                                        <div class="form-group">
                                            <label>Tebal</label>
                                            <input type="text" id="tebal_filter" class="form-control sm-input">
                                                
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
                                        <th scope="col">Nama Spek</th>
                                        <th scope="col">Tebal</th>
                                        <th scope="col">Lebar</th>
                                        <th scope="col">Panjang</th>
                                        <th scope="col">Mill</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Tebal Aktual</th>
                                        <th scope="col">Tebal Fisik</th>
                                        <th scope="col">Nomor Barang</th>
                                        <th scope="col">Nomor Coil</th>
                                        <th scope="col">Berat</th>
                                        <th scope="col">Berat Aktual</th>
                                        <th scope="col">Berat Fisik</th>
                                        <th scope="col">Keterangan</th>
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

    @include('frontend.opname.modal_edit')
    
</x-app-layout>



@include('frontend.opname.script')
