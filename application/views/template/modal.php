<div class="modal fade" id="dynamicModal" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" id="ref" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="email"><small>Province</small></label>
                    <br>
                    <select class="form-control select2 province" tabindex="" name="province" style="width:100%;">
                        
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label required"><small>City/Municipality</small></label>
                    <select class="form-control" tabindex="" name="city" id="city">
                        <option> </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary  btn-materialize btn-materialize-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-materialize btn-materialize-sm" id="save">Save</button>
            </div>
        </div>
    </div>
</div>
