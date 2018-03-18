<script>
    swal({
    title: "Success!",
            text: "Data were successfully added.",
            icon: "success",
            button: "Ok",
            closeOnClickOutside: false,
    }).then((willDelete) <?= "=>" ?> {
    if (willDelete) {
    window.location.href = '<?= base_url() ?>/ImportQuestions';
    }}
    );
</script>