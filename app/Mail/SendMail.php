<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $mailBody;
    protected $attachmentArray = [];
    public $subject;
    protected $senderName;
    protected $dataInTemplateArray = [];

    public function __construct($mailBody, $attachmentArray, $subject, $senderName, $view, $dataInTemplateArray=null)
    {
        $this->mailBody = $mailBody;
        $this->attachmentArray = $attachmentArray;
        $this->subject = $subject;
        $this->senderName = $senderName;
        $this->view = $view;
        $this->dataInTemplateArray = $dataInTemplateArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('xxx.report@yyy.com',$this->senderName)
                ->subject($this->subject)
                ->view($this->view)
                ->with([
                    'mailBody'=>$this->mailBody,
                    'dataInTemplateArray'=>$this->dataInTemplateArray,
                ]);
        foreach($this->attachmentArray as $singleAttachment):
            $this->attach($singleAttachment);
        endforeach;
        return $this;
    }
}
