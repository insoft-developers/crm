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
                      <div id="row" class="row">
                          <div class="col-1">
                              <div class="form-group">
                                  <label>Nomor SP</label>
                                  <input value="${ save_index == 'edit' ? data.item[i].sp_number : ''}" type="text"
                                      class="form-control sm-input" id="sp_number" name="sp_number">
                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Tgl Kirim</label>
                                  <input type="date" class="form-control sm-input" id="delivery_date"
                                      name="delivery_date">
                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Tgl Datang</label>
                                  <input type="date" class="form-control sm-input" id="arrive_date"
                                      name="arrive_date">
                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Nomor Coil</label>
                                  <input type="text" class="form-control sm-input" id="coil_number"
                                      name="coil_number">
                              </div>
                          </div>

                          <div class="col-2 col-custom">
                              <div class="form-group">
                                  <label>Spec</label>
                                  <input readonly type="text" class="form-control sm-input" id="product_name"
                                      name="product_name">
                                  <input value="${data.item[i].product_id}" type="hidden" id="product_id"
                                      name="product_id">
                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Tebal</label>
                                  <input readonly type="text" class="form-control sm-input" id="tebal"
                                      name="tebal">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Lebar</label>
                                  <input readonly type="text" class="form-control sm-input" id="lebar"
                                      name="lebar">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Panjang</label>
                                  <input readonly type="text" class="form-control sm-input" id="panjang"
                                      name="panjang">

                              </div>
                          </div>

                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Satuan</label>
                                  <input readonly type="text" class="form-control sm-input" id="satuan"
                                      name="satuan">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Berat</label>
                                  <input readonly type="text" class="form-control sm-input berat-order"
                                      id="weight" name="weight">

                              </div>
                          </div>
                          <div class="col-2 col-custom">
                              <div class="form-group">
                                  <label>Received</label>
                                  <input type="number"
                                      class="form-control sm-input berat-diterima" id="weight_received"
                                      name="weight_received" placeholder="Berat">

                              </div>
                          </div>
                          <div class="col-1 col-custom">
                              <div class="form-group">
                                  <label>Lokasi</label>
                                  <select class="form-control sm-input" id="location" name="location">
                                      <option value="" selected disabled>Pilih</option>
                                     
                                  </select>

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
