<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Me Proteja</title>
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>
                    <h1>Relatório Me Proteja</h1>
                </th>
            </tr>
            <tr>
                <th>
                    <img src="{{ asset('images/logo_04.png') }}" alt="" style="max-width: 300px;">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Olá, {{ $arr["Relatorio"]["dadosRelato"]["empresaConsultada"]["RazaoSocial"]["_text"] }}
                    <br>
                    É melhor se prevenir do que arriscar. Por isso, avisamos que o seu {{ $meproteja->aDocumento }} teve
                    algum tipo de atualização cadastral.
                    <br>
                    Ainda bem que você tem a Serasa Experian para saber o que aconteceu. Não perca tempo e
                    acesse o seu relatório no ambiente logado para ver mais detalhes sobre essa atualização.
                    <br><br>
                    Até mais...
                </td>
            </tr>
        </tbody>
    </table>
    @if (isset($arr["Relatorio"]["dadosRelato"]["apontamentos"]["Grafias"]))
        <br><br>
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: left">Grafias</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($arr["Relatorio"]["dadosRelato"]["apontamentos"]["Grafias"] as $Grafias)
                    @if (isset($Grafias['Nome']))
                        <tr>
                            <td>
                                {{ $Grafias['Nome']['_text'] }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
    @if (isset($arr["Relatorio"]["dadosRelato"]["apontamentos"]["DividasVencidas"]))
        <br><br>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="6" style="text-align: left">Dividas Vencidas</th>
                </tr>
                <tr>
                    <th>Quantidade</th>
                    <th>Data Ocorrencia</th>
                    <th>Modalidade</th>
                    <th>Valor</th>
                    <th>Titulo Divida</th>
                    <th>Instituião Financeira</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($arr["Relatorio"]["dadosRelato"]["apontamentos"]["DividasVencidas"] as $DividasVencidas)
                    <tr>
                        <td>
                            {{ $DividasVencidas['Quantidade']['_text'] }}
                        </td>
                        <td>
                            {{ $DividasVencidas['DataOcorrencia']['_text'] }}
                        </td>
                        <td>
                            {{ $DividasVencidas['Modalidade']['_text'] }}
                        </td>
                        <td>
                            {{ $DividasVencidas['Valor']['_text'] }}
                        </td>
                        <td>
                            {{ $DividasVencidas['TituloDivida']['_text'] }}
                        </td>
                        <td>
                            {{ $DividasVencidas['InstituicaoFinanceira']['_text'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
