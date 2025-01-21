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
        DB::unprepared('DROP EVENT IF EXISTS ClearDBEvent');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteExpiredActivateTokens');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteExpiredResetTokens');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteExpiredAuthKeys');
        DB::unprepared('DROP FUNCTION IF EXISTS GetDistinctSetNamesByExam;');
        DB::unprepared('DROP FUNCTION IF EXISTS GetExamAverageScore;');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateExpiredExams;');

        // Procedura do tabeli activate_tokens
        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS DeleteExpiredActivateTokens()
            BEGIN
                DELETE FROM activate_tokens
                WHERE created_at < NOW() - INTERVAL 2 HOUR;
            END;
        ');

        // Procedura do tabeli password_reset_tokens
        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS DeleteExpiredResetTokens()
            BEGIN
                DELETE FROM password_reset_tokens
                WHERE created_at < NOW() - INTERVAL 2 HOUR;
            END;
        ');

        // Procedura do tabeli auth_keys
        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS DeleteExpiredAuthKeys()
            BEGIN
                DELETE FROM auth_keys
                WHERE JSON_UNQUOTE(JSON_EXTRACT(options, "$.dateTime")) < NOW();
            END;
        ');

        // Zdarzenie ClearDBEvent
        DB::unprepared('
            CREATE EVENT IF NOT EXISTS ClearDBEvent
            ON SCHEDULE EVERY 2 MINUTE
            DO
            BEGIN
                CALL DeleteExpiredActivateTokens();
                CALL DeleteExpiredResetTokens();
                CALL DeleteExpiredAuthKeys();
            END;
        ');

        //Funkcja do otrzymania setNames
        DB::unprepared('
            CREATE FUNCTION IF NOT EXISTS GetDistinctSetNamesByExam(exam_id INT)
            RETURNS TEXT
            DETERMINISTIC
            BEGIN
                DECLARE result TEXT;

                SELECT GROUP_CONCAT(DISTINCT sets.name SEPARATOR ", ")
                INTO result
                FROM exams
                INNER JOIN exam_questions ON exams.id = exam_questions.exam_id
                INNER JOIN questions ON exam_questions.question_id = questions.id
                INNER JOIN sets ON questions.set_id = sets.id
                WHERE exams.id = exam_id;

                RETURN result;
            END;
        ');

        // Funkcja otrzymywania wyniku egzaminu
        DB::unprepared('
            CREATE FUNCTION IF NOT EXISTS GetExamAverageScore(exam_id INT)
            RETURNS DECIMAL(5,2)
            DETERMINISTIC
            BEGIN
                DECLARE average_score DECIMAL(5,2);

                SELECT SUM(exam_questions.is_correct) / COUNT(exam_questions.id)
                INTO average_score
                FROM exams
                INNER JOIN exam_questions ON exams.id = exam_questions.exam_id
                WHERE exams.id = exam_id;

                RETURN average_score;
            END;
        ');


        // Funkcja do statystyk na stronie głównej
        DB::unprepared('
            CREATE FUNCTION GetUserStats(user_id INT)
            RETURNS JSON
            BEGIN
                DECLARE total_tests INT;
                DECLARE passed_tests INT;
                DECLARE failed_tests INT;
                DECLARE current_week_tests INT;
                DECLARE last_week_tests INT;
                DECLARE percent_change DECIMAL(10, 2);
                DECLARE average_score DECIMAL(10, 2);
                DECLARE monthly_stats JSON;

                -- Oblicz łączną liczbę rozwiązanych testów
                SELECT COUNT(DISTINCT exam_id)
                INTO total_tests
                FROM exam_questions
                WHERE exam_id IN (
                    SELECT id FROM exams WHERE creator_id = user_id AND status = 2
                );

                -- Oblicz liczbę zdanych testów (przyjmując, że test zaliczony to >= 50% poprawnych odpowiedzi)
                SELECT COUNT(*)
                INTO passed_tests
                FROM (
                    SELECT eq.exam_id, AVG(eq.is_correct) AS score
                    FROM exam_questions eq
                    INNER JOIN exams e ON eq.exam_id = e.id
                    WHERE e.creator_id = user_id AND e.status = 2
                    GROUP BY eq.exam_id
                    HAVING score >= 0.5
                ) AS passed;

                -- Oblicz liczbę niezdanych testów
                SET failed_tests = total_tests - passed_tests;

                -- Oblicz średni wynik procentowy za egzamin
                SELECT IFNULL(AVG(score) * 100, 0)
                INTO average_score
                FROM (
                    SELECT AVG(eq.is_correct) AS score
                    FROM exam_questions eq
                    INNER JOIN exams e ON eq.exam_id = e.id
                    WHERE e.creator_id = user_id AND e.status = 2
                    GROUP BY eq.exam_id
                ) AS scores;

                -- Oblicz liczbę testów rozwiązanych w bieżącym tygodniu
                SELECT COUNT(DISTINCT eq.exam_id)
                INTO current_week_tests
                FROM exam_questions eq
                INNER JOIN exams e ON eq.exam_id = e.id
                WHERE e.creator_id = user_id
                  AND e.status = 2
                  AND YEARWEEK(e.created_at, 1) = YEARWEEK(CURDATE(), 1);

                -- Oblicz liczbę testów rozwiązanych w zeszłym tygodniu
                SELECT COUNT(DISTINCT eq.exam_id)
                INTO last_week_tests
                FROM exam_questions eq
                INNER JOIN exams e ON eq.exam_id = e.id
                WHERE e.creator_id = user_id
                  AND e.status = 2
                  AND YEARWEEK(e.created_at, 1) = YEARWEEK(CURDATE(), 1) - 1;

                -- Oblicz procentową zmianę
                IF last_week_tests = 0 THEN
                    SET percent_change = NULL; -- Brak danych z zeszłego tygodnia
                ELSE
                    SET percent_change = ((current_week_tests - last_week_tests) / last_week_tests) * 100;
                END IF;

                -- Zwróć wynik jako JSON
                RETURN JSON_OBJECT(
                    `total_tests`, total_tests,
                    `passed_tests`, passed_tests,
                    `failed_tests`, failed_tests,
                    `current_week_tests, current_week_tests,
                    `last_week_tests`, last_week_tests,
                    `percent_change`, percent_change
                );
            END;
        ');

        // Zdarzenie do regularnej aktualizacji statusów
        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS UpdateExpiredExams()
            BEGIN
                UPDATE exams
                SET status = 1
                WHERE maxTime < NOW() AND maxTime IS NOT NULL AND status = 0;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP EVENT IF EXISTS ClearDBEvent');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteExpiredActivateTokens');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteExpiredResetTokens');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteExpiredAuthKeys');
        DB::unprepared('DROP FUNCTION IF EXISTS GetDistinctSetNamesByExam;');
        DB::unprepared('DROP FUNCTION IF EXISTS GetExamAverageScore;');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateExpiredExams;');
    }
};
