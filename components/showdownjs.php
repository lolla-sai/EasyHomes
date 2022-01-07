<script src="https://unpkg.com/showdown/dist/showdown.min.js"></script>
<script>
    function markdownToHTML(raw) {
        var converter = new showdown.Converter();
        return converter.makeHtml(raw);
    }
</script>