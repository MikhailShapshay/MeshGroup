<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Row;

class RowCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $row;

    public function __construct(Row $row)
    {
        $this->row = $row;
    }

    public function broadcastOn()
    {
        return new Channel('rows');
    }

    public function broadcastAs()
    {
        return 'row.created';
    }
}
