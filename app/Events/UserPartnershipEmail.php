<?php

namespace App\Events;

use App\Partnership;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserPartnershipEmail
{
    use Dispatchable, SerializesModels;
    public $partnership;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Partnership $partnership)
    {
        $this->partnership = $partnership;
    }
}
