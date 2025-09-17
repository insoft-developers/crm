<div id="modal-detail" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="customer-detail-container"></div>
                <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Alamat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                            aria-controls="contact" aria-selected="false">Riwayat Pembelian</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-2">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">Alamat Tagihan</div>
                                        <div id="alamat_tagihan_content"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">Account Detail</div>
                                        <div id="account_detail_content"></div>

                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">Penanggung Jawab</div>
                                        <div id="tanggung_jawab_content"></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Alamat Pengiriman</div>
                                <div id="alamat_pengiriman_content"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Riwayat Transaksi</div>
                                <table class="table-compact-border">
                                    <thead>
                                        <tr>
                                            <th>PEMBELIAN</th>
                                            <th>TANGGAL TRANSAKSI</th>
                                            <th>STATUS</th>
                                            <th>TOTAL NOMINAL</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>S0001</td>
                                            <td>2 Februari 2025</td>
                                            <td>Selesai</td>
                                            <td>Rp. 150.000.000</td>
                                            <td>Detail</td>
                                        </tr>
                                        <tr>
                                            <td>S0001</td>
                                            <td>2 Februari 2025</td>
                                            <td>Selesai</td>
                                            <td>Rp. 150.000.000</td>
                                            <td>Detail</td>
                                        </tr>
                                        <tr>
                                            <td>S0001</td>
                                            <td>2 Februari 2025</td>
                                            <td>Selesai</td>
                                            <td>Rp. 150.000.000</td>
                                            <td>Detail</td>
                                        </tr>
                                        <tr>
                                            <td>S0001</td>
                                            <td>2 Februari 2025</td>
                                            <td>Selesai</td>
                                            <td>Rp. 150.000.000</td>
                                            <td>Detail</td>
                                        </tr>
                                        <tr>
                                            <td>S0001</td>
                                            <td>2 Februari 2025</td>
                                            <td>Selesai</td>
                                            <td>Rp. 150.000.000</td>
                                            <td>Detail</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
