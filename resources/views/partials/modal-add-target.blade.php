<div class="modal fade" tabindex="-1" role="dialog" id="addTarget">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('add-target')}}">
            <div class="modal-header">
                <h5 class="modal-title">Add target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf()
                <div class="form-group">
                    <label for="value" class="col-form-label">Size:</label>
                    <input type="number" class="form-control" required min="0" step="1" id="value" name="value">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>