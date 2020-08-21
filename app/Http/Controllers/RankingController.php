<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deputado;

class RankingController extends Controller
{
    /*
     * Pega os dados de cada deputado do banco de dados e calcula o quanto cada rede social é usada pelos deputados.
     */
    private function rankingRedeSocial(){
        $deputados = Deputado::all();
        /*
         * Como existem varias redes sociais e não sei quais cada deputado usa, as redes são salvas a partir do momento
         * em que um dos deputados a use. 
         */
        $redes = array();
        foreach($deputados as $deputado){
            foreach(json_decode($deputado->deputado)->redesSociais as $redeSocial){
                if(array_key_exists($redeSocial->redeSocial->nome, $redes)){
                    $redes[$redeSocial->redeSocial->nome]++;
                }else{
                    $redes[$redeSocial->redeSocial->nome] = 1;
                }
            } 
        }
        /*
         * ordena o array com as redes sociais da mais utilizada pra menos.
         */
        arsort($redes);
        return $redes;
    }

    function index(){
        return response()->json($this->rankingRedeSocial());
    }
}
