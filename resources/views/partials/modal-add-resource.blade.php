<div class="modal fade" tabindex="-1" role="dialog" id="addResource">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('add-resource')}}">
            <div class="modal-header">
                <h5 class="modal-title">Add resource</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf()
                <div class="form-group">
                    <label for="name" class="col-form-label">Name:</label>
                    <input type="text" class="form-control" required maxlength="140" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="currency_id" class="col-form-label">Currency:</label>
                    <select required name="currency_id" id="currency_id" class="form-control">
                        @foreach($currencies as $currency)
                            <option value="{{$currency->id}}">{{$currency->name}}</option>
                        @endforeach
                    </select>
                </div>
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