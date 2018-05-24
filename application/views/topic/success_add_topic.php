<script>
    swal({
        title: "Success!",
        text: "Topic successfully added.",
        icon: "success",
        button: "Ok",
        closeOnClickOutside: false,
        closeOnEsc: false,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '<?= base_url() ?>/Topic';
        }
    });
</script>