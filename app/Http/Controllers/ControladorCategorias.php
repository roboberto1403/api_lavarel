<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;

class ControladorCategorias extends ControladorBase
{
    /**
     * @OA\Get(
     *     path="/api/categorias",
     *     summary="Listar todas as categorias",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorias retornada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma categoria encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro inesperado"
     *     )
     * )
     */
    public function listarCategorias()
    {
        try {
            $categorias = DB::table('categorias')->get();

            if ($categorias->isEmpty()) {
                return response()->json(['erro' => 'Nenhuma categoria encontrada'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['categorias' => $categorias], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro inesperado', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    /**
     * @OA\Get(
     *     path="/api/categorias/{id}",
     *     summary="Mostrar uma categoria específica por id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria retornada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao buscar categoria"
     *     )
     * )
     */
    public function mostrarCategoria($id)
    {
        try {
            $categoria = DB::table('categorias')
            ->where('id', $id)
            ->get();

            if ($categoria->isEmpty()) {
                return response()->json(['erro' => 'Categoria não encontrada'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['categorias' => $categoria], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao buscar categoria', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categorias/criar",
     *     summary="Criar uma nova categoria",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro inesperado"
     *     )
     * )
     */
    public function armazenarCategoria(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string'
            ]);

            DB::table('categorias')->insert([
                'nome' => $validatedData['nome']
            ]);

            return response()->json(['mensagem' => 'Categoria criada com sucesso!'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(
                ['erro' => 'Erro de validação', 'detalhes' => $e->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (QueryException $e) {
            return response()->json(
                ['erro' => 'Erro ao inserir no banco de dados', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro inesperado', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/categorias/deletar/{id}",
     *     summary="Deletar uma categoria",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria a ser deletada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar categoria"
     *     )
     * )
     */
    public function deletarCategoria($id)
    {
        try {
            $categoria = DB::table('categorias')->where('id', $id)->first();

            if (!$categoria) {
                return response()->json(['erro' => 'Categoria não encontrada'], Response::HTTP_NOT_FOUND);
            }

            DB::table('categorias')->where('id', $id)->delete();

            return response()->json(['mensagem' => 'Categoria deletada com sucesso'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao deletar categoria', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
