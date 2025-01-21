<footer class="bg-black shadow align-bottom text-white fs-4" style="z-index: 10; bottom: 0;">
    <div class="py-3 mx-5 d-block">
        <span class="my-0 text-center me-5 d-lg-inline-block d-block">testoStrefa.pl © {{date("Y")}}</span>
        <span class="my-0 text-center ms-5 d-lg-inline-block d-block">Autorzy: Tomasz Gudyka | Kamil Kałużny | Szymon Soszka</span>
    </div>
</footer>


{{--<script src="{{asset("vendor/global/global.min.js")}}"></script>--}}

<!-- Include Alpine.js CDN -->
{{--@livewireScripts--}}
{{--<script src="//unpkg.com/alpinejs" defer></script>--}}
<!-- Additional Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
{{--<script src="{{asset("vendor/chart.js/Chart.bundle.min.js")}}"></script>--}}
{{--<script src="{{asset("vendor/jquery-nice-select/js/jquery.nice-select.min.js")}}"></script>--}}
{{--<script src="{{asset("vendor/apexchart/apexchart.js")}}"></script>--}}
{{--<script src="{{asset("vendor/chart.js/Chart.bundle.min.js")}}"></script>--}}
{{--<script src="{{asset("vendor/peity/jquery.peity.min.js")}}"></script>--}}
{{--<script src="{{asset("js/dashboard/dashboard-1.js")}}"></script>--}}
{{--<script src="{{asset("vendor/owl-carousel/owl.carousel.js")}}"></script>--}}
{{--<script src="{{asset("js/custom.min.js")}}"></script>--}}
{{--<script src="{{asset("js/dlabnav-init.js")}}"></script>--}}
{{--<script src="{{asset("js/demo.js")}}"></script>--}}
{{--<script src="{{asset("js/styleSwitcher.js")}}"></script>--}}

<!-- form-wizard scripts -->
<script src="{{asset("js/form-wizard/jquery.smartWizard.js")}}"></script>
<script src="{{asset("vendor/jquery-nice-select/js/jquery.nice-select.min.js")}}"></script>


<!--tooltip-->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script>
    function initTooltip() {
        document.querySelectorAll(".activeTooltip").forEach(button => {
            if (button._tippy) {
                button._tippy.setProps({
                    content: button.title,
                    allowHTML: true,
                });
            } else {
                tippy(button, {
                    content: button.title,
                    allowHTML: true,
                });
            }
        });
    }


    window.initTooltip = initTooltip;
    initTooltip();
    setInterval(initTooltip, 1000);
</script>

<script src="{{asset("vendor/select2/js/select2.full.min.js")}}"></script>

{{--@livewireScripts--}}
