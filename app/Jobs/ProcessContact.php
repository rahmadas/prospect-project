<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contact; // Deklarasikan properti $contact

    /**
     * Create a new job instance.
     */

    public function __construct(Contact $contact)
    {
        $this->contact = $contact; // Inisialisasi properti $contact
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $contact = $this->contact; // Lakukan tugas yang perlu dijalankan asinkron dengan data kontak
    }
}
