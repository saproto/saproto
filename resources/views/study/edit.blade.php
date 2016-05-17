@extends('website.layouts.panel')

@section('page-title')
    Study Administration
@endsection

@section('panel-title')
    {{ ($new ? "Create new study." : "Edit study " . $study->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($new ? route("study::add") : route("study::edit", ['id' => $study->id])) }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Study:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Creative Technology"
                   value="{{ $study->name or '' }}" required>
        </div>

        <div class="form-group">
            <label for="faculty">Faculty (or similar):</label>
            <input type="text" class="form-control" id="faculty" name="faculty" placeholder="EEMCS"
                   value="{{ $study->faculty or '' }}" required>
        </div>

        <div class="form-group">
            <label for="faculty">Type:</label>
            <select class="form-control" name="type">
                <option value="BSc" {{ (!$new && $study->type == "BSc" ? 'selected' : '') }}>Bachelor</option>
                <option value="MSc" {{ (!$new && $study->type == "MSc" ? 'selected' : '') }}>Master</option>
                <option value="Minor" {{ (!$new && $study->type == "Minor" ? 'selected' : '') }}>Minor</option>
                <option value="Other" {{ (!$new && $study->type == "Other" ? 'selected' : '') }}>Other</option>
            </select>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="utwente" {{ (!$new && $study->utwente ? 'checked' : '') }}>
                This is a study at the University of Twente
            </label>
        </div>

        @if(!$new)

            <hr>

            <table class="table">
                <thead>
                <tr>
                    <th>User count</th>
                    <th>Current</th>
                    <th>Past</th>
                    <th>Future</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Members only</td>
                    <td>{{ count($study->current()) }}</td>
                    <td>{{ count($study->past()) }}</td>
                    <td>{{ count($study->future()) }}</td>
                </tr>
                <tr>
                    <td>All users</td>
                    <td>{{ count($study->current(false)) }}</td>
                    <td>{{ count($study->past(false)) }}</td>
                    <td>{{ count($study->future(false)) }}</td>
                </tr>
                </tbody>
            </table>

        @endif

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("study::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection