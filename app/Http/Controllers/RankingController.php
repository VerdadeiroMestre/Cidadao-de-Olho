<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deputado;

class RankingController extends Controller
{
    /** Identifica quais redes sociais são ultilizadas por cada deputado e coloca em ordem crescente as redes
     * mais ultilizadas
     * @param Array - Array com as informações de cada deputado
     * @return Array - Ranking das redes sociais mais ultilizadas
     */
    private function rankingRedeSocial($deputados){
        $redes = array();
        foreach($deputados as $deputado){
            foreach(json_decode($deputado->redes_Sociais) as $redeSocial){
                if(array_key_exists($redeSocial, $redes)){
                    $redes[$redeSocial]++;
                }else{
                    $redes[$redeSocial] = 1;
                }
            } 
        }
        arsort($redes);
        return $redes;
    }

    /** Gera um array de arrays com os gastos com verbas indenizatórias de cada deputada em cada mês de 2019,
     * ordena o array pela quantia gasta e separa os 5 que mais gastaram
     * @param Array - Array com as informações de cada deputado
     * @return Array - Ranking de gastos com verbas indenizatórias por mês
     */
    private function rankingVerbaIndenizatoria($deputados){
        $meses = array();

        for($i = 1 ; $i <= 12 ; $i++){
            $meses[$i] = array();
            foreach($deputados as $deputado){
                $gastos = json_decode($deputado->verba_Indenizatoria, true);
                $j = 1;
                foreach($gastos as $gasto){
                    if($i === $j){
                        $meses[$i][$deputado->nome] = $gasto ;
                    }
                    $j++;
                }
            }
            arsort($meses[$i]);
        }

        for($i = 1 ; $i <= 12 ; $i++){
            array_splice($meses[$i],5);
        }

        return $meses;
        
    }

    /** Pega os dados dos deputados no banco de dados e os envia para as funções que os usarão e gera um json
     * com os dados recebidos das funções 
     * @return json - json com os rankings das redes sociais mais ultilizadas e dos deputados que mais 
     * gastaram com verbas indenizatórias 
     */
    function index(){
        $deputados = Deputado::all();

        $rankings = array($this->rankingRedeSocial($deputados), $this->rankingVerbaIndenizatoria($deputados));
        return response()->json($rankings);
    }
}
