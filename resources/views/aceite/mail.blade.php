<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assinar documento: {{ $dados['titulo'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container-fluid {
            width: 100vw;
            height: 100vh;
            background-image: url({{ asset('images/fundo_.png') }});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
        .box {
            width: 530px;
            height: 680px;
            background: #fff;
        }
        .btn-primary {
            background-color: #e7405c;
            border-color: #e7405c;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #d12e4b;
            border-color: #d12e4b;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="box">
            <div class="row p-4 text-center">
                <div class="col-md-12">
                    <img src="{{ asset('images/logo_04.png') }}" class="img-fluid" alt="" style="max-width: 300px;">
                </div>
                <div class="col-md-12 mt-5">
                    <span>
                        {{ $dados['nome'] }}, sua assinatura foi solicitada por Positiva Consultas no d
                        ocumento {{ $dados['titulo'] }}.
                    </span>
                </div>
                <div class="col-md-12 mt-5">
                    <a href="{{ route('aceite', $dados['link']) }}" target="_blank" class="btn btn-primary btn-lg">VER DOCUMENTO</a>
                </div>
                <div class="col-md-12 mt-3">
                    Ou utilize o link: <br>
                    <a href="{{ route('aceite', $dados['link']) }}" target="_blank">{{ route('aceite', $dados['link']) }}</a>
                </div>
                <div class="col-md-12 mt-3">
                    <strong>Não compartilhe este e-mail</strong> <br>
                    Para sua segurança, não encaminhe este e-mail a ninguém.
                </div>
                <div class="col-md-12 mt-3">
                    <strong>O que é o aceite eletrônico?</strong> <br>
                    Com o Aceite Eletrônico, você pode coletar assinaturas em documentos por onde quiser (ex: WhatsApp, SMS, Telegram, e-mail etc.).
                </div>
                <div class="col-md-12 mt-3 mb-5">
                    Atenciosamente,
                    Positiva Consultas
                </div>
                <div class="col-md-12 mt-5">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
