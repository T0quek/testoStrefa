@extends('app')

@section("content")

    @vite("resources/css/timeline-7.css")

    <style>
        /* Style the Image Used to Trigger the Modal */
        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .img-modal {
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
        .img-modal-content {
            margin: auto;
            display: block;
            width: auto;
            height: 80%;
        }

        /* Add Animation - Zoom in the Modal */
        .img-modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* The Close Button */
        .img-close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .img-close:hover,
        .img-close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .img-modal-content {
                width: 100%;
            }
        }
    </style>

    <div class="mt-5">
        @include("components.validation")
    </div>
    <h1 class="mb-4">Kurs: {{$set->name}}</h1>

    <a href="{{route("panel.courses.myCourses.index")}}" class="fs-4 btn btn-primary mx-auto mt-3 mb-5 w-25 d-flex align-items-center justify-content-center">
        <span>Wróć do moich kursów</span>
        <i class="iconify ms-2 mb-1" data-icon="icon-park-outline:return"></i>
    </a>
    <div class="col-12">
{{--        {{dd($set->questions)}}--}}
        <div class="card px-3">
            <livewire:question-table />
        </div>
    </div>


    {{-- add question modal --}}
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addQuestionModalLabel">Dodaj nowe pytanie</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <ul class="nav nav-tabs text-white" id="myTab" role="tablist">
                            <li class="nav-item light bg-blue-800 !bg-opacity-45 !text-blue-500 radius-top-15" role="presentation">
                                <button class="nav-link active" id="abcd-tab" data-bs-toggle="tab" data-bs-target="#abcd" type="button" role="tab" aria-controls="abcd" aria-selected="true">ABCD (jedna poprawna)</button>
                            </li>
                            <li class="nav-item light bg-cyan-800 !bg-opacity-45 !text-cyan-500 radius-top-15" role="presentation">
                                <button class="nav-link" id="multiabcd-tab" data-bs-toggle="tab" data-bs-target="#multiabcd" type="button" role="tab" aria-controls="multiabcd" aria-selected="false">ABCD (wiele poprawnych)</button>
                            </li>
                            <li class="nav-item light bg-yellow-800 !bg-opacity-45 !text-yellow-500 radius-top-15" role="presentation">
                                <button class="nav-link" id="select-tab" data-bs-toggle="tab" data-bs-target="#select" type="button" role="tab" aria-controls="select" aria-selected="false">SELECT (wstaw w luki)</button>
                            </li>
                            <li class="nav-item light bg-green-800 !bg-opacity-45 !text-green-500 radius-top-15" role="presentation">
                                <button class="nav-link" id="value-tab" data-bs-toggle="tab" data-bs-target="#value" type="button" role="tab" aria-controls="value" aria-selected="false">INPUT (wpisz wartość)</button>
                            </li>
                        </ul>
                        <div class="tab-content text-white mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="abcd" role="tabpanel" aria-labelledby="abcd-tab">
                                <form action="{{route("panel.courses.myCourses.questions.addQuestion")}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method("post")
                                    <input type="hidden" name="questionEditId" id="questionEditId">
                                    <input type="hidden" name="questionType" value="1">
                                    <div class="">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="questionTitle">Treść pytania</label>
                                        <input required value="{{old("questionTitle")}}" type="text" name="questionTitle" id="questionTitle" class="form-control !h-12 border-primary">
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white d-flex align-items-center" for="questionAnswers">
                                            <span>Możliwe odpowiedzi</span>
                                            <button class="ms-2 activeTooltip" title="Każdą odpowiedź umieść w osobnej linii!">
                                                <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                            </button>
                                        </label>
                                        <textarea rows="6" required name="questionAnswers" id="questionAnswers" class="form-control textarea_editor border-primary resize-none  !min-h-fit" placeholder="ODPOWIEDŹ 1 &#10;ODPOWIEDŹ 2&#10;ODPOWIEDŹ 3&#10;ODPOWIEDŹ 4&#10;...">{{old("questionAnswers")}}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="questionCorrectAnswer">Wybierz poprawną odpowiedź</label>
                                        <select required name="questionCorrectAnswer" id="questionCorrectAnswer" class="form-select border-primary bg-black text-white questionSelect radius-10">
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="imageSingle">*Dodaj obraz (opcjonalnie)</label>
                                        <input class="form-control h-auto border-primary radius-10 py-2" type="file" id="imageSingle" name="image" accept=".png,.jpg,.jpeg">
                                    </div>
                                    <div class="mt-4">
                                        <hr>
                                        <input type="submit" id="addQuestionButton" value="Dodaj pytanie" class="btn btn-primary d-block ms-auto">
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="multiabcd" role="tabpanel" aria-labelledby="multiabcd-tab">
                                <form action="{{route("panel.courses.myCourses.questions.addQuestion")}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method("post")
                                    <input type="hidden" name="questionEditId" id="questionEditIdMulti">
                                    <input type="hidden" name="questionType" value="2">
                                    <div class="">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="questionMultiTitle">Treść pytania</label>
                                        <input required value="{{old("questionTitle")}}" type="text" name="questionTitle" id="questionMultiTitle" class="form-control !h-12 border-primary">
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white d-flex align-items-center" for="questionMultiAnswers">
                                            <span>Możliwe odpowiedzi</span>
                                            <button class="ms-2 activeTooltip" title="Każdą odpowiedź umieść w osobnej linii!">
                                                <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                            </button>
                                        </label>
                                        <textarea rows="6" required name="questionAnswers" id="questionMultiAnswers" class="form-control textarea_editor border-primary resize-none  !min-h-fit" placeholder="ODPOWIEDŹ 1 &#10;ODPOWIEDŹ 2&#10;ODPOWIEDŹ 3&#10;ODPOWIEDŹ 4&#10;...">{{old("questionAnswers")}}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="questionCorrectMultiAnswer">Wybierz poprawne odpowiedzi</label>
                                        <select required name="questionCorrectAnswer[]" multiple="multiple" id="questionCorrectMultiAnswer" class="multi-select-placeholder dropdown-groups multi-select-placeholder-answers form-select border-primary bg-black text-white radius-10">
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="imageMulti">*Dodaj obraz (opcjonalnie)</label>
                                        <input class="form-control h-auto border-primary radius-10 py-2" type="file" id="imageMulti" name="image" accept=".png,.jpg,.jpeg">
                                    </div>
                                    <div class="mt-4">
                                        <hr>
                                        <input type="submit" id="addQuestionButtonMulti" value="Dodaj pytanie" class="btn btn-primary d-block ms-auto">
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="select" role="tabpanel" aria-labelledby="select-tab">
                                <form action="{{route("panel.courses.myCourses.questions.addQuestion")}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method("post")
                                    <input type="hidden" name="questionEditId" id="questionEditIdSelect">
                                    <input type="hidden" name="questionType" value="3">
                                    <div>
                                        <label class="d-block fs-4 text-start ms-1 text-white d-flex align-items-center" for="questionSelectTitle">
                                            <span>Treść pytania</span>
                                            <button class="ms-2 activeTooltip" title="Puste luki oznaczaj [$], [$], ...">
                                                <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                            </button>
                                        </label>
                                        <textarea rows="3" required name="questionTitle" id="questionSelectTitle" class="form-control textarea_editor border-primary resize-none  !min-h-fit" placeholder="Treść pytania [$] <-(pierwsza luka) dalsza część zdania, [$] <-(kolejna luka)">{{old("questionTitle")}}</textarea>
                                    </div>
                                    <div id="questionSelectContainer">
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="imageSelect">*Dodaj obraz (opcjonalnie)</label>
                                        <input class="form-control h-auto border-primary radius-10 py-2" type="file" id="imageSelect" name="image" accept=".png,.jpg,.jpeg">
                                    </div>
                                    <div class="mt-4">
                                        <hr>
                                        <input type="submit" id="addQuestionButtonSelect" value="Dodaj pytanie" class="btn btn-primary d-block ms-auto">
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="value" role="tabpanel" aria-labelledby="value-tab">
                                <form action="{{route("panel.courses.myCourses.questions.addQuestion")}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method("post")
                                    <input type="hidden" name="questionType" value="4">
                                    <input type="hidden" name="questionEditId" id="questionEditIdValue">
                                    <div class="">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="questionValueTitle">Treść pytania</label>
                                        <input required value="{{old("questionTitle")}}" type="text" name="questionTitle" id="questionValueTitle" class="form-control !h-12 border-primary">
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white d-flex align-items-center" for="questionAnswers">
                                            <span>Możliwe warianty poprawnej odpowiedzi</span>
                                            <button class="ms-2 activeTooltip" title="Każdą odpowiedź umieść w osobnej linii!">
                                                <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                            </button>
                                        </label>
                                        <textarea rows="6" required name="questionCorrectAnswers" id="questionValueAnswers" class="form-control textarea_editor border-primary resize-none  !min-h-fit" placeholder="np. 10.0&#10;10&#10;10,0&#10;...">{{old("questionCorrectAnswers")}}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="d-block fs-4 text-start ms-1 text-white" for="imageValue">*Dodaj obraz (opcjonalnie)</label>
                                        <input class="form-control h-auto border-primary radius-10 py-2" type="file" id="imageValue" name="image" accept=".png,.jpg,.jpeg">
                                    </div>
                                    <div class="mt-4">
                                        <hr>
                                        <input type="submit" id="addQuestionButtonValue" value="Dodaj pytanie" class="btn btn-primary d-block ms-auto">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <template id="questionSelectTemplate">
        <hr class="text-primary py-0.5 mt-4 mb-2">
        <label class="d-block fs-4 text-start ms-1 my-2 mb-3 text-white section-title"></label>
        <div class="mt-3">
            <label class="d-block fs-4 text-start ms-1 text-white d-flex align-items-center">
                <span>Możliwe odpowiedzi</span>
                <button class="ms-2 activeTooltip" title="Każdą odpowiedź umieść w osobnej linii!">
                    <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                </button>
            </label>
            <textarea rows="6" required name="questionAnswers" class="form-control textarea-editor border-primary resize-none  !min-h-fit" placeholder="ODPOWIEDŹ 1 &#10;ODPOWIEDŹ 2&#10;ODPOWIEDŹ 3&#10;ODPOWIEDŹ 4&#10;..."></textarea>
        </div>
        <div class="mt-3">
            <label class="d-block fs-4 text-start ms-1 text-white">Wybierz poprawną odpowiedź</label>
            <select required name="questionCorrectAnswer" class="form-select border-primary bg-black text-white questionSelect radius-10">
            </select>
        </div>
    </template>

    <link href="{{asset("vendor/select2/css/select2.min.css")}}" rel="stylesheet">
{{--    <script src="{{asset("vendor/global/global.min.js")}}"></script>--}}
{{--    <script src="{{asset("vendor/bootstrap/bootstrap.bundle.min.js")}}"></script>--}}
    <script src="{{asset("vendor/jquery/jquery-3.7.1.min.js")}}"></script>

