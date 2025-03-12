<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;

class ControladorUsuarios extends ControladorBase
{
    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     summary="Listar todos os usuários",
     *     @OA\Response(
     *         response=404,
     *         description="Nenhum usuário encontrado"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários retornada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro inesperado"
     *     )
     * )
     */
    public function listarUsuarios()
    {
        try {
            $usuarios = DB::table('usuarios')->get();

            if ($usuarios->isEmpty()) {
                return response()->json(['erro' => 'Nenhum usuário encontrado'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['usuarios' => $usuarios], Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro inesperado', 'detalhes' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @OA\Post(
     *     path="/api/usuarios/criar",
     *     summary="Criar um novo usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf", "nome", "email", "senha"},
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="senha", type="string")
     *         )
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Usuário já existe"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário cadastrado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *       @OA\Response(
     *         response=500,
     *         description="Erro inesperado"
     *     )
     * )
     */
    public function armazenarUsuario(Request $request)
    {
        try {
            // Validação dos dados recebidos
            $validatedData = $request->validate([
                'cpf' => 'required|string',
                'nome' => 'required|string',
                'email' => 'required|string|email',
                'senha' => 'required|string'
            ]);

            $usuarioExistente = DB::table('usuarios')->where('cpf', $validatedData['cpf'])->first();

            if ($usuarioExistente) {
                return response()->json(['erro' => 'Usuário já existe'], 
                Response::HTTP_BAD_REQUEST);
            }

            // Inserção no banco de dados
            DB::table('usuarios')->insert([
                'cpf' => $validatedData['cpf'],
                'nome' => $validatedData['nome'],
                'email' => $validatedData['email'],
                'senha' => bcrypt($validatedData['senha']),
                'data_cadastro' => now()
            ]);

            return response()->json(['mensagem' => 'Usuário cadastrado com sucesso'], 
            Response::HTTP_CREATED);

        } catch (ValidationException $e) {
            return response()->json(['erro' => 'Erro de validação', 'detalhes' => $e->errors()], 
            Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (QueryException $e) {
            return response()->json(['erro' => 'Erro ao inserir no banco de dados', 'detalhes' => $e->getMessage()], 
            Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $e) {
            return response()->json(['erro' => 'Erro inesperado', 'detalhes' => $e->getMessage()], 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/usuarios/deletar/{id}",
     *     summary="Deletar um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="CPF do usuário a ser deletado",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar usuário"
     *     )
     * )
     */
    public function deletarUsuario($id)
    {
        try {
            $usuario = DB::table('usuarios')->where('cpf', $id)->first();

            if (!$usuario) {
                return response()->json(['erro' => 'Usuário não encontrado'], 
                Response::HTTP_NOT_FOUND);
            }

            DB::table('usuarios')->where('cpf', $id)->delete();

            return response()->json(['mensagem' => 'Usuário deletado com sucesso'], 
            Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(
                ['erro' => 'Erro ao deletar usuário', 'detalhes' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Put(
     *     path="/api/usuarios/atualizar/{id}",
     *     summary="Atualizar dados de um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="CPF do usuário a ser atualizado",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
     *             @OA\Property(property="senha", type="string", description="Senha do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar usuário"
     *     )
     * )
     */
    public function atualizarUsuario(Request $request, $id)
    {
        try {
            $usuario = DB::table('usuarios')->where('cpf', $id)->first();

            if (!$usuario) {
                return response()->json(['erro' => 'Usuário não encontrado'], Response::HTTP_NOT_FOUND);
            }

            $validatedData = $request->validate([
                'nome' => 'sometimes|string',
                'email' => 'sometimes|string|email',
                'senha' => 'sometimes|string'
            ]);

            DB::table('usuarios')->where('cpf', $id)->update($validatedData);

            return response()->json(['mensagem' => 'Usuário atualizado com sucesso'], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'erro' => 'Erro ao atualizar usuário',
                'detalhes' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            return response()->json([
                'erro' => 'Erro inesperado',
                'detalhes' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
