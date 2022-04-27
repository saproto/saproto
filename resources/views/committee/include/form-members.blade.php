<form class="form-horizontal" action="{{ route('committee::membership::add') }}" method="post">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Add a member to this committee
        </div>

        <div class="card-body">

                <div class="form-group">
                    <div class="form-group autocomplete">
                        <label>Member</label>
                        <input class="form-control user-search" name="user_id" required/>
                    </div>
                    <input type="hidden" name="committee_id" value="{{ $committee->id }}">
                </div>

            <div class="row">

                <div class="col-6">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input id="role" class="form-control" name="role" type="text"  placeholder="Developer">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="edition">Edition</label>
                        <input id="edition" class="form-control" name="edition" type="text" placeholder="X.0">
                    </div>
                </div>
            </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Since</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'start',
                                'label' => 'Since'
                            ])
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Until</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'end',
                                'label' => 'Until',
                                'not_required' => true
                            ])
                        </div>
                    </div>
                </div>
            </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success btn-block float-end">
                Add
            </button>

        </div>

    </div>

</form>