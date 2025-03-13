<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;

class ControladorTransacoes extends ControladorBase
{
    /**
     * @OA\Get(
     *     path="/api/transacoes",
     *     summary="Listar todas as transações",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de transações retornada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro inesperado"
     *     )
     * )
     */
    public function listarTransacoes()
    {
        try {
            $transacoes = DB::table('transacoes')->get();

            if ($transacoes->isEmpty()) {
                return response()->json(['erro' => 'Nenhuma transação encontrada'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['transacoes' => $transacoes], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro inesperado', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/transacoes/{id}",
     *     summary="Mostrar uma transação específica por id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da transação",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transação retornada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transação não encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao buscar transação"
     *     )
     * )
     */
    public function mostrarTransacao($id)
    {
        try {
            $transacao = DB::table('transacoes')
            ->where('id', $id)
            ->get();

            if ($transacao->isEmpty()) {
                return response()->json(['erro' => 'Transação não encontrada'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['transacoes' => $transacao], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao buscar transação', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/transacoes/usuario/{usuario}",
     *     summary="Listar transações por cpf de usuário",
     *     @OA\Parameter(
     *         name="usuario",
     *         in="path",
     *         required=true,
     *         description="CPF do usuário",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transações do usuário retornadas com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma transação encontrada para este usuário"
     *     )
     * )
     */
    public function listarTransacoesUsuario($usuario)
    {
        try {
            $transacoes = DB::table('transacoes')
            ->where('cpf_usuario', $usuario)
            ->get();

            if ($transacoes->isEmpty()) {
                return response()->json(['erro' => 'Nenhuma transação encontrada para este usuário'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['transacoes' => $transacoes], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao buscar transações', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/transacoes/categoria/{categoria}",
     *     summary="Listar transações por id de categoria",
     *     @OA\Parameter(
     *         name="usuario",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transações da categoria retornadas com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma transação encontrada para esta categoria"
     *     )
     * )
     */
    public function listarTransacoesCategoria($categoria)
    {
        try {
            $transacoes = DB::table('transacoes')
            ->where('id_categoria', $categoria)
            ->get();

            if ($transacoes->isEmpty()) {
                return response()->json(['erro' => 'Nenhuma transação encontrada para esta categoria'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['transacoes' => $transacoes], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao buscar transações', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/transacoes/tipo/{tipo}",
     *     summary="Listar transações tipo",
     *     @OA\Parameter(
     *         name="tipo",
     *         in="path",
     *         required=true,
     *         description="nome do tipo",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transações do tipo retornadas com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma transação encontrada para este tipo"
     *     )
     * )
     */
    public function listarTransacoesTipo($tipo)
    {
        try {
            $transacoes = DB::table('transacoes')
            ->where('tipo', $tipo)
            ->get();

            if ($transacoes->isEmpty()) {
                return response()->json(['erro' => 'Nenhuma transação encontrada para este tipo'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['transacoes' => $transacoes], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao buscar transações', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/transacoes/criar",
     *     summary="Criar uma nova transação",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_categoria", "valor", "tipo", "cpf_usuario"},
     *             @OA\Property(property="id_categoria", type="integer"),
     *             @OA\Property(property="valor", type="number"),
     *             @OA\Property(property="tipo", type="string"),
     *             @OA\Property(property="cpf_usuario", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transação criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function armazenarTransacao(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_categoria' => 'required|exists:categorias,id',
                'valor' => 'required|numeric',
                'tipo' => 'required|in:Recebeu,Pagou',
                'cpf_usuario' => 'required|exists:usuarios,cpf'
            ]);

            DB::table('transacoes')->insert([
                'id_categoria' => $validatedData['id_categoria'],
                'valor' => $validatedData['valor'],
                'tipo' => $validatedData['tipo'],
                'cpf_usuario' => $validatedData['cpf_usuario'],
                'data' => now()
            ]);

            return response()->json(['mensagem' => 'Transação criada com sucesso!'], Response::HTTP_CREATED);
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
     *     path="/api/transacoes/deletar/{id}",
     *     summary="Deletar uma transação",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da transação a ser deletada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transação deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transação não encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar transação"
     *     )
     * )
     */
    public function deletarTransacao($id)
    {
        try {
            $transacao = DB::table('transacoes')->where('id', $id)->first();

            if (!$transacao) {
                return response()->json(['erro' => 'Transação não encontrada'], Response::HTTP_NOT_FOUND);
            }

            DB::table('transacoes')->where('id', $id)->delete();

            return response()->json(['mensagem' => 'Transação deletada com sucesso'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao deletar transação', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}