<script>
    $(document).ready(function() {
        let screenWidth = $(window).width()
        console.log('screenWidth: ',screenWidth);
        if (screenWidth >= 1280) {
            $('.waiting-content').css('height', '420px');
            $('iframe').css('height', '420px');
        }
    });
</script>