<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('js')
<script>
    window.addEventListener('confirm-delete-confirmation', event => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('deleteconfirmed');
            }
        })
    });
    window.addEventListener('deleted', event => {
        Swal.fire(
            'Deleted!',
            event.detail.msg,
            'success'
        )
    } )
</script>
@endpush