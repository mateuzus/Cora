@if(session()->has('message'))
    <script>

        Swal.fire({
            icon: 'success',
            title: 'Tudo certo!',
            text:  '{{ session()->get('message') }}',
            showConfirmButton: false,
            timer: 5000
        })
    </script>
@endif

@if(session()->has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text:  '{{ session()->get('error') }}',
            showConfirmButton: false,
            timer: 5000
        })

    </script>
@endif