{{--    <script src="{{asset("vendor/jquery-steps/build/jquery.steps.min.js")}}"></script>--}}
    <script src="{{asset("vendor/select2/js/select2.full.min.js")}}"></script>
    <script src="{{asset("js/plugins-init/select2-init.js")}}"></script>

    <script>
        // Funkcja aktualizująca opcje selecta
        function updateSelectOptions(content, selectId) {
            const select = document.getElementById(selectId);
            const answers = content.split("\n").filter(line => line.trim() !== ""); // Filtr pustych linii
            select.innerHTML = ""; // Wyczyść istniejące opcje
            answers.forEach((answer, index) => {
                const option = new Option(answer, index);
                select.appendChild(option);
            });
        }
        window.updateSelectOptions = updateSelectOptions;

        document.addEventListener("DOMContentLoaded", (event) => {
            updateSelectOptions(document.querySelector("#questionAnswers").value, "questionCorrectAnswer");
            updateSelectOptions(document.querySelector("#questionMultiAnswers").value, "questionCorrectMultiAnswer");
        });

        // Nasłuchiwanie na zmiany w textarea dla pojedynczego wyboru edit1
        // document.querySelector("#question1Answers").addEventListener("change", function () {
        //     updateSelectOptions(this.value, "question1CorrectAnswer");
        // });

        // Nasłuchiwanie na zmiany w textarea dla pojedynczego wyboru
        document.querySelector("#questionAnswers").addEventListener("change", function () {
            updateSelectOptions(this.value, "questionCorrectAnswer");
        });

        // Nasłuchiwanie na zmiany w textarea dla wielokrotnego wyboru
        document.querySelector("#questionMultiAnswers").addEventListener("change", function () {
            updateSelectOptions(this.value, "questionCorrectMultiAnswer");
        });

        document.querySelector("#questionSelectTitle").addEventListener("change", function () {
            const content = this.value;
            const matches = content.match(/\[\$\]/g); // Szuka wystąpień [$]
            const template = document.querySelector("#questionSelectTemplate");
            const container = document.querySelector("#questionSelectContainer");

            container.innerHTML = ""; // Wyczyść kontener

            if (matches) {
                matches.forEach((_, index) => {
                    const clone = template.content.cloneNode(true);

                    // Unikalne identyfikatory i nazwy
                    const textarea = clone.querySelector("textarea");
                    const select = clone.querySelector("select");
                    const uniqueId = `${index + 1}`;

                    clone.querySelector(".section-title").innerHTML = "Luka "+(index + 1);
                    textarea.id = `questionAnswers${uniqueId}`;
                    textarea.name = `questionAnswers_${uniqueId}`;
                    select.id = `questionCorrectAnswer${uniqueId}`;
                    select.name = `questionCorrectAnswer_${uniqueId}`;

                    // Nasłuchiwanie na zmiany w textarea
                    textarea.addEventListener("input", function () {
                        updateSelectOptions(this.value, select.id);
                    });

                    container.appendChild(clone);
                });
            }
            initTooltip();
        });

        //Czyszczenie po edycji pytań
        document.getElementById('addQuestionModalButton').addEventListener('click', () => {
            const modal = document.getElementById('addQuestionModal');

            // Przywróć domyślny tytuł i przycisk
            document.querySelector("#addQuestionModalLabel").innerHTML = "Dodaj nowe pytanie";
            document.querySelector("#addQuestionButton").value = "Dodaj pytanie";
            document.querySelector("#addQuestionButtonMulti").value = "Dodaj pytanie";
            document.querySelector("#addQuestionButtonSelect").value = "Dodaj pytanie";
            document.querySelector("#addQuestionButtonValue").value = "Dodaj pytanie";

            // Zresetuj zakładkę na domyślną (ABCD - jedna poprawna)
            const defaultTab = document.getElementById('abcd-tab');
            if (defaultTab) {
                defaultTab.click();
            }

            // Wyczyść inputy i textarea dla typu 1
            document.getElementById('questionTitle').value = "";
            document.getElementById('questionAnswers').value = "";
            updateSelectOptions("", "questionCorrectAnswer");

            // Wyczyść inputy i textarea dla typu 2
            document.getElementById('questionMultiTitle').value = "";
            document.getElementById('questionMultiAnswers').value = "";
            updateSelectOptions("", "questionCorrectMultiAnswer");

            const multiSelectElement = document.getElementById('questionCorrectMultiAnswer');
            Array.from(multiSelectElement.options).forEach(option => {
                option.selected = false;
            });

            // Wyczyść inputy, textarea i sekcje dla typu 3
            document.getElementById('questionSelectTitle').value = "";
            const container = document.getElementById("questionSelectContainer");
            container.innerHTML = ""; // Wyczyść sekcje dla luk

            // Wyczyść inputy dla typu 4
            document.getElementById('questionValueTitle').value = "";
            document.getElementById('questionValueAnswers').value = "";

            // Otwórz modal
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        });

    </script>
    <script src="{{asset("vendor/select2/js/select2.full.min.js")}}"></script>



@endsection
