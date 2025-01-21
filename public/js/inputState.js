(function($) {
    "use strict"

    if ($('#datepicker').prop('disabled')) {
        $('#toggle-datepicker').text('Włącz');
    }

    $('#toggle-datepicker').click(function() {
        var datepicker = $('#datepicker');
        var button = $('#toggle-datepicker');

        if (datepicker.prop('disabled')) {
            datepicker.prop('disabled', false);  // Włącz input
            datepicker.attr('placeholder', 'Wybierz datę');  // Usuń placeholder
            button.text('Wyłącz'); // Zmień tekst przycisku na "Wyłącz Kalendarz"
        } else {
            datepicker.prop('disabled', true);  // Wyłącz input
            datepicker.attr('placeholder', 'Pole wyłączone');  // Ustaw placeholder
            datepicker.val(''); // Wyczyść pole, jeśli wcześniej wybrano datę
            button.text('Włącz'); // Zmień tekst przycisku na "Włącz Kalendarz"
        }
    });

    if ($('#usageCount').prop('disabled')) {
        $('#toggle-usageCount').text('Włącz');
    }

    $('#toggle-usageCount').click(function() {
        var usageCount = $('#usageCount');
        var button = $('#toggle-usageCount');

        if (usageCount.prop('disabled')) {
            usageCount.prop('disabled', false);  // Włącz input
            usageCount.attr('placeholder', '1');  // Usuń placeholder
            button.text('Wyłącz'); // Zmień tekst przycisku na "Wyłącz Kalendarz"
        } else {
            usageCount.prop('disabled', true);  // Wyłącz input
            usageCount.attr('placeholder', 'Pole wyłączone (domyślnie 1)');  // Ustaw placeholder
            usageCount.val(''); // Wyczyść pole, jeśli wcześniej wybrano datę
            button.text('Włącz'); // Zmień tekst przycisku na "Włącz Kalendarz"
        }
    });

    $('#toggle-maxTime').click(function() {
        var usageCount = $('#maxTime');
        var button = $('#toggle-maxTime');

        if (usageCount.prop('disabled')) {
            usageCount.prop('disabled', false);  // Włącz input
            usageCount.attr('placeholder', '60');  // Usuń placeholder
            button.text('Wyłącz'); // Zmień tekst przycisku na "Wyłącz Kalendarz"
        } else {
            usageCount.prop('disabled', true);  // Wyłącz input
            usageCount.attr('placeholder', 'Pole wyłączone (domyślnie nielimitowany czas)');  // Ustaw placeholder
            usageCount.val(''); // Wyczyść pole, jeśli wcześniej wybrano datę
            button.text('Włącz'); // Zmień tekst przycisku na "Włącz Kalendarz"
        }
    });

})(jQuery);
