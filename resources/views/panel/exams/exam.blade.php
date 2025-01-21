@extends('publicApp')

@section("content")
    <style>
        .card {
            background-color: #0f0f1a;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .progress-bar {
            background-color: #28a745;
        }

        .btn-checkbox {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #3a3a44;
            color: white;
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s, transform 0.2s;
            text-align: center;
        }

        .btn-checkbox:hover {
            background-color: #5a5a64;
        }

        .checkbox:checked + .btn-custom {
            background-color: #5a5a64;
            outline: 2px solid #ffffff;
            border-radius: 8px;
        }

        .btn-custom {
            display: block;
            width: 100%;
            height: 100%;
            padding: 1rem;
            font-size: 1.5em;
        }

        .form-select {
            background-color: #3a3a44;
            color: white;
            border: none;
            text-align: center;
            border-radius: 8px;
            padding: 0.5rem;
            font-size: 1rem;
            min-width: 120px;
        }

        .answer-danger {background-color: #851a1a!important;border-radius: 8px;}
        .answer-success {background-color: #1d6812!important;border-radius: 8px;}
        .answer-warning {background-color: #9a8215!important;border-radius: 8px;}

        .badge-question {min-width: 220px !important;}

    </style>

    <style>
        /* Style the Image Used to Trigger the Modal */
        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 12; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: auto;
            height: 80%;
        }

        /* Caption of Modal Image (Image Text) - Same Width as the Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation - Zoom in the Modal */
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>

    <div class="bg-gray-800 d-flex align-items-center justify-content-center">
        <div class="container-fluid text-white my-5">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <livewire:exam.question-details :exam-id="$examId" :remaining-time="$remainingTime" />
                </div>
                <div class="col-lg-3">
                    <livewire:exam.exam-details :examId="$examId" />
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        function initModal() {
            var modal = document.getElementById("myModal");
            var button = document.getElementById("imgModal");

            button.onclick = function () {
                modal.style.display = "block";
            }

            var span = document.getElementsByClassName("close")[0];

            span.onclick = function () {
                modal.style.display = "none";
            }
        }

        setInterval(initModal, 2000);
    </script>

{{--    @livewireScripts--}}

@endsection
