<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Administrator
        DB::table("users")->insert([
            ["name" => "Tomasz Gudyka", "email" => "tomaszgudyka@gmail.com", "role"=>"admin", "password" => '$2y$10$/W0epjSAQ62nljKzo1W6OuCnxzQqpiZROUDk6j9jR2Ld9FseP5yOC', "status"=>1],
            ["name" => "Szymon Soszka", "email" => "272224@student.pwr.edu.pl", "role"=>"admin", "password" => '$2y$10$56Em0gI/6yAXzeYXRexabuud0Xof5bP.cbLKIbSgPkdqlVmTpG0su', "status"=>1],
            ["name" => "Kamil Kałużny", "email" => "apps@ximix.pl", "role"=>"admin", "password" => '$2y$10$vgEtK/v7vdTHXhlW9sBoVul3srGoE42vltJwclvmpwVB6mcIyv0Zu', "status"=>1],
       ]);

        //
        DB::table("courses")->insert([
            ["name"=>"Kryptografia", "description"=>"Kurs obejmuje zakres wiedzy z przedmiotu Kryptografia 1, zawiera sekcje tematyczne: kryptografia symetryczna, kryptografia asymetryczna, systemy kryptograficzne oraz certyfikaty"],
            ["name"=>"Usługi i aplikacje multimedialne", "description"=>"Kurs obejmuje zakres wiedzy z przedmiotu Usługi i aplikacje ..."]
        ]);

        DB::table("sets")->insert([
            ["name"=>"Kryptografia symetryczna", "description"=>"Opis zestawu", "course_id"=>1, "creator_id"=>1],
            ["name"=>"Kryptografia asymetryczna", "description"=>"Opis zestawu", "course_id"=>1, "creator_id"=>1],
            ["name"=>"Systemy kryptograficzne", "description"=>"Opis zestawu", "course_id"=>1, "creator_id"=>1],
            ["name"=>"Certyfikaty", "description"=>"Opis zestawu", "course_id"=>1, "creator_id"=>1],
            ["name"=>"Dostawcy usług", "description"=>"Zadania o dostawcach usług multimedialnych typu Netflix, Spotify itp.", "course_id"=>2, "creator_id"=>2],
            ["name"=>"Narzędzia multimedialne", "description"=>"Zadania oparte na narzędziach multimedialnych", "course_id"=>2, "creator_id"=>1],
            ["name"=>"Usługi sieciowe", "description"=>"Opis zestawu Usługi sieciowe w kursie Usługi i aplikacje multimedialne", "course_id"=>2, "creator_id"=>2],
        ]);

        DB::table("accesses")->insert([
           ["user_id"=>1, "creator_id"=>1, "set_id"=>1],
           ["user_id"=>1, "creator_id"=>1, "set_id"=>2],
           ["user_id"=>1, "creator_id"=>1, "set_id"=>3],
           ["user_id"=>1, "creator_id"=>1, "set_id"=>4],
           ["user_id"=>1, "creator_id"=>1, "set_id"=>5],
           ["user_id"=>1, "creator_id"=>1, "set_id"=>6],
           ["user_id"=>1, "creator_id"=>1, "set_id"=>7],

           ["user_id"=>2, "creator_id"=>1, "set_id"=>1],
           ["user_id"=>2, "creator_id"=>1, "set_id"=>2],
           ["user_id"=>2, "creator_id"=>1, "set_id"=>3],
           ["user_id"=>2, "creator_id"=>1, "set_id"=>4],
           ["user_id"=>2, "creator_id"=>1, "set_id"=>5],
           ["user_id"=>2, "creator_id"=>1, "set_id"=>6],
           ["user_id"=>2, "creator_id"=>1, "set_id"=>7],

           ["user_id"=>3, "creator_id"=>1, "set_id"=>1],
           ["user_id"=>3, "creator_id"=>1, "set_id"=>2],
           ["user_id"=>3, "creator_id"=>1, "set_id"=>3],
           ["user_id"=>3, "creator_id"=>1, "set_id"=>4],
           ["user_id"=>3, "creator_id"=>1, "set_id"=>5],
           ["user_id"=>3, "creator_id"=>1, "set_id"=>6],
           ["user_id"=>3, "creator_id"=>1, "set_id"=>7],

        ]);

        DB::table("questions")->insert([
            ["type"=>1, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Która z poniższych metod jest uznawana za symetryczną metodę szyfrowania?\", \"type\": 1, \"answers\": [\"RSA\", \"AES\", \"DSA\", \"Diffie-Hellman\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych algorytmów są używane w kryptografii asymetrycznej?\", \"type\": 2, \"answers\": [\"RSA\", \"ECDSA\", \"AES\", \"Blowfish\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Szyfrowanie symetryczne używa [$] klucza, podczas gdy szyfrowanie asymetryczne używa [$] kluczy.\", \"type\": 3, \"answers\": [[\"jednego\", \"dwóch\", \"wielu\"], [\"jednego\", \"dwóch\", \"wielu\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Podaj standardową długość klucza w AES-128\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"128\"]}"],
            ["type"=>1, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów nie jest algorytmem szyfrowania symetrycznego?\", \"type\": 1, \"answers\": [\"Blowfish\", \"RC4\", \"RSA\", \"DES\"], \"correctAnswers\": [2]}"],
            ["type"=>2, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych funkcji są funkcjami skrótu?\", \"type\": 2, \"answers\": [\"MD5\", \"SHA-256\", \"RSA\", \"AES\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Skrót MD5 ma [$] bitów, a SHA-256 ma [$] bitów.\", \"type\": 3, \"answers\": [[\"128\", \"160\", \"256\"], [\"128\", \"160\", \"256\"]], \"correctAnswers\": [0, 2]}"],
            ["type"=>4, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Podaj standardową długość klucza w SHA-1\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"160\"]}"],
            ["type"=>1, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Który algorytm używa pary kluczy publicznego i prywatnego?\", \"type\": 1, \"answers\": [\"AES\", \"RSA\", \"DES\", \"Blowfish\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych są algorytmami szyfrowania symetrycznego?\", \"type\": 2, \"answers\": [\"DES\", \"3DES\", \"AES\", \"ECDSA\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>1, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Która instytucja zajmuje się wydawaniem certyfikatów SSL?\", \"type\": 1, \"answers\": [\"Root CA\", \"Urząd certyfikacji\", \"Klient TLS\", \"DNS\"], \"correctAnswers\": [1]}"],
            ["type"=>3, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Certyfikat potwierdza [$] oraz szyfruje [$] przesyłane między klientem i serwerem.\", \"type\": 3, \"answers\": [[\"tożsamość\", \"autoryzację\"], [\"dane\", \"wiadomości\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Podaj długość klucza dla RSA-2048\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"2048\"]}"],
            ["type"=>1, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Który protokół został zaprojektowany jako następca SSL?\", \"type\": 1, \"answers\": [\"HTTPS\", \"TLS\", \"IPSec\", \"FTP\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych są typami certyfikatów SSL?\", \"type\": 2, \"answers\": [\"DV\", \"OV\", \"EV\", \"Self-signed\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>1, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Który algorytm jest uznawany za bezpieczny obecnie?\", \"type\": 1, \"answers\": [\"SHA-1\", \"SHA-256\", \"MD5\", \"RC4\"], \"correctAnswers\": [1]}"],
            ["type"=>3, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Symetryczne szyfrowanie używa [$], a asymetryczne [$] kluczy.\", \"type\": 3, \"answers\": [[\"jednego\", \"dwóch\"], [\"jednego\", \"dwóch\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>1, "creator_id"=>1, "data"=>"{\"title\": \"Podaj czas życia certyfikatu EV (w miesiącach)\", \"type\": 4, \"suffix\": \"\", \"correctAnswers\": [\"12\"]}"],

            ["type"=>1, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów jest używany w kryptografii asymetrycznej?\", \"type\": 1, \"answers\": [\"RSA\", \"AES\", \"DES\", \"Blowfish\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych algorytmów są kryptograficzne asymetryczne?\", \"type\": 2, \"answers\": [\"RSA\", \"ECC\", \"AES\", \"3DES\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Kryptografia asymetryczna wykorzystuje parę kluczy: klucz [$] i klucz [$]\", \"type\": 3, \"answers\": [[\"prywatny\", \"publiczny\", \"symetryczny\"], [\"prywatny\", \"publiczny\", \"symetryczny\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Podaj maksymalny rozmiar klucza w algorytmie RSA\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"4096\"]}"],
            ["type"=>1, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów NIE jest asymetryczny?\", \"type\": 1, \"answers\": [\"RSA\", \"ECDSA\", \"AES\", \"Diffie-Hellman\"], \"correctAnswers\": [2]}"],
            ["type"=>2, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych zastosowań wykorzystuje kryptografię asymetryczną?\", \"type\": 2, \"answers\": [\"Podpisy cyfrowe\", \"Szyfrowanie wiadomości\", \"Weryfikacja certyfikatów\", \"Szyfrowanie symetryczne\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>3, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Algorytm RSA wymaga kluczy o długości [$] bitów do zapewnienia bezpieczeństwa\", \"type\": 3, \"answers\": [[\"1024\", \"2048\", \"4096\"], [\"256\", \"512\", \"1024\"]], \"correctAnswers\": [1, 2]}"],
            ["type"=>4, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę algorytmu asymetrycznego opartego na eliptycznych krzywych\", \"type\": 4, \"correctAnswers\": [\"ECC\"]}"],
            ["type"=>1, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów wykorzystuje Diffie-Hellmana?\", \"type\": 1, \"answers\": [\"ECDH\", \"RSA\", \"AES\", \"SHA\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"W kryptografii asymetrycznej klucz publiczny jest używany do:\", \"type\": 2, \"answers\": [\"Szyfrowania\", \"Deszyfrowania\", \"Podpisu cyfrowego\", \"Weryfikacji podpisu\"], \"correctAnswers\": [0, 3]}"],
            ["type"=>1, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Co jest podstawową zaletą kryptografii asymetrycznej?\", \"type\": 1, \"answers\": [\"Szybkość\", \"Łatwość użycia\", \"Brak potrzeby wymiany kluczy\", \"Prostota implementacji\"], \"correctAnswers\": [2]}"],
            ["type"=>3, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Klucz prywatny jest [$] i nie powinien być udostępniany [$].\", \"type\": 3, \"answers\": [[\"tajny\", \"publiczny\"], [\"nikomu\", \"wszystkim\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Podaj rok powstania algorytmu RSA\", \"type\": 4, \"suffix\": \"rok\", \"correctAnswers\": [\"1978\"]}"],
            ["type"=>1, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Który algorytm asymetryczny używa krzywych eliptycznych?\", \"type\": 1, \"answers\": [\"ECC\", \"RSA\", \"SHA\", \"AES\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Jakie cechy wyróżniają kryptografię asymetryczną?\", \"type\": 2, \"answers\": [\"Użycie dwóch kluczy\", \"Brak wymiany kluczy\", \"Duża szybkość\", \"Możliwość podpisu cyfrowego\"], \"correctAnswers\": [0, 1, 3]}"],
            ["type"=>3, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"W kryptografii asymetrycznej algorytm [$] opiera się na problemie rozkładu na czynniki. Algorytm [$] korzysta z krzywych eliptycznych.\", \"type\": 3, \"answers\": [[\"RSA\", \"ECC\", \"AES\"], [\"RSA\", \"ECC\", \"SHA\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę protokołu opartego na kryptografii asymetrycznej używanego w HTTPS\", \"type\": 4, \"correctAnswers\": [\"TLS\"]}"],
            ["type"=>1, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Co jest głównym zastosowaniem kryptografii asymetrycznej?\", \"type\": 1, \"answers\": [\"Szyfrowanie danych\", \"Podpis cyfrowy\", \"Weryfikacja tożsamości\", \"Wszystkie powyższe\"], \"correctAnswers\": [3]}"],
            ["type"=>3, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Klucz publiczny jest udostępniany [$], a klucz prywatny pozostaje [$].\", \"type\": 3, \"answers\": [[\"publicznie\", \"prywatnie\"], [\"tajny\", \"jawny\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>2, "creator_id"=>1, "data"=>"{\"title\": \"Podaj minimalną zalecaną długość klucza dla algorytmu RSA (bitów)\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"2048\"]}"],

            ["type"=>1, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych jest systemem kryptograficznym opartym na kluczu publicznym?\", \"type\": 1, \"answers\": [\"RSA\", \"DES\", \"3DES\", \"Blowfish\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych systemów kryptograficznych są symetryczne?\", \"type\": 2, \"answers\": [\"AES\", \"3DES\", \"RSA\", \"Diffie-Hellman\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Systemy kryptograficzne dzielą się na [$] oraz [$] systemy szyfrowania.\", \"type\": 3, \"answers\": [[\"symetryczne\", \"asymetryczne\"], [\"publiczne\", \"prywatne\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Podaj maksymalną długość klucza w AES (bitów)\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"256\"]}"],
            ["type"=>1, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych systemów kryptograficznych NIE jest symetryczny?\", \"type\": 1, \"answers\": [\"AES\", \"3DES\", \"RSA\", \"Blowfish\"], \"correctAnswers\": [2]}"],
            ["type"=>2, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"W kryptografii symetrycznej klucz służy do:\", \"type\": 2, \"answers\": [\"Szyfrowania\", \"Deszyfrowania\", \"Podpisu cyfrowego\", \"Weryfikacji podpisu\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"W systemach kryptograficznych asymetrycznych używa się [$] klucza publicznego i [$] klucza prywatnego.\", \"type\": 3, \"answers\": [[\"jednego\", \"dwóch\"], [\"publicznego\", \"prywatnego\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę algorytmu kryptograficznego używanego w Bitcoin\", \"type\": 4, \"correctAnswers\": [\"SHA-256\"]}"],
            ["type"=>1, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych systemów kryptograficznych wykorzystuje krzywe eliptyczne?\", \"type\": 1, \"answers\": [\"AES\", \"ECC\", \"RSA\", \"MD5\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych algorytmów są odpowiednie do szyfrowania symetrycznego?\", \"type\": 2, \"answers\": [\"Blowfish\", \"AES\", \"3DES\", \"ECDSA\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>1, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów jest zaliczany do systemów kryptograficznych opartych na podpisie cyfrowym?\", \"type\": 1, \"answers\": [\"RSA\", \"ECDSA\", \"SHA\", \"AES\"], \"correctAnswers\": [1]}"],
            ["type"=>3, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Szyfrowanie symetryczne wykorzystuje [$] klucz, podczas gdy asymetryczne wykorzystuje [$] klucze.\", \"type\": 3, \"answers\": [[\"jeden\", \"dwa\"], [\"jeden\", \"dwa\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę funkcji skrótu SHA używanej do tworzenia sum kontrolnych\", \"type\": 4, \"correctAnswers\": [\"SHA-1\"]}"],
            ["type"=>1, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów jest uważany za przestarzały?\", \"type\": 1, \"answers\": [\"RSA\", \"SHA-256\", \"DES\", \"ECC\"], \"correctAnswers\": [2]}"],
            ["type"=>2, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Które cechy opisują kryptografię symetryczną?\", \"type\": 2, \"answers\": [\"Jeden klucz\", \"Szybkie szyfrowanie\", \"Brak podpisu cyfrowego\", \"Weryfikacja tożsamości\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>3, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"W systemach asymetrycznych algorytm [$] opiera się na trudności faktoryzacji liczb. Algorytm [$] wykorzystuje krzywe eliptyczne.\", \"type\": 3, \"answers\": [[\"RSA\", \"ECC\", \"AES\"], [\"RSA\", \"ECC\", \"SHA\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę systemu szyfrowania wykorzystywanego w sieciach Wi-Fi\", \"type\": 4, \"correctAnswers\": [\"WPA2\"]}"],
            ["type"=>1, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych algorytmów NIE wykorzystuje szyfrowania symetrycznego?\", \"type\": 1, \"answers\": [\"AES\", \"RSA\", \"DES\", \"Blowfish\"], \"correctAnswers\": [1]}"],
            ["type"=>3, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"W systemach kryptograficznych symetrycznych klucz jest [$], a w asymetrycznych [$].\", \"type\": 3, \"answers\": [[\"tajny\", \"publiczny\"], [\"publiczny\", \"prywatny\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>3, "creator_id"=>1, "data"=>"{\"title\": \"Podaj długość klucza w algorytmie DES\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"56\"]}"],

            ["type"=>1, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Która instytucja jest odpowiedzialna za wydawanie certyfikatów SSL?\", \"type\": 1, \"answers\": [\"Root CA\", \"Urząd certyfikacji (CA)\", \"Serwer DNS\", \"Klient TLS\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Które elementy znajdują się w certyfikacie SSL?\", \"type\": 2, \"answers\": [\"Klucz publiczny\", \"Podpis cyfrowy CA\", \"Klucz prywatny\", \"Adres URL serwera\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Certyfikat SSL zapewnia [$] oraz [$] danych przesyłanych między klientem a serwerem.\", \"type\": 3, \"answers\": [[\"weryfikację\", \"szyfrowanie\", \"autoryzację\"], [\"integralność\", \"poufność\", \"autoryzację\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Podaj standardową długość klucza w certyfikatach RSA-2048\", \"type\": 4, \"suffix\": \"bit\", \"correctAnswers\": [\"2048\"]}"],
            ["type"=>1, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Który protokół jest następcą SSL?\", \"type\": 1, \"answers\": [\"HTTPS\", \"TLS\", \"IPSec\", \"SSL 3.0\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych są typami certyfikatów SSL?\", \"type\": 2, \"answers\": [\"DV\", \"OV\", \"EV\", \"Wildcard\"], \"correctAnswers\": [0, 1, 2, 3]}"],
            ["type"=>3, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Certyfikat EV zapewnia [$], podczas gdy certyfikat DV jedynie [$]\", \"type\": 3, \"answers\": [[\"pełną weryfikację tożsamości\", \"podstawową weryfikację tożsamości\"], [\"szyfrowanie danych\", \"weryfikację domeny\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Podaj maksymalny czas ważności certyfikatu SSL (w miesiącach)\", \"type\": 4, \"suffix\": \"miesięcy\", \"correctAnswers\": [\"13\"]}"],
            ["type"=>1, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych jest używany jako unikalny identyfikator certyfikatu SSL?\", \"type\": 1, \"answers\": [\"Numer seryjny\", \"Podpis cyfrowy\", \"Algorytm szyfrowania\", \"Klucz publiczny\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Które protokoły są związane z certyfikatami SSL?\", \"type\": 2, \"answers\": [\"TLS\", \"HTTPS\", \"FTP\", \"SCP\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>1, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Który typ certyfikatu SSL jest najbardziej zaawansowany?\", \"type\": 1, \"answers\": [\"DV\", \"OV\", \"EV\", \"Wildcard\"], \"correctAnswers\": [2]}"],
            ["type"=>3, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Certyfikat SSL z walidacją domeny (DV) potwierdza jedynie [$], a certyfikat EV potwierdza również [$].\", \"type\": 3, \"answers\": [[\"tożsamość organizacji\", \"własność domeny\", \"lokalizację serwera\"], [\"tożsamość organizacji\", \"własność domeny\", \"algorytm szyfrowania\"]], \"correctAnswers\": [1, 0]}"],
            ["type"=>4, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę standardu, który definiuje format certyfikatów cyfrowych\", \"type\": 4, \"correctAnswers\": [\"X.509\"]}"],
            ["type"=>1, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Który algorytm jest wykorzystywany w certyfikatach SSL?\", \"type\": 1, \"answers\": [\"RSA\", \"AES\", \"SHA\", \"Blowfish\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Które informacje są zawarte w certyfikacie SSL?\", \"type\": 2, \"answers\": [\"Adres IP serwera\", \"Klucz publiczny\", \"Podpis cyfrowy CA\", \"Nazwa domeny\"], \"correctAnswers\": [1, 2, 3]}"],
            ["type"=>3, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Certyfikat SSL jest wymagany do [$] oraz [$] danych.\", \"type\": 3, \"answers\": [[\"weryfikacji\", \"szyfrowania\"], [\"autoryzacji\", \"integralności\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Podaj maksymalny czas życia certyfikatu Wildcard\", \"type\": 4, \"suffix\": \"miesięcy\", \"correctAnswers\": [\"13\"]}"],
            ["type"=>1, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Który certyfikat zapewnia największy poziom weryfikacji tożsamości?\", \"type\": 1, \"answers\": [\"DV\", \"OV\", \"EV\", \"Wildcard\"], \"correctAnswers\": [2]}"],
            ["type"=>3, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Numer seryjny certyfikatu SSL jest [$], a podpis cyfrowy jest [$].\", \"type\": 3, \"answers\": [[\"unikalny\", \"niepowtarzalny\"], [\"szyfrowany\", \"zaszyfrowany\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>4, "creator_id"=>1, "data"=>"{\"title\": \"Podaj typ certyfikatu SSL, który obejmuje subdomeny\", \"type\": 4, \"correctAnswers\": [\"Wildcard\"]}"],

            ["type"=>1, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Która z poniższych platform oferuje streaming muzyki?\", \"type\": 1, \"answers\": [\"Netflix\", \"Spotify\", \"Hulu\", \"Amazon\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych są usługami streamingowymi?\", \"type\": 2, \"answers\": [\"Netflix\", \"HBO Max\", \"Spotify\", \"Facebook\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>3, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Dostawcy usług multimedialnych, takich jak [$], oferują streaming filmów, podczas gdy dostawcy tacy jak [$] skupiają się na muzyce.\", \"type\": 3, \"answers\": [[\"Netflix\", \"Spotify\", \"YouTube\"], [\"Spotify\", \"Apple Music\", \"Tidal\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Podaj rok założenia platformy Netflix\", \"type\": 4, \"suffix\": \"rok\", \"correctAnswers\": [\"1997\"]}"],
            ["type"=>1, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Która z poniższych usług umożliwia streaming wideo na żądanie?\", \"type\": 1, \"answers\": [\"Tidal\", \"Hulu\", \"Amazon Music\", \"Deezer\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Które usługi oferują zarówno streaming muzyki, jak i wideo?\", \"type\": 2, \"answers\": [\"YouTube\", \"Amazon Prime\", \"Spotify\", \"Netflix\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Aplikacje multimedialne, takie jak [$], oferują treści muzyczne, podczas gdy aplikacje takie jak [$] koncentrują się na treściach wideo.\", \"type\": 3, \"answers\": [[\"Spotify\", \"Tidal\", \"Apple Music\"], [\"Netflix\", \"Hulu\", \"HBO Max\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę usługi streamingowej, która jako pierwsza wprowadziła model subskrypcyjny dla filmów\", \"type\": 4, \"correctAnswers\": [\"Netflix\"]}"],
            ["type"=>1, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Która z poniższych platform specjalizuje się w streamingowaniu muzyki wysokiej jakości?\", \"type\": 1, \"answers\": [\"Spotify\", \"Tidal\", \"Amazon Music\", \"YouTube\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Które platformy oferują plany rodzinne na subskrypcje?\", \"type\": 2, \"answers\": [\"Spotify\", \"Netflix\", \"Tidal\", \"YouTube Premium\"], \"correctAnswers\": [0, 1, 2, 3]}"],
            ["type"=>1, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Która platforma umożliwia streaming na żądanie bez reklam w wersji Premium?\", \"type\": 1, \"answers\": [\"Netflix\", \"Hulu\", \"Spotify\", \"Wszystkie powyższe\"], \"correctAnswers\": [3]}"],
            ["type"=>3, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Dostawcy usług multimedialnych, tacy jak [$], koncentrują się na treściach filmowych, natomiast [$] oferują muzykę na żądanie.\", \"type\": 3, \"answers\": [[\"Netflix\", \"HBO Max\", \"YouTube\"], [\"Spotify\", \"Apple Music\", \"Deezer\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę najczęściej używanej platformy do streamingu muzyki na świecie\", \"type\": 4, \"correctAnswers\": [\"Spotify\"]}"],
            ["type"=>1, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Która z poniższych usług oferuje treści dostępne offline dla subskrybentów?\", \"type\": 1, \"answers\": [\"Netflix\", \"Spotify\", \"Amazon Prime\", \"Wszystkie powyższe\"], \"correctAnswers\": [3]}"],
            ["type"=>2, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Które platformy oferują oryginalne treści multimedialne?\", \"type\": 2, \"answers\": [\"Netflix\", \"HBO Max\", \"Spotify\", \"Amazon Prime\"], \"correctAnswers\": [0, 1, 3]}"],
            ["type"=>3, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"W modelu subskrypcyjnym użytkownicy płacą miesięczną opłatę za dostęp do [$], natomiast usługi darmowe są finansowane przez [$].\", \"type\": 3, \"answers\": [[\"treści premium\", \"reklamy\"], [\"abonament\", \"sponsorów\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę platformy, która jest liderem streamingu wideo na żądanie\", \"type\": 4, \"correctAnswers\": [\"Netflix\"]}"],
            ["type"=>1, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Która platforma jako pierwsza wprowadziła treści oryginalne?\", \"type\": 1, \"answers\": [\"Netflix\", \"Hulu\", \"Amazon Prime\", \"HBO Max\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>5, "creator_id"=>1, "data"=>"{\"title\": \"Które platformy oferują treści w jakości Ultra HD?\", \"type\": 2, \"answers\": [\"Netflix\", \"Amazon Prime\", \"Hulu\", \"Spotify\"], \"correctAnswers\": [0, 1]}"],

            ["type"=>1, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych narzędzi służy do edycji grafiki rastrowej?\", \"type\": 1, \"answers\": [\"Photoshop\", \"Premiere Pro\", \"Audacity\", \"Blender\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które z narzędzi są przeznaczone do obróbki wideo?\", \"type\": 2, \"answers\": [\"Premiere Pro\", \"Final Cut Pro\", \"Audacity\", \"DaVinci Resolve\"], \"correctAnswers\": [0, 1, 3]}"],
            ["type"=>3, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Narzędzia takie jak [$] służą do obróbki zdjęć, natomiast narzędzia takie jak [$] do montażu wideo.\", \"type\": 3, \"answers\": [[\"Photoshop\", \"GIMP\", \"Affinity Photo\"], [\"Premiere Pro\", \"Final Cut Pro\", \"DaVinci Resolve\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę narzędzia do tworzenia grafiki wektorowej\", \"type\": 4, \"correctAnswers\": [\"Illustrator\"]}"],
            ["type"=>1, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które narzędzie służy do edycji dźwięku?\", \"type\": 1, \"answers\": [\"Audacity\", \"Photoshop\", \"Blender\", \"After Effects\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych programów są darmowe?\", \"type\": 2, \"answers\": [\"GIMP\", \"Audacity\", \"DaVinci Resolve\", \"Photoshop\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>3, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Do obróbki grafiki wektorowej używa się [$], natomiast do montażu dźwięku [$].\", \"type\": 3, \"answers\": [[\"Illustrator\", \"CorelDRAW\", \"Figma\"], [\"Audacity\", \"GarageBand\", \"FL Studio\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę popularnego programu do montażu wideo używanego w branży filmowej\", \"type\": 4, \"correctAnswers\": [\"DaVinci Resolve\"]}"],
            ["type"=>1, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które z narzędzi jest używane do tworzenia animacji 3D?\", \"type\": 1, \"answers\": [\"Blender\", \"Photoshop\", \"Audacity\", \"Figma\"], \"correctAnswers\": [0]}"],
            ["type"=>2, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które programy służą do edycji grafiki rastrowej?\", \"type\": 2, \"answers\": [\"Photoshop\", \"GIMP\", \"CorelDRAW\", \"Illustrator\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Do edycji wideo można użyć narzędzi takich jak [$], a do edycji grafiki rastrowej [$].\", \"type\": 3, \"answers\": [[\"Premiere Pro\", \"DaVinci Resolve\", \"Final Cut Pro\"], [\"Photoshop\", \"GIMP\", \"Affinity Photo\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę darmowego programu do edycji grafiki rastrowej\", \"type\": 4, \"correctAnswers\": [\"GIMP\"]}"],
            ["type"=>1, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych programów NIE jest przeznaczony do edycji grafiki?\", \"type\": 1, \"answers\": [\"GIMP\", \"Photoshop\", \"Audacity\", \"Affinity Photo\"], \"correctAnswers\": [2]}"],
            ["type"=>2, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które z poniższych narzędzi oferują obsługę warstw?\", \"type\": 2, \"answers\": [\"Photoshop\", \"GIMP\", \"Blender\", \"Audacity\"], \"correctAnswers\": [0, 1]}"],
            ["type"=>3, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"W obróbce grafiki narzędzia takie jak [$] są używane do grafiki rastrowej, a [$] do grafiki wektorowej.\", \"type\": 3, \"answers\": [[\"Photoshop\", \"GIMP\", \"Affinity Photo\"], [\"Illustrator\", \"CorelDRAW\", \"Figma\"]], \"correctAnswers\": [0, 0]}"],
            ["type"=>4, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę programu służącego do tworzenia prezentacji multimedialnych\", \"type\": 4, \"correctAnswers\": [\"PowerPoint\"]}"],
            ["type"=>1, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Który z poniższych programów jest darmowym narzędziem do edycji wideo?\", \"type\": 1, \"answers\": [\"Premiere Pro\", \"DaVinci Resolve\", \"Final Cut Pro\", \"Sony Vegas\"], \"correctAnswers\": [1]}"],
            ["type"=>2, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Które programy pozwalają na tworzenie grafiki 3D?\", \"type\": 2, \"answers\": [\"Blender\", \"Maya\", \"Cinema 4D\", \"Audacity\"], \"correctAnswers\": [0, 1, 2]}"],
            ["type"=>3, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Do tworzenia grafik używanych w multimediach służą narzędzia takie jak [$] do wektorowej i [$] do rastrowej.\", \"type\": 3, \"answers\": [[\"Illustrator\", \"CorelDRAW\", \"Figma\"], [\"Photoshop\", \"GIMP\", \"Affinity Photo\"]], \"correctAnswers\": [0, 1]}"],
            ["type"=>4, "set_id"=>6, "creator_id"=>1, "data"=>"{\"title\": \"Podaj nazwę darmowego programu do montażu dźwięku\", \"type\": 4, \"correctAnswers\": [\"Audacity\"]}"]

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
