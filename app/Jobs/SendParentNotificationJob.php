<?php

namespace App\Jobs;

use App\Models\Child;
use App\Models\ParentModel;
use Illuminate\Bus\Queueable;
use App\Mail\ChildTaggedToParent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendParentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $child;
    public $parentIds;

    public function __construct(Child $child, array $parentIds)
    {
        $this->child = $child;
        $this->parentIds = $parentIds;
    }

    public function handle()
    {
        $parents = ParentModel::whereIn('id', $this->parentIds)->get();

        foreach ($parents as $parent) {
            Mail::to($parent->email)->send(new ChildTaggedToParent($this->child, $parent));
        }
    }
}
