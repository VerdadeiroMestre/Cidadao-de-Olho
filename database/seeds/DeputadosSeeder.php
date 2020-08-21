<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

class DeputadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $client = new Client();

        /**
         * Pega os dados da base aberta e os insere no banco de dados.
         */

        $response = $client->request('GET', 'http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        foreach(json_decode($body)->list as $deputado){
            DB::table('deputados')->insert(['deputado' => json_encode($deputado)]);
        }
    }
}
