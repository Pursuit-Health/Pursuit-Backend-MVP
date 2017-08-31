<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-27
 * Time: 15:08
 */

namespace App\Mail;


use App\Constants\EmailActions;
use App\Models\Contracts\EmailLinkContract;
use App\Models\EmailLink;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $config;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->config = config('email_templates.forgotPassword');
    }

    public function build()
    {
        return $this->view($this->config['template'])
            ->with('link', $this->getLink())
            ->with('user', $this->user)
            ->subject($this->config['subject']);
    }

    public function getLink()
    {

        /**@var EmailLink $link */
        $link = EmailLink::query()->create([
            EmailLinkContract::USER_ID => $this->user->id,
            EmailLinkContract::ACTION => EmailActions::PASSWORD_RECOVER,
        ]);

        return route('email', ['destination' => 'forgot-password', 'hash' => $link->hash]);
    }
}