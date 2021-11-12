<input type="text" class="form-control datetimepicker-input" id="datetimepicker-{{ $name }}"
       data-bs-toggle="datetimepicker" data-bs-target="#datetimepicker-{{ $name }}" name="{{ $name }}"
       {!! isset($not_required) && $not_required == true ? null : 'required' !!}
/>

@push('javascript')

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        $(function () {
            $('#datetimepicker-{{ $name }}').datetimepicker({
                format: '{{ isset($format) && $format == 'datetime' ? 'DD-MM-YYYY HH:mm' : 'DD-MM-YYYY' }}',
                @isset($placeholder)
                    @if(isset($format) && $format == 'datetime')
                        defaultDate: moment('{{  date('n/j/Y H:i', $placeholder)}}'),
                    @else
                        defaultDate: moment('{{ date('n/j/Y', $placeholder) }}')
                    @endif
                @endisset
            });
        });
    </script>

@endpush