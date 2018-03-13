@extends('website.layouts.panel')

@section('page-title')
    Add a course
@endsection

@section('panel-body')

    <form method="post"
          action="{{ route('course::add') }}"
          class="form-horizontal">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="study" class="col-sm-2 control-label">Study</label>

            <div class="col-sm-10 control-label" style="text-align: left;">
                    <select name="study" id="study" class="form-control">
                        <option selected disabled>Study</option>
                        @foreach($studies as $study)
                            <option value="{{ $study->id }}">
                                {{ $study->name }} ({{ $study->type }}), {{ $study->faculty }}
                                ({{ $study->utwente ? 'UT' : 'Non-UT' }})
                            </option>
                        @endforeach
                    </select>
            </div>
        </div>

        <div class="form-group">
            <label for="page" class="col-sm-2 control-label">Page</label>

            <div class="col-sm-10 control-label" style="text-align: left;">
                <select name="page" id="study" class="form-control">
                    <option selected disabled>Page</option>
                    @foreach($pages as $page)
                        <option value="{{ $page->id }}">
                            {{ $page->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="quartile" class="col-sm-2 control-label">Quartile</label>

            <div class="col-sm-10">
                <input type="number" class="form-control" id="quartile" name="quartile">
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="Save">
                <a onClick="javascript:history.go(-1);" class="btn btn-default">Cancel</a>
            </div>

    </form>

@endsection