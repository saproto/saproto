<div class="modal fade" id="addMembership" tabindex="-1" role="dialog" aria-labelledby="addMembershipLabel">
    <div class="modal-dialog" role="document">
        <form action="{{ route("user::member::add", ['id'=>$user->id]) }}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addMembershipLabel">Make member</h4>
                </div>
                <div class="modal-body">
                    @if($user->bank) Cool stuff! We're proud of {{ $user->name }} for joining our awesome association :)
                    We do need a bit more info, though.
                    <br /><br />
                    <div class="form-group">
                        {{ csrf_field() }}
                        <div class="row">
                            <label for="primary_member" class="col-sm-3 control-label">Primary member</label>
                            <div class="col-sm-9">
                                <input type="checkbox" class="form-control" id="primary_member" name="primary_member" value="1" checked="checked">
                            </div>
                        </div>
                        <div class="row">
                            <label for="type" class="col-sm-3 control-label">Member type</label>
                            <div class="col-sm-9">
                                <select name="type" id="type" class="form-control">
                                    <option value="ORDINARY" selected="selected">Ordinary</option>
                                    <option value="ASSOCIATE">Associate</option>
                                    <option value="HONORARY">Honorary</option>
                                    <option value="DONATOR">Donator</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="fee_cycle" class="col-sm-3 control-label">Fee cycle</label>
                            <div class="col-sm-9">
                                <select name="fee_cycle" id="fee_cycle" class="form-control">
                                    <option value="YEARLY" selected="selected">Yearly</option>
                                    <option value="FULLTIME">Fulltime</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @else Please ask {{ $user->name }} to add a bank account to his or her account first. You can then
                    add a membership to the user :)
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Make member</button>
                </div>
            </div>
        </form>
    </div>
</div>