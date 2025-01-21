@extends('app')

@section("content")

    <div class="mt-5">
        @include("components.validation")
    </div>
    <h1 class="mb-4">Użytkownicy:</h1>

    <div class="col-12">
        {{--        {{dd($set->questions)}}--}}
        <div class="card px-3">
            <livewire:users-admin-table />
        </div>
    </div>
@endsection
