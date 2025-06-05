<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class MunicipioIbgeController extends Controller
{
    public function getMunicipiosRJ()
    {
        try {
            $municipios = Cache::remember('municipios-rj', now()->addHours(24), function () {
                $response = Http::retry(3, 100)->get(
                    'https://servicodados.ibge.gov.br/api/v1/localidades/estados/33/municipios'
                );

                if ($response->failed()) {
                    throw new \Exception("Falha ao acessar API do IBGE", 502);
                }

                return $this->formatMunicipios($response->json());
            });

            return response()->json([
               'success' => true,
                'estado' => 'Rio de Janeiro', 
                'count' => count($municipios),
                'data' => $municipios
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    private function formatMunicipios(array $municipios): array
    {
        return array_map(function ($municipio) {
            return [
                'id' => $municipio['id'],
                'municipio' => $municipio['nome'],  // Alterado de 'nome' para 'municipio'
                'estado' => 'Rio de Janeiro',       // Adicionado aqui
                'microrregiao' => $municipio['microrregiao']['nome'],
                'mesorregiao' => $municipio['microrregiao']['mesorregiao']['nome'],
                'regiao' => $municipio['microrregiao']['mesorregiao']['UF']['regiao']['nome']
            ];
        }, $municipios);
    }
}