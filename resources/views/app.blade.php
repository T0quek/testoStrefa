<!doctype html>
<html lang="en" data-theme-version="dark" data-bs-theme="dark">
@include("components.head")

<body class="text-center d-flex bg-gray-800 h-auto" style="flex-direction: column;">

@include("components.preloader")
@include("components.header")

<div class="container-fluid bg-gray-700 app-container pb-5" style="min-height: 85.5vh !important;">
    <div class="row">
        @yield('content')
    </div>
</div>

@include('components.footer')
<script src="{{asset("vendor/datatables/js/jquery.dataTables.min.js")}}"></script>
{{--<script src="{{asset("js/plugins-init/datatables.init.js")}}"></script>--}}
<script src="{{asset("vendor/jquery-nice-select/js/jquery.nice-select.min.js")}}"></script>

<script src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.site_key')}}"></script>
<script>
    function refreshRecaptchaToken() {
        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}').then(function(token) {
            document.querySelectorAll(".recaptchaInput").forEach(input => {
                input.value = token; // Ustawienie nowego tokenu w polach formularza
            });
        });
    }
    grecaptcha.ready(function() {
        refreshRecaptchaToken();
        setInterval(refreshRecaptchaToken, 120000);
    });
</script>

</body>
</html>
