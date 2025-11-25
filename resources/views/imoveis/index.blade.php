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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Carregar imóveis ao iniciar
        fetchImoveis();

        // Função para buscar e exibir imóveis
        function fetchImoveis() {
            $.get('/imoveis', function(data) {
                let rows = '';
                data.forEach(imovel => {
                    rows += `
                        <tr>
                            <td>${imovel.id}</td>
                            <td>${imovel.tipo.charAt(0).toUpperCase() + imovel.tipo.slice(1)}</td>
                            <td>${imovel.endereco}</td>
                            <td>${imovel.metros_quadrados}</td>
                            <td>${imovel.numero_comodos}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${imovel.id}">Editar</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${imovel.id}">Excluir</button>
                            </td>
                        </tr>
                    `;
                });
                $('#imoveisList').html(rows);
            });
        }

        // Salvar ou Atualizar
        $('#imovelForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#imovelId').val();
            const imovelData = {
                tipo: $('#tipo').val(),
                endereco: $('#endereco').val(),
                metros_quadrados: $('#metros_quadrados').val(),
                numero_comodos: $('#numero_comodos').val()
            };

            if (id) {
                // Atualizar
                $.ajax({
                    url: `/imoveis/${id}`,
                    type: 'PUT',
                    data: imovelData,
                    success: function(response) {
                        alert('Imóvel atualizado com sucesso!');
                        resetForm();
                        fetchImoveis();
                    },
                    error: function() {
                        alert('Erro ao atualizar o imóvel.');
                    }
                });
            } else {
                // Criar novo
                $.post('/imoveis', imovelData, function(response) {
                    alert('Imóvel cadastrado com sucesso!');
                    resetForm();
                    fetchImoveis();
                }).fail(function() {
                    alert('Erro ao cadastrar o imóvel.');
                });
            }
        });

        // Editar
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            $.get(`/imoveis/${id}/edit`, function(imovel) {
                $('#imovelId').val(imovel.id);
                $('#tipo').val(imovel.tipo);
                $('#endereco').val(imovel.endereco);
                $('#metros_quadrados').val(imovel.metros_quadrados);
                $('#numero_comodos').val(imovel.numero_comodos);
                $('#btnCancel').show();
            });
        });

        // Cancelar edição
        $('#btnCancel').on('click', resetForm);

        // Excluir
        $(document).on('click', '.delete-btn', function() {
            if (!confirm('Tem certeza que deseja excluir este imóvel?')) return;

            const id = $(this).data('id');
            $.ajax({
                url: `/imoveis/${id}`,
                type: 'DELETE',
                success: function() {
                    alert('Imóvel excluído com sucesso!');
                    fetchImoveis();
                },
                error: function() {
                    alert('Erro ao excluir o imóvel.');
                }
            });
        });

        // Função para limpar o formulário
        function resetForm() {
            $('#imovelForm')[0].reset();
            $('#imovelId').val('');
            $('#btnCancel').hide();
        }

        // 🔁 POLLING: atualiza a lista a cada 5 segundos
        setInterval(fetchImoveis, 5000);
    </script>
</body>
</html>
