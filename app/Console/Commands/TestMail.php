<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class TestMail extends Command
{
    protected $signature = 'mail:test {email}';
    protected $description = 'Test sending OTP mail';

    public function handle()
    {
        $email = $this->argument('email');
        $this->info("Sending test OTP mail to: $email");

        try {
            Mail::to($email)->send(new PasswordResetMail('Test User', '123456'));
            $this->info('✅ Mail sent successfully!');
        } catch (\Exception $e) {
            $this->error('❌ Mail failed: ' . $e->getMessage());
        }
    }
}
