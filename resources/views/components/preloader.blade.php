<div id="myPreloader" class="bg-black fixed inset-0 flex items-center justify-center z-50">
    <div class="myPreloader-l">
        <div></div>
        <div></div>
    </div>
</div>

<style>
    #myPreloader {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 1); /* black background with transparency */
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .myPreloader-l {
        position: relative;
        width: 80px;
        height: 80px;
    }
    .myPreloader-l div {
        position: absolute;
        border: 4px solid #ffffff; /* white loader */
        border-radius: 50%;
        animation: ripple 1s infinite;
    }
    .myPreloader-l div:nth-child(2) {
        animation-delay: -0.5s;
    }
    @keyframes ripple {
        0% {
            width: 0;
            height: 0;
            opacity: 1;
        }
        100% {
            width: 80px;
            height: 80px;
            opacity: 0;
        }
    }

</style>

<script>
    window.addEventListener("load", function() {
        const preloader = document.querySelector("#myPreloader");
        preloader.style.transition = "opacity 0.5s ease";  // Smooth fade-out transition
        preloader.style.opacity = "0";                     // Set opacity to fade out

        // Remove the element after transition
        preloader.addEventListener("transitionend", () => {
            document.querySelector("#myPreloader").remove()
        });
    });

</script>
