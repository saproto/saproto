@if(!$new)

    <form class="form-horizontal" action="{{ route('committee::membership::add') }}" method="post">

        {!! csrf_field() !!}

        <div class="card mb-3">

            <div class="card-header bg-dark text-white">
                Add a member to this committee
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>Member</label>
                    <select class="form-control user-search" name="user_id" required></select>
                    <input type="hidden" name="committee_id" value="{{ $committee->id }}">
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" name="role" placeholder="Developer">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Edition</label>
                            <input type="text" class="form-control" name="edition" placeholder="3.0">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Since</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'start'
                            ])
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Till</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'end',
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

@endif