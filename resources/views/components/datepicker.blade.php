@props(['id'])
<input type="text" class="form-control datetimepicker-input" id="appointmentDateInput" data-target="#{{$id}}" />

@push('js')
<script>
    $('#datepicker').datetimepicker({
        format: 'L'
    });
</script>
@endpush