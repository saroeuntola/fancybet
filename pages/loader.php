

 <link rel="stylesheet" href="/css/loader.css">
<div id="pageLoader" class="fixed inset-0 z-50 bg-amber-50 flex items-center justify-center transition-opacity  duration-1000">
    <div class="loader inset-0 ease-linear"></div>
</div>
<script src="/js/jquery-3.7.1.min.js"></script>
<!-- Loader Script -->
<script>
    $(window).on("load", function() {
        const $loader = $("#pageLoader");
        $loader.removeClass("opacity-0").css("opacity", "1");
        $loader.addClass("opacity-0");
        setTimeout(function() {
            $loader.css("display", "none").attr("aria-hidden", "true");
        }, 1000);
    });
</script>
