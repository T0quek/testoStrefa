<!doctype html>
<html lang="en" data-theme-version="dark" data-bs-theme="dark">
@include("components.head")

<body class="text-center bg-gray-500">
<div style="min-height:100%;" class="d-flex flex-column">
    @include("components.preloader")

    <div class="container-fluid img-bg flex-1 d-grid h-100 w-100">
        <div class="row h-100">
            @yield('content')
        </div>
    </div>

    @include('components.publicFooter')
</div>
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
