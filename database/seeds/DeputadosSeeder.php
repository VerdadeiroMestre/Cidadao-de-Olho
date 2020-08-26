<?php

ini_set('max_execution_time', 0);

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\Deputado;

class DeputadosSeeder extends Seeder
{
    /**
     * Pega os dados abertos da Assembleia Legislativa de Minas Gerais e armazena as informações importantes
     * no banco de dados
     * @return void
     */
    public function run(){
        $client = new Client();

        $response = $client->request('GET', 'http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json');
        $deputadosInfo = $response->getBody()->getContents();

        foreach(json_decode($deputadosInfo)->list as $deputadoInfo){

            $redes_Sociais = array();
            foreach($deputadoInfo->redesSociais as $redes){
                $redes_Sociais[] = $redes->redeSocial->nome;
            }

            $verbaIndenizatoria = array();
            for($i = 1 ; $i <= 12 ; $i++){
                try{
                    $response = $client->request('GET', 'http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/legislatura_atual/deputados/'.$deputadoInfo->id.'/2019'.'/'.$i.'?formato=json');
                    $verba = json_decode($response->getBody()->getContents());
                    $custo = 0;
                    foreach($verba->list as $v){
                        $custo += $v->valor;
                    }
                    $verbaIndenizatoria[$i] = $custo;
                    
                }catch(RequestException $e){
                
                }catch (ClientException $e){

                }
            }

            $deputado = new Deputado();
            $deputado->nome = $deputadoInfo->nome;
            $deputado->redes_Sociais = json_encode($redes_Sociais);
            $deputado->verba_Indenizatoria = json_encode($verbaIndenizatoria);
            
            $deputado->save();

        }
    }
}
