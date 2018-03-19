<script>
    swal({
    title: "Success!",
            text: "Student successfully removed.",
            icon: "success",
            button: "Ok",
            closeOnClickOutside: false,
            closeOnEsc: false,
    }).then((willDelete) <?= "=>" ?> {
    if (willDelete) {
    window.location.href = '<?= base_url() ?>/Sections/section_detail/<?= $offering ?>';
        }}
        );
</script>