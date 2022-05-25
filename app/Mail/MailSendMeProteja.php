<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSendMeProteja extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dados = $this->dados;
        $envia = $this->subject('Me Proteja Empresas')
                    ->from('meproteja@positivaconsultas.com.br')
                    ->view('meproteja.relatorio')
                    ->with([
                        'array' => $dados['array'],
                    ]);

        return $envia;
    }
}
