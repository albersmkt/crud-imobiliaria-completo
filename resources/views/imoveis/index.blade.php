<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD de Imóveis com AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .form-container { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Cadastro de Imóveis</h2>

        <!-- Formulário de Cadastro/Edição -->
        <div class="form-container">
            <form id="imovelForm">
                <input type="hidden" id="imovelId">

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo do Imóvel</label>
                    <select class="form-select" id="tipo" required>
                        <option value="">Selecione</option>
                        <option value="residencial">Residencial</option>
                        <option value="comercial">Comercial</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" required>
                </div>

                <div class="mb-3">
                    <label for="metros_quadrados" class="form-label">Metros Quadrados</label>
                    <input type="number" class="form-control" id="metros_quadrados" min="1" required>
                </div>

                <div class="mb-3">
                    <label for="numero_comodos" class="form-label">Nº de Cômodos</label>
                    <input type="number" class="form-control" id="numero_comodos" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" id="btnCancel" style="display:none;">Cancelar</button>
            </form>
        </div>

        <!-- Lista de Imóveis -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Endereço</th>
                        <th>M²</th>
                        <th>Cômodos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="imoveisList">
                    <!-- Itens serão carregados aqui via JS -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
