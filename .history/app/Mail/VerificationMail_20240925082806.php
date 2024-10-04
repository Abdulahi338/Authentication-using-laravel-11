<?php
class VerificationMail extends Mailable
{
    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('emails.verify')
                    ->subject('Verify your email address')
                    ->with(['token' => $this->token]);
    }
}
