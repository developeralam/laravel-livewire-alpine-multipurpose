@props(['id', 'error'])
<input {{$attributes}} type="text" id="appointmentTimeInput" class="form-control datetimepicker-input @error($error) is-invalid @enderror" data-target="#{{$id}}" onchange="this.dispatchEvent(new InputEvent('input'))"/>
@push('js')
    <script>
        $('#{{$id}}').datetimepicker({
            format: 'LT'
        });
    </script>
@endpush
