<script>
    swal({
    title: "Success!",
            text: "Student successfully added.",
            icon: "success",
            button: "Ok",
            closeOnClickOutside: false,
            closeOnEsc: false,
    }).then((willDelete) <?= "=>" ?> {
    if (willDelete) {
    window.location.href = '<?= base_url() ?>/Sections/add_student/<?= $offering ?>';
        }}
        );
</script>