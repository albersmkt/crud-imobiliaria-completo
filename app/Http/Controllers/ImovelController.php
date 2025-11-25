<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelController extends Controller
{
    // Exibe a página principal com a lista de imóveis
    public function index()
    {
        $imoveis = Imovel::all();
        return view('imoveis.index', compact('imoveis'));
    }

    // Salva um novo imóvel (via AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:residencial,comercial',
            'endereco' => 'required|string|max:255',
            'metros_quadrados' => 'required|integer|min:1',
            'numero_comodos' => 'required|integer|min:1',
        ]);

        $imovel = Imovel::create($request->all());

        return response()->json($imovel);
    }

    // Retorna um imóvel para edição (via AJAX)
    public function edit($id)
    {
        $imovel = Imovel::findOrFail($id);
        return response()->json($imovel);
    }

    // Atualiza um imóvel (via AJAX)
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:residencial,comercial',
            'endereco' => 'required|string|max:255',
            'metros_quadrados' => 'required|integer|min:1',
            'numero_comodos' => 'required|integer|min:1',
        ]);

        $imovel = Imovel::findOrFail($id);
        $imovel->update($request->all());

        return response()->json($imovel);
    }

    // Deleta um imóvel (via AJAX)
    public function destroy($id)
    {
        $imovel = Imovel::findOrFail($id);
        $imovel->delete();

        return response()->json(['success' => true]);
    }
}
