<?php

namespace App\Mail;

use App\Models\Child;
use App\Models\ParentModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChildTaggedToParent extends Mailable
{
    use Queueable, SerializesModels;

    public $child;
    public $parent;

    public function __construct(Child $child, ParentModel $parent)
    {
        $this->child = $child;
        $this->parent = $parent;
    }

    public function build()
    {
        return $this->subject('Your Child Has Been Tagged')
                    ->view('emails.child_tagged_to_parent');
    }
}
