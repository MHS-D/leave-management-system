
<script>
    /**
     * Form submit handler
     */
    formSubmit({
        form: '#form'
    })

    var textarea = document.getElementById("project_position");

    textarea.addEventListener("keydown", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });
</script>
