<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeAviseController extends Controller
{
    public function teste()
    {
        $texto = '<Relatorio cliente="099999999" distribuidor="011908631">
            <dadosRelato>
            <empresaConsultada>
            <CNPJ>00001086</CNPJ>
            <DescricaoSituacaoDocumento>SITUACAO DO CNPJ EM 26/03/2016: ATIVA</DescricaoSituacaoDocumento>
            <SituacaoDocumento>2</SituacaoDocumento>
            <RazaoSocial>NOME DA EMPRESA</RazaoSocial>
            <NomeFantasia>NOME DA EMPRESA</NomeFantasia>
            <DescricaoTipoSociedade>EMPRESA INDIVIDUAL RESPONS LIMITADA EMPRESARIA</DescricaoTipoSociedade>
            </empresaConsultada>
            <apontamentos>
            <PendenciasFinanceiras>
            <Refins>
                <Quantidade>6</Quantidade>
                <Refin>
                <DataOcorrencia>2016-04-10</DataOcorrencia>
                <DescricaoNatureza>OUTRAS OPER</DescricaoNatureza>
                <Avalista>false</Avalista>
                <Valor>55659</Valor>
                <Contrato>UG03033000000139</Contrato>
                <Origem>SANTANDER</Origem>
                <Filial>PLA</Filial>
                </Refin>
                <Refin>
                <DataOcorrencia>2016-04-07</DataOcorrencia>
                <DescricaoNatureza>OUTRAS OPER</DescricaoNatureza>
                <Avalista>false</Avalista>
                <Valor>349</Valor>
                <Contrato>YD03030050500598</Contrato>
                <Origem>SANTANDER</Origem>
                <Filial>PLA</Filial>
                </Refin>
                <Refin>
                <DataOcorrencia>2016-03-28</DataOcorrencia>
                <DescricaoNatureza>OUTRAS OPER</DescricaoNatureza>
                <Avalista>false</Avalista>
                <Valor>478</Valor>
                <Contrato>YD03030050535074</Contrato>
                <Origem>SANTANDER</Origem>
                <Filial>PLA</Filial>
                </Refin>
                <Refin>
                <DataOcorrencia>2016-03-21</DataOcorrencia>
                <DescricaoNatureza>FINANCIAMENT</DescricaoNatureza>
                <Avalista>false</Avalista>
                <Valor>70395</Valor>
                <Contrato>000001078938618</Contrato>
                <Origem>ITAU</Origem>
                <Filial>SPO</Filial>
                </Refin>
                <Refin>
                <DataOcorrencia>2016-03-21</DataOcorrencia>
                <DescricaoNatureza>OUTRAS OPER</DescricaoNatureza>
                <Avalista>false</Avalista>
                <Valor>59151</Valor>
                <Contrato>UG03033000000137</Contrato>
                <Origem>SANTANDER</Origem>
                <Filial>PLA</Filial>
                </Refin>
                <Refin>
                <DataOcorrencia>2016-03-10</DataOcorrencia>
                <DescricaoNatureza>OUTRAS OPER</DescricaoNatureza>
                <Avalista>false</Avalista>
                <Valor>4752</Valor>
                <Contrato>YD03030050548566</Contrato>
                <Origem>SANTANDER</Origem>
                <Filial>PLA</Filial>
                </Refin>
            </Refins>
            </PendenciasFinanceiras>
            <Grafias>
            <Grafia>
                <Nome>NOME DA EMPRESA</Nome>
            </Grafia>
            <Grafia>
                <Nome>NOME DA EMPRESA</Nome>
            </Grafia>
            </Grafias>
            <ChequesExtraviadoSustadoRecheque>
            <TotalUltimasOcorrencias/>
            <Mensagem>
                <Mensagem>=== NADA CONSTA PARA O CNPJ CONSULTADO ===</Mensagem>
            </Mensagem>
            </ChequesExtraviadoSustadoRecheque>
            </apontamentos>
            <concentres>
            <Concentre>
            <Quantidade>4</Quantidade>
            <Discriminacao>CHEQUE</Discriminacao>
            <DataInicial>2016-04</DataInicial>
            <DataFinal>2016-05</DataFinal>
            <Valor>0</Valor>
            <Origem>ITAU</Origem>
            <Praca>7992</Praca>
            </Concentre>
            </concentres>
            <AvisosAlteracoes>
            <DataAlteracao>2016-06-11</DataAlteracao>
            <StatusAlteracao>NovaAlteracao</StatusAlteracao>
            <InformacoesReceita>
            <SituacaoReceita>
                <Depois>ATIVO</Depois>
            </SituacaoReceita>
            </InformacoesReceita>
            <InformacoesConcentre>
            <PosicaoAtual>
                <Quantidades>
                <inclusoesProtesto>0</inclusoesProtesto>
                <exclusoesProtesto>0</exclusoesProtesto>
                <inclusoesAcaojudicial>0</inclusoesAcaojudicial>
                <exclusoesAcaojudicial>0</exclusoesAcaojudicial>
                <inclusoesFalenciaConcordata>0</inclusoesFalenciaConcordata>
                <exclusoesFalenciaConcordata>0</exclusoesFalenciaConcordata>
                <inclusoesPefin>0</inclusoesPefin>
                <exclusoesPefin>0</exclusoesPefin>
                <inclusoesRefin>1</inclusoesRefin>
                <exclusoesRefin>0</exclusoesRefin>
                <inclusoesChequeSemFundoAchei>0</inclusoesChequeSemFundoAchei>
                <exclusoesChequeSemFundoAchei>0</exclusoesChequeSemFundoAchei>
                <inclusoesDividaVencida>0</inclusoesDividaVencida>
                <exclusoesDividaVencida>0</exclusoesDividaVencida>
                </Quantidades>
            </PosicaoAtual>
            <PosicaoAnterior>
                <Quantidades>
                <inclusoesProtesto>0</inclusoesProtesto>
                <exclusoesProtesto>0</exclusoesProtesto>
                <inclusoesAcaojudicial>0</inclusoesAcaojudicial>
                <exclusoesAcaojudicial>0</exclusoesAcaojudicial>
                <inclusoesFalenciaConcordata>0</inclusoesFalenciaConcordata>
                <exclusoesFalenciaConcordata>0</exclusoesFalenciaConcordata>
                <inclusoesPefin>0</inclusoesPefin>
                <exclusoesPefin>0</exclusoesPefin>
                <inclusoesRefin>1</inclusoesRefin>
                <exclusoesRefin>0</exclusoesRefin>
                <inclusoesChequeSemFundoAchei>0</inclusoesChequeSemFundoAchei>
                <exclusoesChequeSemFundoAchei>0</exclusoesChequeSemFundoAchei>
                <inclusoesDividaVencida>0</inclusoesDividaVencida>
                <exclusoesDividaVencida>0</exclusoesDividaVencida>
                </Quantidades>
            </PosicaoAnterior>
            </InformacoesConcentre>
            </AvisosAlteracoes>
            <CartasComunicados>
            <CartasComunicado>
            <TipoInclusao>C</TipoInclusao>
            <Documento>099999999</Documento>
            <NumeroComunicado>0515172090</NumeroComunicado>
            <TipoOcorrencia>2</TipoOcorrencia>
            <DataOcorrencia>2016-06-10</DataOcorrencia>
            <DataEnvio>2016-06-14</DataEnvio>
            <DataLimite>4000-12-31</DataLimite>
            <DataBaixa>00000000</DataBaixa>
            <Status>A</Status>
            <InstituicaoCredora>BANCO SANTANDER BRASIL S/A</InstituicaoCredora>
            </CartasComunicado>
            </CartasComunicados>
            </dadosRelato>
        </Relatorio>
        ';

        $xml = simplexml_load_string($texto);

        $array = json_encode($xml);
        $array = json_decode($array, true);

        return '<pre>'. print_r($array, true) .'</pre>';

    }
}
