<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeProteja extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $dados;

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
                    ->view('meproteja.mail')
                    ->with([
                        'model' => $dados,
                ]);

        return $envia;
    }
}
