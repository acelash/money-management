<div class="modal fade" tabindex="-1" role="dialog" id="addCriptoInvestition">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('add-cripto-investition')}}">
            <div class="modal-header">
                <h5 class="modal-title">Add investition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf()

                <div class="form-group">
                    <label for="resource_id" class="col-form-label resource_id_label">To:</label>
                    <select required name="resource_id" id="resource_id" class="form-control">
                        @foreach($resources as $resource)
                            <option value="{{$resource->id}}">{{$resource->currency->code}} {{$resource->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="investition_value" class="col-form-label">Investition Value (USD):</label>
                    <input type="number" class="form-control" required min="0" step="0.0000001" id="investition_value" name="investition_value">
                </div>

                <div class="form-group">
                    <label for="ammount_purchased" class="col-form-label">Amount purchased:</label>
                    <input type="number" class="form-control" required min="0" step="0.0000001" id="ammount_purchased" name="ammount_purchased">
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>