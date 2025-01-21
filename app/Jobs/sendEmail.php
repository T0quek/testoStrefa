<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Monolog\Logger;
use Throwable;

class sendEmail implements ShouldQueue
{
    use Queueable;
    public $tries = 3;
    public $timeout = 120;

    public function __construct(public $email, public $params, public $type){}

    public function handle(): void
    {
        Validator::make(["email"=> $this->email], [
            'email' => 'required|string|email|max:255|exists:users,email'])->validate();


        Mail::send("email.{$this->type}", $this->params, function ($message) {
            $message->to($this->email);
            $message->subject($this->params["subject"] ?? "Wiadomość z testoStrefa.pl");
        });

    }

    public function failed(Throwable $exception): void
    {
        Log::error('Job send email failed: ' . $exception->getMessage(), [
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
