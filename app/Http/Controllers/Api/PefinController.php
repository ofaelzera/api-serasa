<?php

namespace App\Http\Controllers\Api;

use App\Models\Serasa\Pefin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PefinController extends Controller
{
    public function setPefin(Request $request)
    {
        try {
            $request->validate([
                'tipo_pessoa'           => 'required', // CHAR DE 1 - F = FISICA, J = JURIDICA
                'cnpj'                  => 'required', // VACHAR DE 14 - CNPJ 00.000.000/0000-00 ou CPF 000.000.000-00
                'razao'                 => 'required', // VACHAR DE 100 - RAZAO SOCIAL OU NOME
                'cep'                   => 'required', // VACHAR DE 8 - CEP 00000-000
                'endereco'              => 'required', // VACHAR DE 100 - ENDERECO
                'numero'                => 'required', // VACHAR DE 10 - NUMERO
                'complemento'           => 'required', // VACHAR DE 100 - COMPLEMENTO
                'bairro'                => 'required', // VACHAR DE 100 - BAIRRO
                'cidade'                => 'required', // VACHAR DE 100 - CIDADE
                'estado'                => 'required', // CHAR DE 2 - ESTADO
                'ddd'                   => 'required', // VACHAR DE 2 - DDD
                'telefone'              => 'required', // VACHAR DE 9 - TELEFONE
                'data_vencimento'       => 'required', // DATA DE VENCIMENTO
                'data_final_contrato'   => 'required', // DATA FINAL DO CONTRATO
                'valor'                 => 'required', // DECIMAL DE 10,2 - VALOR DO CONTRATO
                'numero_contrato'       => 'required', // VACHAR DE 20 - NUMERO DO CONTRATO
                'codigo_natureza'       => 'required', // CHAR DE 2 - CODIGO DA NATUREZA
            ]);

            $pefin = $request->all();

            $model = new Pefin();
            $model->nIdContrato             = Auth('api')->user()->id_contrato;
            $model->dData                   = date("Y-m-d");
            $model->aOperacao               = 'I';
            $model->dDataOcorrencia         = $pefin['data_vencimento'];
            $model->dDataFinalContrato      = $pefin['data_final_contrato'];
            $model->aNatureza               = $pefin['codigo_natureza'];
            $model->aPrincTipoPessoa        = $pefin['tipo_pessoa'];
            $model->aPrincTipoDocumento     = ($pefin['tipo_pessoa'] == 'F') ? 2 : 1;
            $model->aPrincCpfCnpj           = $pefin['cnpj'];
            $model->aNomeDevedor            = $pefin['razao'];
            $model->aEndereco               = $pefin['endereco'];
            $model->aNumero                 = $pefin['numero'];
            $model->aComplemento            = $pefin['complemento'];
            $model->aBairro                 = $pefin['bairro'];
            $model->aMunicipio              = $pefin['cidade'];
            $model->aCEP                    = $pefin['cep'];
            $model->aEstado                 = $pefin['estado'];
            $model->aDDD                    = $pefin['ddd'];
            $model->aTelefone               = $pefin['telefone'];
            $model->dValorDivida            = $pefin['valor'];
            $model->aNumeroContrato         = $pefin['numero_contrato'];

            $model->aNomePai                = isset($pefin['nome_pai']) ?? $pefin['nome_pai'] = '';
            $model->aNomeMae                = isset($pefin['nome_mae']) ?? $pefin['nome_mae'] = '';
            $model->aSecundTipoDocumento    = isset($pefin['secund_tipo_documento']) ?? $pefin['secund_tipo_documento'] = '';
            $model->aSecundRG               = isset($pefin['secund_rg']) ?? $pefin['secund_rg'] = '';
            $model->aSecundUfRG             = isset($pefin['secund_uf_rg']) ?? $pefin['secund_uf_rg'] = '';

            $model->aCoobrTipoPessoa        = isset($pefin['coobr_tipo_pessoa']) ?? $pefin['coobr_tipo_pessoa'] = '';
            $model->aCoobrTipoDocumento     = isset($pefin['coobr_tipo_documento']) ?? $pefin['coobr_tipo_documento'] = '';
            $model->aCoobrCpfCnpj           = isset($pefin['coobr_cpf_cnpj']) ?? $pefin['coobr_cpf_cnpj'] = '';
            $model->aCoobSecTipoDocumento   = isset($pefin['coobr_secund_tipo_documento']) ?? $pefin['coobr_secund_tipo_documento'] = '';
            $model->aCoobSecRG              = isset($pefin['coobr_secund_rg']) ?? $pefin['coobr_secund_rg'] = '';
            $model->aCoobSecUfRG            = isset($pefin['coobr_secund_uf_rg']) ?? $pefin['coobr_secund_uf_rg'] = '';

            $model->aNossoNumero            = isset($pefin['nosso_numero']) ?? $pefin['nosso_numero'] = '';
            $model->aTipoComunicDevedor     = isset($pefin['tipo_comunic_devedor']) ?? $pefin['tipo_comunic_devedor'] = '';

            $model->nBanco                  = isset($pefin['banco']) ?? $pefin['banco'] = '';
            $model->nCheque                 = isset($pefin['cheque']) ?? $pefin['cheque'] = '';
            $model->nAlinea                 = isset($pefin['alinea']) ?? $pefin['alinea'] = '';
            $model->nAgencia                = isset($pefin['agencia']) ?? $pefin['agencia'] = '';
            $model->nConta                  = isset($pefin['conta']) ?? $pefin['conta'] = '';

            return response()->json($model);

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 400);
        }
    }
}
