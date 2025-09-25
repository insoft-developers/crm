<x-app-layout>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Prefix Setting</h4>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Purchase Request</th>
                                        <th scope="col">Purchase Order</th>
                                        <th scope="col">Good Receive</th>
                                        <th scope="col">Titipan Number</th>
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
                                <div class="form-group">
                                    <label>Purchase Request:</label>
                                    <input type="text" class="form-control" id="purchase_request" name="purchase_request"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Purchase Order:</label>
                                    <input type="text" class="form-control" id="purchase_order" name="purchase_order"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Good Receive:</label>
                                    <input type="text" class="form-control" id="good_receive" name="good_receive"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Titipan:</label>
                                    <input type="text" class="form-control" id="titipan" name="titipan"
                                        placeholder="">
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

</x-app-layout>



@include('frontend.prefix.script')
