@extends('app')

@section("content")
    <link href="{{asset("vendor/jquery-nice-select/css/nice-select.css")}}" rel="stylesheet">
    <link href="{{asset("vendor/select2/css/select2.min.css")}}" rel="stylesheet">

    <div class="col-10 mx-auto">
        <div class="mt-5">
            @include("components.validation")
        </div>
        <h1 class="mb-4">Rozpocznij egzamin</h1>
        <div>
            <form action="{{route("panel.exams.create.create")}}" method="post">
                @csrf
                @method("post")
                <div class="container-fluid text-start">
                    <div class="row gap-x-5">
                        <div class="col card bg-gray-500 p-4 h-auto mb-3">
                            <h2 class="text-center">Wybierz Kursy/Zestawy pytań</h2>
                            <hr class="my-3 py-0.5">

                            <div class="w-100 mx-auto">
                                <select class="form-select-lg form-select" name="sets[]" id="setsSelect" multiple="multiple">
                                    @foreach($courses as $course)
                                        <optgroup label="{{ $course->name }}">
                                            @foreach($course->sets as $set)
                                                <option
                                                    data-count="{{ count($set->questions) }}"
                                                    value="{{ $set->id }}"
                                                    {{ in_array($set->id, old('sets', [])) ? 'selected' : '' }}>
                                                    {{ $set->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <hr class="my-3 py-0.5">
                            <h3 class="text-white">Rozłóż proporcje pytań z każdego zestawu pytań</h3>
                            <div class="setUsageContainer">
                            </div>
                            <hr class="my-3 py-0.5">
                            <h4 class="text-white mt-4">Łączna liczba pytań</h4>
                            <div class="d-flex align-self-center justify-content-center w-100">
                                <input value="{{old("questionNumber")}}" type="number" name="questionNumber" class="form-control" id="questionNumber" placeholder="Łączna liczba pytań egzaminu">
                            </div>

                        </div>
                        <div class="col card bg-gray-500 p-4 h-auto mb-3">
                            <h2 class="text-center">Wybór parametrów</h2>
                            <hr class="my-3 py-0.5">
                            <h4 class="text-white mt-4">Maksymalny czas trwania egzaminu (opcjonalnie)</h4>
                            <div class="d-flex align-self-center justify-content-center w-100">
                                <div class="input-group mb-3">
                                    <input value="{{old("maxTime")}}" type="number" name="maxTime" class="form-control" id="maxTime" placeholder="Pole wyłączone (domyślnie nielimitowany czas)" aria-label="Udział w egzaminie" aria-describedby="min" disabled>
                                    <span class="input-group-text" id="min">min</span>
                                </div>
                                <button type="button" id="toggle-maxTime" class="btn btn-outline-primary ml-3 h-fit">Włącz</button>
                            </div>

                            <div class="w-100 mt-4">
                                <div class="form-check d-flex my-0">
                                    <input class="form-check-input me-3" name="learnMode" value="true" type="checkbox" id="learnMode">
                                    <label class="form-check-label h4 text-white m-0 d-flex align-items-center" for="learnMode">
                                        Tryb nauki (opcjonalnie)
                                        <div title="Pytanie, na które błędnie odpowiedziano, zostaje w puli pytań do rozwiązania" class="activeTooltip">
                                            <i class="ms-2 iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <hr class="my-3 py-0.5">
                            <div class="bg-green-600 bg-opacity-10 px-5 py-4 rounded-3" style="height: -webkit-fill-available;">
                                <h2 class="text-center text-white mb-2">Podsumowanie</h2>
                                <div class="text-white fs-5" id="summaryContainer">
                                    <p class="text-center text-danger">Brak danych do podsumowania</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 card bg-gray-500 px-5 py-3 h-auto">
                            <input disabled id="submitButton" type="submit" class="btn btn-primary mx-auto w-100" value="Stwórz egzamin">
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>

    <template id="setUsageTemplate">
        <div class="mt-3">
            <h4 class="text-white"></h4>
            <div class="input-group mb-3">
                <input type="number" id="setUsageInput" name="setUsageInput[]" class="form-control" min="0" max="100" step="0.1" placeholder="Udział w egzaminie" aria-label="Udział w egzaminie" aria-describedby="percentage">
                <span class="input-group-text" id="percentage">%</span>
            </div>
        </div>
    </template>

    <script src="{{asset("vendor/global/global.min.js")}}"></script>
    <script src="{{asset("vendor/select2/js/select2.full.min.js")}}"></script>

    {{--    <script src="{{asset("js/plugins-init/jquery.validate-init.js")}}"></script>--}}
    <script src="{{asset("js/plugins-init/select2-init.js")}}"></script>

    <script src="{{asset("js/inputState.js")}}"></script>


    <script>
        $(document).ready(function() {
            $('#setsSelect').select2({
                "placeholder" : "Wyszukaj...",
                "allowClear" : true,
                "height": "50px",
                // "minimumInputLength" : 3
            });

            $(document).on('click', '.select2-results__group', function() {
                var groupLabel = $(this).text().trim(); // Pobieramy nazwę grupy

                $('#setsSelect optgroup[label="' + groupLabel + '"] option').prop('selected', true);

                $('#setsSelect').trigger('change');
                $('#setsSelect').select2('close');
            });
        });

        document.addEventListener("DOMContentLoaded", function () {

            const setsSelect = document.querySelector("#setsSelect");
            const setUsageContainer = document.querySelector(".setUsageContainer");
            const setUsageTemplate = document.querySelector("#setUsageTemplate");

            function updateSetUsageContainer() {
                const selectedOptions = $(setsSelect).select2("data"); // Pobieramy dane wybranych opcji
                const selectedIds = selectedOptions.map(option => option.id);

                // Usuń elementy nieistniejące w aktualnym wyborze
                Array.from(setUsageContainer.children).forEach(child => {
                    const input = child.querySelector("input[name='setUsageInput[]']");
                    if (!selectedIds.includes(input.dataset.setId)) {
                        child.remove();
                    }
                });

                // Dodaj brakujące elementy lub aktualizuj istniejące
                selectedOptions.forEach(option => {
                    let existingElement = setUsageContainer.querySelector(`input[data-set-id="${option.id}"]`);
                    if (!existingElement) {
                        // Skopiuj template i wypełnij dane
                        const templateClone = document.importNode(setUsageTemplate.content, true);
                        const newInput = templateClone.querySelector("input[name='setUsageInput[]']");
                        const newLabel = templateClone.querySelector("h4");
                        console.log(option);
                        newInput.dataset.setId = option.id;
                        newInput.dataset.maxQuestions = document.querySelector(`#setsSelect option[value="${option.id}"]`).getAttribute("data-count");
                        newLabel.textContent = option.text + " (Wszystkich pytań: " + document.querySelector(`#setsSelect option[value="${option.id}"]`).getAttribute("data-count") + ")";
                        setUsageContainer.appendChild(templateClone);
                    }
                });

                // Rozdziel proporcjonalne wartości dla każdego inputu
                distributeProportions();
            }

            function distributeProportions() {
                const inputs = setUsageContainer.querySelectorAll("input[name='setUsageInput[]']");
                const proportion = (100 / inputs.length).toFixed(2); // Oblicz równą wartość procentową
                inputs.forEach(input => {
                    input.value = proportion; // Ustaw wartość procentową
                });
            }

            // Nasłuchiwanie zmian na selekcie z obsługą select2
            $(setsSelect).on("change", updateSetUsageContainer);
        });

        document.addEventListener("DOMContentLoaded", function () {
            const setsSelect = document.querySelector("#setsSelect");
            const questionNumberInput = document.querySelector("#questionNumber");
            const setUsageContainer = document.querySelector(".setUsageContainer");
            const summaryContainer = document.querySelector("#summaryContainer");
            const submitButton = document.querySelector("#submitButton");

            function calculateQuestionsDistribution() {
                const totalQuestions = parseInt(questionNumberInput.value || 0);
                let hasError = false;

                if (isNaN(totalQuestions) || totalQuestions <= 0) {
                    summaryContainer.innerHTML = `<p class="text-center text-danger">Brak danych do podsumowania</p>`;
                    validateSubmitButton(false);
                    return;
                }

                const usageInputs = setUsageContainer.querySelectorAll("input[name='setUsageInput[]']");
                let distribution = [];
                let remainingQuestions = totalQuestions;

                // Oblicz dystrybucję pytań
                usageInputs.forEach((input) => {
                    const percentage = parseFloat(input.value || 0);
                    const setId = input.dataset.setId;
                    const maxQuestions = parseInt(input.dataset.maxQuestions || 0); // Maksymalna liczba pytań dla zestawu
                    const count = Math.round((percentage / 100) * totalQuestions); // Zaokrąglanie matematyczne

                    // Sprawdź, czy liczba pytań nie przekracza maksymalnej liczby dostępnych
                    if (count > maxQuestions) {
                        hasError = true;
                    }

                    distribution.push({
                        setId: setId,
                        count: count,
                        maxQuestions: maxQuestions,
                    });
                    remainingQuestions -= count;
                });

                // Specjalny przypadek: równa liczba pytań z zaokrągleniami np. 5.5 i 5.5
                const totalCalculated = distribution.reduce((sum, item) => sum + item.count, 0);
                if (totalCalculated > totalQuestions) {
                    // Jeśli suma pytań jest większa niż łączna liczba, zmniejsz pierwszy zestaw o 1
                    distribution[0].count -= 1;
                } else if (totalCalculated < totalQuestions) {
                    // Jeśli suma pytań jest mniejsza, dopełnij brakujące pytania
                    distribution.forEach((item, index) => {
                        if (remainingQuestions > 0) {
                            item.count += 1;
                            remainingQuestions -= 1;
                        }
                    });
                }

                // Wyczyść podsumowanie i stwórz nowe
                summaryContainer.innerHTML = ""; // Usuń stare podsumowanie

                let totalSummaryQuestions = 0;
                hasError = false; // Zresetuj błąd, aby warunki były sprawdzane na nowo

                distribution.forEach((item) => {
                    const setName = document.querySelector(`#setsSelect option[value="${item.setId}"]`).textContent.trim();
                    const summaryItem = document.createElement("div");
                    summaryItem.classList.add("d-flex", "align-items-center", "justify-content-between");

                    // Sumuj pytania do walidacji
                    totalSummaryQuestions += item.count;

                    // Zaznacz błędy, jeśli liczba pytań przekracza maksymalną liczbę dla zestawu
                    if (item.count > item.maxQuestions) {
                        summaryItem.classList.add("text-danger"); // Podświetl na czerwono w przypadku błędu
                        hasError = true;
                    }

                    // Wyświetl podsumowanie
                    summaryItem.innerHTML = `<span>${setName}</span><span>${item.count} pytań</span>`;
                    summaryContainer.appendChild(summaryItem);
                });

                // Dodaj podsumowanie łącznej liczby pytań
                summaryContainer.insertAdjacentHTML(
                    "beforeend",
                    `<hr class="my-3 py-0.5 !bg-gray-50"><div class="d-flex justify-content-between"><span class="text-white">Łącznie:</span><span>${totalSummaryQuestions} pytań</span></div>`
                );

                if (hasError) {
                    summaryContainer.insertAdjacentHTML(
                        "beforeend",
                        `<p class="text-danger text-center mt-3">Niektóre zestawy przekraczają maksymalną liczbę dostępnych pytań.</p>`
                    );
                }

                // Waliduj przycisk Submit
                validateSubmitButton(
                    !hasError &&
                    totalSummaryQuestions === totalQuestions &&
                    distribution.length > 0
                );
            }

            function validateSubmitButton(isValid) {
                if (isValid) {
                    submitButton.removeAttribute("disabled");
                } else {
                    submitButton.setAttribute("disabled", "true");
                }
            }

            // Nasłuchuj zmian na inpucie łącznej liczby pytań
            questionNumberInput.addEventListener("input", calculateQuestionsDistribution);

            // Nasłuchuj zmian na inputach proporcji
            setUsageContainer.addEventListener("input", function (e) {
                if (e.target.matches("input[name='setUsageInput[]']")) {
                    calculateQuestionsDistribution();
                }
            });

            // Nasłuchuj zmian w selectcie zestawów
            $(setsSelect).on("change", function () {
                calculateQuestionsDistribution();
            });
        });

        $('#setsSelect').trigger('change');
        window.onload = function() {
            $('#setsSelect').trigger('change');
        };
    </script>
@endsection
