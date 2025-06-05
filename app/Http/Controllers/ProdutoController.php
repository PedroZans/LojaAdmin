<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\controllers\Requests\StoreProdutoRequest;
use App\Http\controllers\Requests\UpdateProdutoRequest;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
    public function index()
    {
      return Produto::paginate(10);
        

         return response()->json([
        'success' => true,
        'data' => $produtos->items(),
        'meta' => [
            'total' => $produtos->total(),
            'current_page' => $produtos->currentPage()
        ]
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    /* 1. Validação dos dados
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:produtos,name,NULL,id,category,'.$request->category,
        'category' => 'required|string|max:100',
        'status' => 'required|in:ACTIVE,INACTIVE',
        'quantity' => 'required|integer|min:0'
        // Adicione outros campos conforme necessário
    ]);

    // 2. Criação do produto
    $produto = Produto::create($validated); // Usando a variável validada

    // 3. Retorno da resposta
    return response()->json([
        'success' => true,
        'data' => $produto
    ], 201);*/
}
    /**
     * Store a newly created resource in storage.
     */
   // Cadastrar// Adicione validação única no controller
    public function store(Request $request)
     {
                $validated = $request->validate([
                'name' => 'required|string|max:255|unique:produtos,name,NULL,id,category,'.$request->category,
                'category' => 'required|string|max:100',
                'status' => 'required|in:ACTIVE,INACTIVE',
                'quantity' => 'required|integer|min:0'
        ]);
                    try {
                    $produto = Produto::create($validated);
                    return response()->json([
                                    'success' => true,
                                    'data' => $produto
                                ], 201);

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Erro ao criar produto',
                        'error' => $e->getMessage()
                    ], 500);
                }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return $produto;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateProdutoRequest $request, Produto $produto)
{ // faz o update do produto
    \Log::info('Request validado:', $request->validated());
    \Log::info('Produto antes do update:', $produto->toArray());

    $produto->update($request->validated());

    \Log::info('Produto depois do update:', $produto->fresh()->toArray());

    return response()->json($produto->fresh(), 200);
}



    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();


        return response()->json(['message' => 'Produto deletado com sucesso.']);
    }
}
