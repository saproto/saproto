@extends('website.layouts.panel')

@section('page-title')
    Print Something
@endsection

@section('panel-title')
    What would you like to print today? Think about the trees!
@endsection

@section('panel-body')

    <form method="post" action="{{ route("print::print") }}" enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-12 print__body">

                @if($print->stock <= 0)
                    <p style="color: red;">
                        It is currently not possible to print anything. The reason for this is that either the paper or
                        the toner is empty, or there is a technical difficulty. If you wish to know what is wrong and
                        when you can print again, please ask in the Protopolis.
                    </p>
                @endif

                <p>
                    Here you can upload something to print. Printing something costs
                    €{{ number_format($print->price, 2) }} per
                    page. Prints are printed single-sided, on A4 paper, in black. You can collect your prints in the
                    Protopolis. <strong>Only PDF files can be submitted for printing.</strong> Documents uploaded using
                    this form are deleted every night.
                </p>

                <div class="form-group print__item">
                    <div class="col-md-7">
                        <input type="file" class="form-control" name="file[]"
                               placeholder="Select your file to be uploaded." required>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <input class="form-control" type="number" name="copies[]" value="1" min="1">
                            <span class="input-group-addon">x</span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger pull-right print__delete">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        @endsection

        @section('panel-footer')

            @if (Auth::user()->can('board'))
                <div class="checkbox pull-left">
                    <label>
                        <input type="checkbox" name="free"> I'd like to print for free!
                    </label>
                </div>
            @endif

            @if($print->stock > 0)
                <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>
            @endif

            <a href="#" onclick="javascript:history.go(-1)" class="btn btn-default pull-right">Cancel</a>

            <button id="print__add" type="button" class="btn btn-default pull-right" style="margin-right: 15px;">More!
            </button>

    </form>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $('#print__add').click(function () {

            var oldrow = $('.print__item').last();

            $('.print__body').append(oldrow.wrap('<p/>').parent().html());
            oldrow.unwrap();

        });

        $('div').delegate('.print__delete', 'click', function () {
            if ($('.print__item').length > 1) {
                $(this).parents('.print__item').remove();
            }
        });

    </script>

@endsection