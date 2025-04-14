<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $token
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = route('set-password.form', ['id' => $this->user->id, 'token' => $this->token]);

        return $this->subject('Set Your Password')
                    ->view('emails.set-passowrd')
                    ->with([
                        'name' => $this->user->name,
                        'url' => $url,
                    ]);
    }
}
