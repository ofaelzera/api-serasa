<?php

namespace App\Models\Serasa;

use App\Models\ValidaCPFeCNPJ;
use Webklex\IMAP\Facades\Client;

class Gerencie
{
    public static function connect()
    {
        $client = Client::account('default');
        $client->connect();

        /*
        $folders = $client->getFolders();
        foreach($folders as $folder){

            $messages = $folder->messages()->all()->get();

            foreach($messages as $message){
                echo $message->getSubject().'<br />';
                echo 'Attachments: '.$message->getAttachments()->count().'<br />';
                echo $message->getHTMLBody();

                //Move the current Message to 'INBOX.read'
                if($message->move('INBOX.read') == true){
                    echo 'Message has ben moved';
                }else{
                    echo 'Message could not be moved';
                }
            }
        }
        */
        $folder = $client->getFolder('INBOX');
        $messages = $folder->messages()->all()->get();

        foreach($messages as $message){
            //echo $message->getSubject().'<br />';
            //echo 'Attachments: '.$message->getAttachments()->count().'<br />';
            //echo $message->getHTMLBody();

            $DOM = new \DOMDocument;
            $DOM->loadHTML($message->getHTMLBody());
            $items = $DOM->getElementsByTagName('tr');
            $docs = [];

            foreach ($items as $node) {
                $texto = ltrim(rtrim(self::tdrows($node->childNodes), " "), " ");
                $texto = preg_replace( "/\r|\n/", "", $texto);
                if($texto != " "){
                    $texto = new ValidaCPFeCNPJ($texto);
                    if($texto->valida()){
                        array_push($docs, $texto->valor);
                    }
                }
            }

            $detail = true;
            //$detail = $message->delete();
            //$detail = $message->move('INBOX.Trash');


            if ($detail == true) {
                //echo 'Message has ben moved';
            } else {
                //echo 'False';
            }
        }

    }

    public function tdrows($elements){
        $str = "";
        foreach ($elements as $element) {
          $str .= $element->nodeValue;
        }
       return $str;
      }
}
