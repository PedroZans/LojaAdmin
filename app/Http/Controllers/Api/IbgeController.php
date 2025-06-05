<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MunicipioIbge;
use Illuminate\Support\Facades\Http;


class IbgeController extends Controller
{
    public function importarMunicipios()
    {
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados/33/municipios');
        
        if (!$response->successful()) {
            return response()->json(['erro' => 'Erro ao acessar a API do IBGE'], 500);
        }

        $municipios = $response->json();
        $count = 0;

      foreach ($municipios as $municipio) {
    // Verifica se as chaves existem
    if (!isset($municipio['id']) || !isset($municipio['nome'])) {
        logger('Município inválido', $municipio);
        continue;
    }
    
    MunicipioIbge::updateOrCreate(
        ['ibge_id' => $municipio['id']],
        ['ibge_name' => $municipio['nome']]
    );
    $count++;
}

        return response()->json([
            'mensagem' => "$count municípios importados com sucesso",
            'total' => MunicipioIbge::count()
        ]);
    }
}