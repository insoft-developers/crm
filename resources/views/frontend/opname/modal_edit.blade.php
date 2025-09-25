  <div id="modal-add" class="modal fade" tabindex="-1">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <form type="POST" id="form-add">
                  {{ csrf_field() }} {{ method_field('POST') }}
                  <input type="hidden" id="id" name="id">
                  <input type="hidden" id="aksi" name="aksi">
                  <div class="modal-header">
                      <h5 class="modal-title"></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div id="row" class="row">

                          <div class="col-2">
                              <div class="form-group">
                                  <label>Spec</label>
                                  <input readonly type="text" class="form-control sm-input" id="product_name"
                                      name="product_name">
                              </div>
                          </div>
                          
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Mill</label>
                                  <input readonly type="text" class="form-control sm-input" id="mills"
                                      name="mills">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Lokasi</label>
                                  <input readonly type="text" class="form-control sm-input" id="location"
                                      name="location">

                              </div>
                          </div>

                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Aktual</label>
                                  <input readonly type="text" class="form-control sm-input" id="tebal_actual"
                                      name="tebal_actual" placeholder="tebal">
                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Fisik</label>
                                  <input type="text" class="form-control sm-input" id="tebal_fisik"
                                      name="tebal_fisik" placeholder="tebal">
                              </div>
                          </div>


                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Nomor</label>
                                  <input readonly type="text" class="form-control sm-input" id="product_number"
                                      name="product_number">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Nomor Coil</label>
                                  <input readonly type="text" class="form-control sm-input" id="coil_number"
                                      name="coil_number">

                              </div>
                          </div>


                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Berat</label>
                                  <input readonly type="number" class="form-control sm-input berat-diterima"
                                      id="weight_received" name="weight_received">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Aktual</label>
                                  <input readonly type="number" class="form-control sm-input berat-order" id="weight_actual"
                                      name="weight_actual" placeholder="berat">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Fisik</label>
                                  <input type="number" class="form-control sm-input berat-order" id="weight_fisik"
                                      name="weight_fisik" placeholder="berat">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Keterangan</label>
                                  <input type="text" class="form-control sm-input berat-order" id="note"
                                      name="note">
                              </div>
                          </div>
                          <div class="col-2 col-custom">
                              <div class="form-group">
                                  <label>Remark</label>
                                  <input type="text" class="form-control sm-input berat-order" id="remark"
                                      name="remark">
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
