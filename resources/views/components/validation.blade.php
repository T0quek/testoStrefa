@if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="fs-5">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger mt-4">
        <ul>
            <li class="fs-5">{{ session('error') }}</li>
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-4">
        <ul><li class="fs-5">{{ session('success') }}</li></ul>
    </div>
@endif
