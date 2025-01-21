<div class="card p-4">
    <h5 class="text-center mt-3 fs-3">Postęp egzaminu</h5>
    <div class="progress my-2" style="height: 10px;">
        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ ($currentQuestion / ($totalQuestions??1)) * 100 }}%;"></div>
    </div>
    <h6 class="text-center mt-2">Pytanie {{ $currentQuestion }} z {{ $totalQuestions }}</h6>

    <h5 class="text-center mt-4 fs-3">Poprawne odpowiedzi</h5>
    <div class="progress my-2" style="height: 10px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($correctAnswers / ($totalQuestions??1)) * 100 }}%;"></div>
    </div>
    <h6 class="text-center mt-2">Poprawnych odpowiedzi: {{ $correctAnswers }} z {{ $totalQuestions }}</h6>


    <h6 class="text-center mt-4 fs-3">Pozostały czas</h6>
    @if (!is_null($remainingTime))
        <span class="text-center fs-3" id="remaining-time">
        {{ gmdate('H:i:s', max($remainingTime, 0)) }}
        </span>
    @else
        <span class="text-center text-muted fs-3">Brak limitu czasu!</span>
    @endif


    <button wire:click="cancelExam" class="btn btn-outline-danger hover:!bg-red-700 text-white mx-2 mt-4">Anuluj egzamin</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const remainingTimeElement = document.getElementById('remaining-time');
        let remainingTime = Math.floor(@json($remainingTime)); // Konwersja na liczbę całkowitą

        if (remainingTime === null) {
            return; // Nie inicjalizuj timera, jeśli brak limitu czasu
        }

        function updateTimer() {
            if (remainingTime <= 0) {
                remainingTimeElement.textContent = 'Czas minął!';
                remainingTimeElement.classList.add("!text-red-600");
                return;
            }

            const hours = Math.floor(remainingTime / 3600);
            const minutes = Math.floor((remainingTime % 3600) / 60);
            const seconds = remainingTime % 60;

            remainingTimeElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            remainingTime--;

            setTimeout(updateTimer, 1000);
        }

        updateTimer();
    });
</script>


