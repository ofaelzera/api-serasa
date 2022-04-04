<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
{!! $texto_contrato !!}

@isset($tabPreco)

<table style="width: 100%">
    <tr>
        <th style="text-align: center;">
            <img src="{{ asset('images/logo_04.png') }}" alt="" style="max-width: 250px">
        </th>
    </tr>
</table>
<br><br><br>
<table style="width: 100%">
    <tr>
        <th colspan="2" style="background-color: purple; color: white;">
            CONSULTAS CPF (CNPJ consultando CPF)
        </th>
    </tr>
    @foreach($tabPreco['produto'] as $key => $item)
        @isset($aArrayProdutos['PF'][$key])
            <tr>
                <td>{{ $aArrayProdutos['PF'][$key] }}</td>
                <td>{{ $item }}</td>
            </tr>
        @endisset
    @endforeach
</table>
<br><br>
<table style="width: 100%">
    <tr>
        <th colspan="2" style="background-color: purple; color: white;">
            CONSULTAS CNPJ (CNPJ consultando CNPJ)
        </th>
    </tr>
    @foreach($tabPreco['produto'] as $key => $item)
        @isset($aArrayProdutos['PJ'][$key])
            <tr>
                <td>{{ $aArrayProdutos['PJ'][$key] }}</td>
                <td>{{ $item }}</td>
            </tr>
        @endisset
    @endforeach
</table>
<br><br><br>
<table style="width: 100%">
    <tr>
        <th colspan="2" style="background-color: purple; color: white;">
            Descrição do Produto
        </th>
    </tr>
    @foreach($tabPreco['feature'] as $key => $item)
        <tr>
            <td>{{ $aArrayFeatures[$key] }}</td>
            <td>{{ $item }}</td>
        </tr>
    @endforeach
</table>
@endisset
