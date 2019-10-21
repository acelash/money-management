<div class="modal fade" tabindex="-1" role="dialog" id="addTransaction">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('add-transaction')}}">
            <div class="modal-header">
                <h5 class="modal-title">Add transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf()
                <input type="hidden" name="type" >
                <input type="hidden" name="is_passive_income" id="is_passive_income" >
                <input type="hidden" name="is_exchange" id="is_exchange" >
                <div class="form-group">
                    <label for="value" class="col-form-label">Value:</label>
                    <input type="number" class="form-control" required min="0" step="1" id="value" name="value">
                </div>
                <div class="form-group">
                    <label for="comment" class="col-form-label">Comment:</label>
                    <input type="text" class="form-control" required maxlength="170" id="comment" name="comment">
                </div>
                <div class="form-group">
                    <label for="resource_id" class="col-form-label resource_id_label">To:</label>
                    <select required name="resource_id" id="resource_id" class="form-control">
                        @foreach($resources as $resource)
                            <option value="{{$resource->id}}">{{$resource->currency->code}} {{$resource->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group is_passive_income_block">
                    <label for="type" class="col-form-label">Is passive income:</label>
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                        <label for="is_passive_income1" class="btn active" onclick="$('#is_passive_income').val(0)">
                            <input type="radio" value="0" name="" id="is_passive_income1" autocomplete="off" checked> No
                        </label>
                        <label for="is_passive_income2" class="btn" onclick="$('#is_passive_income').val(1)">
                            <input type="radio" value="1" name="" id="is_passive_income2" autocomplete="off"> Yes
                        </label>
                    </div>
                </div>
                <div class="form-group is_exchange_block">
                    <label for="type" class="col-form-label">Is exchange:</label>
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                        <label for="is_exchange1" class="btn active" onclick="$('#is_exchange').val(0)">
                            <input type="radio" value="0" name="" id="is_exchange1" autocomplete="off" checked> No
                        </label>
                        <label for="is_exchange2" class="btn" onclick="$('#is_exchange').val(1)">
                            <input type="radio" value="1" name="" id="is_exchange2" autocomplete="off"> Yes
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>