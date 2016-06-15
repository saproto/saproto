@extends('website.layouts.panel')

@section('page-title')
    Achievement Administration
@endsection

@section('panel-title')
    {{ ($new ? "Create a new Achievement." : "Edit Achievement " . $achievement->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($new ? route("achievement::add") : route("achievement::edit", ['id' => $achievement->id])) }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">achievement:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Achievement name"
                   value="{{ $achievement->name or '' }}" required>
        </div>

        <div class="form-group">
            <label for="faculty">Faculty (or similar):</label>
            <input type="text" class="form-control" id="faculty" name="faculty" placeholder="EEMCS"
                   value="{{ $achievement->faculty or '' }}" required>
        </div>

        <div class="form-group">
            <label for="faculty">Type:</label>
            <select class="form-control" name="type">
                <option value="BSc" {{ (!$new && $achievement->type == "BSc" ? 'selected' : '') }}>Bachelor</option>
                <option value="MSc" {{ (!$new && $achievement->type == "MSc" ? 'selected' : '') }}>Master</option>
                <option value="Minor" {{ (!$new && $achievement->type == "Minor" ? 'selected' : '') }}>Minor</option>
                <option value="Other" {{ (!$new && $achievement->type == "Other" ? 'selected' : '') }}>Other</option>
            </select>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="utwente" {{ (!$new && $achievement->utwente ? 'checked' : '') }}>
                This is a achievement at the University of Twente
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
                    <td>{{ count($achievement->current()) }}</td>
                </tr>
                <tr>
                    <td>All users</td>
                    <td>{{ count($achievement->current(false)) }}</td>
                </tr>
                </tbody>
            </table>

        @endif

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("achievement::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection