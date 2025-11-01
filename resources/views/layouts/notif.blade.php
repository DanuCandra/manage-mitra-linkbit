<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true, // ✅ ini aktifkan progress bar
        "positionClass": "toast-top-right", // posisi
        "timeOut": "4000" // durasi tampil (ms)
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
