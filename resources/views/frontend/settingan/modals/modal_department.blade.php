<div id="modal-department" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form type="POST" id="form-department">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Departemen:</label>
                            <input type="text" class="form-control" id="department_name" name="department_name"
                                placeholder="Masukkan nama departemen">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button id="btn-save-department" type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>