@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Site Settings
@endsection

@section('container')
    <div class="row justify-content-center">

        <div class="col-12 col-md-8 col-xl-6 col-xxl-4">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    Global Site Settings
                </div>

                <div class="card-body">

                    @foreach($settings as $key => $subkeys)

                        <form action="{{ route('settings::update', ['key' => $key]) }}" method="POST">

                            @csrf

                            <b>{{ ucwords(str_replace('_', ' ', $key)) }}</b>
                            <button type="submit" class="btn badge bg-info text-white float-end">Update</button>

                            <table class="table table-responsive table-borderless">

                                @foreach($subkeys as $subkey => $setting)

                                    <tr>

                                        <td class="ps-3 pt-2 col-4">
                                            <label for="{{ "$key-$subkey" }}">{{ str_replace('_', ' ', $subkey) }}</label>
                                        </td>

                                        @if($setting->type == 'list')
                                            <td>
                                                @foreach($setting->value as $value)
                                                    <div class="input-group input-group-sm mb-1">
                                                        <input id="{{ "$key-$subkey" }}" class="form-control"
                                                               type="text" name="{{ $subkey }}[]" value="{{ $value }}" required>
                                                        <button class="list-item-delete input-group-text bg-danger">
                                                            <i class="fas fa-fw fa-trash text-white"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                                <div class="input-group input-group-sm mb-1">
                                                    <input id="{{ "$key-$subkey" }}" class="form-control" type="text"
                                                           name="{{ $subkey }}[]">
                                                    <button class="input-group-text bg-info">
                                                        <i class="fas fa-fw fa-plus-circle text-white"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <input id="{{ "$key-$subkey" }}" class="form-control" type="text" name="{{ $subkey }}"
                                                       value="{{ $setting->value }}" placeholder="{{ $setting->default }}" required>
                                            </td>
                                        @endif

                                    </tr>

                                @endforeach

                            </table>

                        </form>

                    @endforeach

                </div>

            </div>

        </div>

    </div>
@endsection

@push('javascript')
    <script nonce="{{ csp_nonce() }}">
        document.querySelectorAll('.list-item-delete').forEach(el => el.onclick = _ => el.parentNode.remove())
    </script>
@endpush