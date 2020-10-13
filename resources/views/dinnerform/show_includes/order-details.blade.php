<form method="post"
      action="{{ (route("dinnerform::order", ['id' => $dinnerform->id]))}}"
      enctype="multipart/form-data">
    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Dinner form Order Details
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-8">

                    <div class="row align-items-end mb-6">

                        <div class="col-md-12 mb-3">

                            <label for="food">What are you ordering?</label>
                            <input type="text" class="form-control" id="dish" name="dish"
                                   placeholder="Nomnomnoms"
                                   value="{{ $order->dish or '' }}"
                                   required>

                        </div>
                    </div>

                    <div class="row align-items-end mb-6">
                        <div class="col-md-12 mb-3">

                            <label for="price">How expensive is it?</label>
                            <input type="text" class="form-control" id="price" name="price"
                                   placeholder="(€X,XX)"
                                   value="{{ $order->price or '' }}"
                                   required>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success" style="margin-left: 15px;">Submit
            </button>
        </div>

    </div>

</form>