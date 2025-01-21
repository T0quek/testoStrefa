<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotInPolishWordlist implements ValidationRule
{
    protected array $wordlist;

    public function __construct()
    {
        // Wczytaj wordlistę do pamięci
        $path = storage_path('wordlists/wordlist_pl.txt');
        if (file_exists($path)) {
            $this->wordlist = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            $this->wordlist = [];
        }
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Sprawdź, czy hasło znajduje się na liście
        if (in_array($value, $this->wordlist)) {
            $fail('Podane hasło znajduje się na liście słabych haseł. Wybierz inne.');
        }
    }
}
