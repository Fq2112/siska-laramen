<?php

namespace App\Events\Partners;

use App\PartnerCredential;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserPartnershipEmail
{
    use Dispatchable, SerializesModels;
    public $partnership, $filename;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PartnerCredential $partnership, $filename)
    {
        $this->partnership = $partnership;
        $this->filename = $filename;
    }
}
