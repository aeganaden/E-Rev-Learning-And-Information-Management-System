<script>
    $(document).ready(function () {
        swal({
        title: "Error",
                text: "Duplicate data.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false
        }).then((willDelete) <?= "=>" ?>{
        if (willDelete) {
            window.location.href = "<?= base_url() . "Course/add" ?>";
        } else {
            window.location.href = "<?= base_url() . "Course/add" ?>";
        }
    });
    });
</script>