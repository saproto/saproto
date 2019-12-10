<form method="post"
      enctype="multipart/form-data">
    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Dinner form Order Details
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="row align-items-end mb-6">

                        <div class="col-md-12 mb-3">

                            <label for="food">What are you ordering?:</label>
                            <input type="text" class="form-control" id="food" name="food"
                                   placeholder="Nomnomnoms"
                                   value="{{ $order->food or '' }}"
                                   required>

                        </div>
                    </div>

                    <div class="row align-items-end mb-6">
                        <div class="col-md-12 mb-3">

                            <label for="price">How expensive is it?:</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   placeholder="(€X,XX)"
                                   value="{{ $order->price or '' }}"
                                   required>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="row align-items-end mb-6">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="dinnerform_start">dinnerform start:</label>
                                @include('website.layouts.macros.datetimepicker', [
                                    'name' => 'start',
                                    'format' => 'datetime',
                                    'placeholder' => $dinnerformCurrent ? $dinnerformCurrent->start : null
                                ])
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="dinnerform_end">dinnerform end:</label>
                                @include('website.layouts.macros.datetimepicker',[
                                    'name' => 'end',
                                    'format' => 'datetime',
                                    'placeholder' => $dinnerformCurrent ? $dinnerformCurrent->end : null
                                ])
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @include('dinnerform.admin_includes.buttonbar')

    </div>

</form>