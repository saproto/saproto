<input type="text" class="form-control datetimepicker-input" id="datetimepicker-{{ $name }}"
       data-toggle="datetimepicker" data-target="#datetimepicker-{{ $name }}" name="{{ $name }}"
       {!! isset($not_required) && $not_required == true ? null : 'required' !!}
/>

@push('javascript')

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker-{{ $name }}').datetimepicker({
                @if(isset($format) && $format == 'datetime')
                    format: 'DD-MM-YYYY HH:mm',
                @else
                    format: 'DD-MM-YYYY',
                @endif

                @if(isset($placeholder) && $placeholder !== null)
                    @if(isset($format) && $format == 'datetime')
                        defaultDate: '{{ date('n/j/Y H:i', $placeholder) }}',
                    @else
                        defaultDate: '{{ date('n/j/Y', $placeholder) }}',
                    @endif
                @endif
            });
        });
    </script>

@endpush