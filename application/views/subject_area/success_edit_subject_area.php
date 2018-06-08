<script>
    swal({
        title: "Success!",
        text: "Subject Area successfully updated.",
        icon: "success",
        button: "Ok",
        closeOnClickOutside: false,
        closeOnEsc: false,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '<?= base_url() ?>/SubjectArea';
        }
    });
</script>