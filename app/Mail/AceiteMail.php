<?php

namespace App\Mail;

use App\Models\AceiteEletronico;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AceiteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $dados;
    public function __construct(Array $dados)
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
        $envia = $this->from('aceite@positivaconsultas.com.br')
                    ->subject('Positiva Consultas solicitou sua assinatura')
                    ->view('aceite.mail')
                    ->with([
                        'model' => $dados,
                ]);

        return $envia;
    }
}
