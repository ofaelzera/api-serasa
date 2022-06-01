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
                    @if(isset($array["empresa_consultada"]["razao_social"]))
                        Olá, {{ $array["empresa_consultada"]["razao_social"] }} <br><br>
                    @endif
                    @if(isset($array["pessoa_consultada"]["nome"]))
                        Olá, {{ $array["pessoa_consultada"]["nome"] }} <br><br>
                    @endif
                    É melhor se prevenir do que arriscar. Por isso, avisamos que o seu documento teve algum tipo de atualização cadastral. <br>
                    Ainda bem que você tem a Serasa Experian para saber o que aconteceu. Não perca tempo e confira abaixo o que mudou.
                    <br><br>
                    Até mais...
                </td>
            </tr>
        </tbody>
    </table>

    @if(isset($array["CartasComunicados"]))
    <br><br>
    <table class="table">
        <th>
            <th colspan="10">
                Cartas Comunicados
            </th>
        </th>
        <tr>
            <th>Tipo inclusao</th>
            <th>Documento</th>
            <th>Numero comunicado</th>
            <th>Tipo ocorrencia</th>
            <th>Data ocorrencia</th>
            <th>Data envio</th>
            <th>Data limite</th>
            <th>Data baixa</th>
            <th>Status</th>
            <th>Instituição credora</th>
        </tr>
        @foreach($array["CartasComunicados"] as $carta)
        <tr>
            <td>{{ $carta['tipo_inlclusao'] }}</td>
            <td>{{ $carta['documento'] }}</td>
            <td>{{ $carta['numero_comunicacao'] }}</td>
            <td>{{ $carta['tipo_ocorrencia'] }}</td>
            <td>{{ $carta['data_ocorrencia'] }}</td>
            <td>{{ $carta['data_envio'] }}</td>
            <td>{{ $carta['data_limite'] }}</td>
            <td>{{ $carta['data_baixa'] }}</td>
            <td>{{ $carta['status'] }}</td>
            <td>{{ $carta['instituicao_credora'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if(isset($array["Concentre"]))
    <br><br>
    <table class="table">
        <th>
            <th colspan="7">
                Concentre
            </th>
        </th>
        <tr>
            <th>Quantidade</th>
            <th>Discriminação</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Valor</th>
            <th>Origem</th>
            <th>Praca</th>
        </tr>
        @foreach($array["Concentre"] as $concentre)
        <tr>
            <td>{{ $concentre['quantidade'] }}</td>
            <td>{{ $concentre['discriminacao'] }}</td>
            <td>{{ $concentre['data_inicial'] }}</td>
            <td>{{ $concentre['data_final'] }}</td>
            <td>{{ $concentre['moeda'] }} {{ $concentre['valor']. ',00' }} }}</td>
            <td>{{ $concentre['origem'] }}</td>
            <td>{{ $concentre['praca'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if(isset($array["apontamentos"]["pefins"]))
    <br><br>
    <table class="table">
        <th>
            <th colspan="6">
                Pefin
            </th>
        </th>
        <tr>
            <th>Data ocorrencia</th>
            <th>Descrição natureza</th>
            <th>Avalista</th>
            <th>Valor</th>
            <th>Contrato</th>
            <th>Origem</th>
        </tr>
        @foreach($array["apontamentos"]["pefins"]["pefin"] as $pefin)
        <tr>
            <td>{{ $pefin['data_ocorrencia'] }}</td>
            <td>{{ $pefin['descricao_natureza'] }}</td>
            <td>{{ $pefin['avalista'] }}</td>
            <td>{{ 'R$ ' . $pefin['valor']. ',00' }}</td>
            <td>{{ $pefin['contrato'] }}</td>
            <td>{{ $pefin['origem'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if(isset($array["apontamentos"]["refins"]))
    <br><br>
    <table class="table">
        <th>
            <th colspan="6">
                Refin
            </th>
        </th>
        <tr>
            <th>Data ocorrencia</th>
            <th>Descrição natureza</th>
            <th>Avalista</th>
            <th>Valor</th>
            <th>Contrato</th>
            <th>Origem</th>
        </tr>
        @foreach($array["apontamentos"]["refins"]["refin"] as $refin)
        <tr>
            <td>{{ $refin['data_ocorrencia'] }}</td>
            <td>{{ $refin['descricao_natureza'] }}</td>
            <td>{{ $refin['avalista'] }}</td>
            <td>{{ 'R$ ' . $refin['valor']. ',00' }}</td>
            <td>{{ $refin['contrato'] }}</td>
            <td>{{ $refin['origem'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if(isset($array["apontamentos"]["protestos"]))
    <br><br>
    <table class="table">
        <th>
            <th colspan="5">
                Protestos
            </th>
        </th>
        <tr>
            <th>Data ocorrencia</th>
            <th>Valor</th>
            <th>Cartorio</th>
            <th>Cidade</th>
            <th>UF</th>
        </tr>
        @foreach($array["apontamentos"]["protestos"]["protesto"] as $protesto)
        <tr>
            <td>{{ $protesto['data_ocorrencia'] }}</td>
            <td>{{ 'R$ ' . $refin['valor']. ',00' }}</td>
            <td>{{ $protesto['cartorio'] }}</td>
            <td>{{ $protesto['cidade_ocorrencia'] }}</td>
            <td>{{ $protesto['uf_ocorrencia'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if(isset($array["apontamentos"]["ChequesSemFundoAchei"]))
    <br><br>
    <table class="table">
        <th>
            <th colspan="9">
                Cheques Sem Fundo Achei
            </th>
        </th>
        <tr>
            <th>Quantidade</th>
            <th>Data ocorrencia</th>
            <th>Numero</th>
            <th>Alinea</th>
            <th>Valor</th>
            <th>Banco</th>
            <th>Agencia</th>
            <th>Cidade</th>
            <th>UF</th>
        </tr>
        <tr>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["quantidade"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["data_ocorrencia"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["numero"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["alinea"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["valor"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["banco"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["agencia"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["cidade"] }}</td>
            <td>{{ $array["apontamentos"]["ChequesSemFundoAchei"]["uf"] }}</td>
        </tr>
    </table>
    @endif
</body>
</html>
