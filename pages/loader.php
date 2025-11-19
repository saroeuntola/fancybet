<style>
    .loader {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-block;
        border-top: 4px solid green;
        border-right: 4px solid transparent;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;

    }

    .loader::after {
        content: '';
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top: 0;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border-left: 4px solid #FF3D00;
        border-bottom: 4px solid transparent;
        animation: rotation 0.5s linear infinite reverse;

    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<!-- Loader -->
<div id="pageLoader" class="fixed inset-0 z-50 bg-amber-50 flex items-center justify-center transition-opacity  duration-1000" aria-live="polite">
    <div class="loader inset-0 ease-linear"></div>
</div>

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