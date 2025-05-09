<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Transação</title>
</head>
<body>
    <h1>Criar Nova Transação</h1>

    <!-- A ação do formulário é para a rota POST (transacoes.store) -->
    <form action="{{ route('transacoes.store') }}" method="POST">

        <label for="cpf_usuario">CPF do Usuário:</label>
        <input type="text" name="cpf_usuario" required>

        <label for="tipo">Tipo:</label>
        <select name="tipo" required>
            <option value="Recebeu">Recebeu</option>
            <option value="Pagou">Pagou</option>
        </select>

        <label for="valor">Valor:</label>
        <input type="number" name="valor" step="0.01" required>

        <label for="id_categoria">Categoria:</label>
        <select name="id_categoria" required>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
            @endforeach
        </select>

        <button type="submit">Criar Transação</button>
            @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
            @endif
    </form>
</body>
</html>



