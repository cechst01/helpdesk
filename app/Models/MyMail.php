<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Mail\Mailable;
use PHPMailer\PHPMailer\PHPMailer;

class MyMail extends Model
{
    private $to;

    private $phpMailer;

    public function __construct(PHPMailer $mailer)    {

        $this->phpMailer = $mailer;
    }

    public function to($to){
        if($to instanceof User){
            $this->to = $to->email;
        }
        else if(is_string($to)){
            $this->to = $to;
        }
        else{
            throw new \InvalidArgumentException();
        }
        return $this;
    }

    public function send(Mailable $mail){

       $htmlBody =  $mail->render();
       $mail->build();

       $from = env('MAIL_FROM_ADDRESS','');

        $this->phpMailer->CharSet = 'UTF-8';
        $this->phpMailer->Subject = $mail->subject;
        $this->phpMailer->setFrom($from);
        $this->phpMailer->addAddress($this->to);
        $this->phpMailer->isHTML(true);
        $this->phpMailer->Body = $htmlBody;

        //This should be the same as the domain of your From address
        $this->phpMailer->DKIM_domain = 'helpdesk.leksys.cz';
        //Path to your private key:
        $this->phpMailer->DKIM_private = __DIR__ . '../config/privatekey.txt';
        //Set this to your own selector
        $this->phpMailer->DKIM_selector = 'phpmailer';
        //Put your private key's passphrase in here if it has one
        $this->phpMailer->DKIM_passphrase = '';
        //The identity you're signing as - usually your From address
        $this->phpMailer->DKIM_identity = $this->phpMailer->From;

        try {
            $this->phpMailer->send();
            //$this->flashMessage('Email byl odeslán', 'success');
        } catch (\Exception $ex) {
            //\Tracy\Debugger::log($ex);
            //$this->flashMessage('Email se nepodařilo odeslat', 'danger');
            dd($ex);
        }


    }
}
