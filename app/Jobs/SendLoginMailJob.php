<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\LoginMail;
use Mail;

class SendLoginMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $name;

    private $delayInSec;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $name, int $delayInSec=5)
    {
        $this->email = $email;
        $this->name = $name;
        $this->delayInSec = $delayInSec;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep($this->delayInSec);
        Mail::to($this->email)->send(new LoginMail($this->name));
    }

    public function delay()
    {
        return $this->delayInSec;
    }

}
