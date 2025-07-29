<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro de Usuários</title>
    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --radius: 14px;
      --radius-pill: 999px;
      --shadow-1: 0 6px 18px rgba(0,0,0,.06);
      --shadow-2: 0 10px 28px rgba(0,0,0,.08);
    }

    html, body { height: 100%; }
    body { padding-top: 3rem !important; } 

    #mensagem { 
      font-weight: 600; 
      text-align: center; 
      margin-top: 15px; 
    }

    .cadastro-wrapper{
      max-width: 560px;
      margin: 0 auto;
    }

    #aviso-edicao,
    #form-cadastro{
      width: 100%;
    }

    #form-cadastro{
      border-radius: var(--radius);
      box-shadow: var(--shadow-1);
      transition: box-shadow .2s ease, transform .2s ease;
      background: #fff;
    }

    #form-cadastro:hover{
      box-shadow: var(--shadow-2);
      transform: translateY(-1px);
    }

    #titulo{
      font-weight: 700;
      letter-spacing: .2px;
      margin-bottom: 1.25rem !important;
    }

    #aviso-edicao{
      margin-bottom: 12px;
      border-left: 4px solid var(--bs-primary);
      background-color: rgba(var(--bs-primary-rgb), .08);
    }

    .editando{
      border: 2px solid var(--bs-primary);
      padding: 20px;
      border-radius: var(--radius);
      background: rgba(var(--bs-primary-rgb), .03);
    }

    .form-control{
      border-radius: 10px;
      transition: box-shadow .15s ease, border-color .15s ease;
    }

    .input-group .btn{
      border-radius: 10px;
    }

    .input-group .btn:hover{
      filter: brightness(0.98);
    }

    .botoes-direita{
      display: flex;
      justify-content: end; 
      align-items: center;
      gap: .5rem;
    }

    .btn-success{
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,.12);
      transition: transform .06s ease, box-shadow .2s ease, filter .2s ease;
    }

    .btn-success:hover{
      box-shadow: 0 6px 18px rgba(0,0,0,.18);
      filter: saturate(1.02);
    }

    .btn-success:active{
      transform: translateY(1px);
    }

    #div-botao-cancelar .btn{
      border-radius: 10px;
    }

    #grupo-busca{
      width: clamp(26ch, 32ch + 2vw, 40ch);
      margin: 0 auto;  
    }

    #grupo-busca .form-control{
      border-radius: var(--radius-pill) 0 0 var(--radius-pill) !important;
    }

    #grupo-busca .btn{
      border-radius: 0 var(--radius-pill) var(--radius-pill) 0 !important;
    }

    #grupo-busca:focus-within{
      box-shadow: 0 0 0 .25rem rgba(var(--bs-primary-rgb), .15);
      border-radius: var(--radius-pill);
    }

    #tabela-usuarios{
      border-radius: 10px;
      overflow: hidden;
    }

    #tabela-usuarios thead{
      position: sticky;
      top: 0;
      z-index: 1;
    }

    #tabela-usuarios tbody tr{
      transition: background-color .15s ease, transform .12s ease;
    }

    #tabela-usuarios tbody tr:hover{
      background-color: rgba(0,0,0,.02);
      transform: translateY(-1px);
    }

    #tabela-usuarios td:last-child .btn{
      border-radius: 8px;
    }

    .is-valid{ border-color: var(--bs-success) !important; }
    .is-invalid{ border-color: var(--bs-danger) !important; }

    @media (max-width: 576px){
      .col-form-label{ text-align: left !important; }
      .botoes-direita{ justify-content: stretch; }
      .botoes-direita > *{ flex: 1 1 auto; }
    }
  </style>
</head>
<body class="bg-light py-5">

<div class="container">
  <h1 class="text-center mb-4" id="titulo">Cadastro</h1>

  <div class="cadastro-wrapper">

    <div id="aviso-edicao" class="alert alert-warning text-center d-none">
      Você está editando um usuário.
    </div>

    <form id="form-cadastro" class="bg-white p-4 rounded shadow-sm">
      <input type="hidden" id="id" name="id" />

      <div class="mb-3 row">
        <label for="nome" class="col-sm-2 col-form-label text-end">Nome:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nome" name="name" required autofocus />
        </div>
      </div>

      <div class="mb-3 row">
        <label for="usuario" class="col-sm-2 col-form-label text-end">Usuário:</label> 
        <div class="col-sm-10">
          <input type="text" class="form-control" id="usuario" name="username" required />
        </div>
      </div>

      <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label text-end">Senha:</label>
        <div class="col-sm-10">
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required minlength="6" />
            <button type="button" class="btn btn-outline-secondary" onclick="toggleSenha()">
              <i class="bi bi-eye" id="icone-senha"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="botoes-direita">
        <button type="submit" class="btn btn-success" id="btn-submit">
          <i class="bi bi-check-circle"></i> Cadastrar
        </button>
        <div id="div-botao-cancelar"></div>
      </div>
    </form>
  </div> 

  <div id="mensagem" class="mt-3"></div>

  <div id="grupo-busca" class="input-group my-4">
    <input type="text" id="busca" class="form-control" placeholder="Buscar por nome ou usuário">
    <button class="btn btn-outline-primary" type="button" id="btn-buscar">
      <i class="bi bi-search"></i> Buscar
    </button>
  </div>

  <table id="tabela-usuarios" class="table table-bordered table-striped table-hover mt-4" style="display: none;">
    <thead class="table-secondary">
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Usuário</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<script>

  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"

  const TEMPO_VALIDACAO = 300;
  
  function limparValidacoes() {
    ['nome','usuario','password'].forEach(id => {
      const el = document.getElementById(id);
      el.classList.remove('is-valid','is-invalid');
    });
  }

  function limparFormulario() {
    document.getElementById('form-cadastro').classList.remove('editando');
    document.getElementById('aviso-edicao').classList.add('d-none');
    document.getElementById('id').value = '';
    document.getElementById('nome').value = '';
    document.getElementById('usuario').value = '';
    document.getElementById('password').value = '';
    document.getElementById('titulo').textContent = 'Cadastro';
    document.querySelector('button[type="submit"]').innerHTML = '<i class="bi bi-check-circle"></i> Cadastrar';
    document.querySelector('#div-botao-cancelar').innerHTML = '';
    limparValidacoes();
  }

  function mostrarMensagem(texto, sucesso = true) {
    const msgDiv = document.getElementById('mensagem');
    msgDiv.className = `alert ${sucesso ? 'alert-success' : 'alert-danger'} fade show`;
    msgDiv.setAttribute('role', 'alert');
    msgDiv.innerHTML = `
      <i class="bi ${sucesso ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
      ${texto}
    `;
    setTimeout(() => {
      msgDiv.classList.remove('show');
      setTimeout(() => {
        msgDiv.className = '';
        msgDiv.innerHTML = '';
      }, 150);
    }, 4000);
  }

  function mostrarBotaoCancelar() {
    document.querySelector('#div-botao-cancelar').innerHTML = `
      <button type="button" onclick="cancelarEdicao()" class="btn btn-danger">
        <i class="bi bi-x-circle"></i> Cancelar
      </button>
    `;
  }

  function cancelarEdicao() {
    limparFormulario();
  }

  function toggleSenha() {
    const input = document.getElementById('password');
    const icone = document.getElementById('icone-senha');
    const btn = icone.closest('button');

    if (input.type === 'password') {
      input.type = 'text';
      icone.classList.replace('bi-eye', 'bi-eye-slash');
      btn.title = 'Ocultar senha';
    } else {
      input.type = 'password';
      icone.classList.replace('bi-eye-slash', 'bi-eye');
      btn.title = 'Mostrar senha';
    }
  }

  function buscarUsuario(id) {
    fetch(`buscar_usuario.php?id=${id}`)
      .then(res => res.json())
      .then(data => {
        if (data.erro) {
          alert(data.erro);
        } else {
          document.getElementById('id').value = id;
          document.getElementById('nome').value = data.name;
          document.getElementById('usuario').value = data.username;
          document.getElementById('password').value = '';
          document.getElementById('titulo').textContent = 'Editar Usuário';
          document.querySelector('button[type="submit"]').innerHTML = '<i class="bi bi-save"></i> Atualizar';
          document.getElementById('form-cadastro').classList.add('editando');
          document.getElementById('aviso-edicao').classList.remove('d-none');
          mostrarBotaoCancelar();
          limparValidacoes();
        }
      })
      .catch((error) => console.error('Erro:', error));
  }

  function deletarUsuario(id) {
    if (!confirm('Tem certeza que deseja deletar este usuário?')) return;
    const formData = new FormData();
    formData.append('id', id);
    fetch('delete.php', {
      method: 'POST',
      body: formData,
    })
      .then(res => res.text())
      .then((data) => {
        mostrarMensagem(data, data.includes('sucesso'));
        if (data.includes('sucesso')) {
          limparFormulario();
          listarUsuarios();
        }
      })
      .catch((error) => {
        console.error('Erro:', error);
        alert('Erro ao tentar deletar o usuário.');
      });
  }

  function listarUsuarios() {
    return fetch('read.php', {
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
      .then(res => res.json())
      .then((usuarios) => {
        const tabela = document.getElementById('tabela-usuarios');
        const tbody = tabela.querySelector('tbody');
        tbody.innerHTML = '';
        if (!usuarios || usuarios.length === 0) {
          tabela.style.display = 'none';
          return;
        }
        usuarios.forEach((usuario) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${usuario.id}</td>
            <td class="nome">${usuario.name}</td>
            <td class="usuario">${usuario.username}</td>
            <td>
              <button class="btn btn-sm btn-warning me-1" onclick="buscarUsuario(${usuario.id})" title="Editar">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="deletarUsuario(${usuario.id})" title="Excluir">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          `;
          tbody.appendChild(row);
        });
        tabela.style.display = 'table';
      })
      .catch((error) => {
        console.error('Erro ao listar usuários:', error);
        alert('Erro ao carregar usuários.');
      });
  }

  document.getElementById('form-cadastro').addEventListener('submit', function (e) {
    e.preventDefault();
    const nome = document.getElementById('nome');
    const usuario = document.getElementById('usuario');
    const senha = document.getElementById('password');
    const botao = document.getElementById('btn-submit');

    nome.classList.toggle('is-valid', nome.value.length > 2);
    usuario.classList.toggle('is-valid', usuario.value.length > 2);
    senha.classList.toggle('is-valid', senha.value.length >= 6);

    setTimeout(limparValidacoes, TEMPO_VALIDACAO);

    const dados = new URLSearchParams();
    dados.append('name', nome.value);
    dados.append('username', usuario.value);
    dados.append('password', senha.value);

    let url = 'create.php';
    if (document.getElementById('id').value) {
      url = 'update.php';
      dados.append('id', document.getElementById('id').value);
    }

    botao.disabled = true;

    const originalHTML = botao.innerHTML;
    botao.innerHTML = `
      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
      Salvando...
    `;

    fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: dados.toString(),
    })
      .then(res => res.text())
      .then((mensagem) => {
        mostrarMensagem(mensagem, mensagem.includes('sucesso'));
        setTimeout(() => {
          limparFormulario();
          listarUsuarios();
        }, TEMPO_VALIDACAO);
      })
      .catch((error) => {
        console.error('Erro:', error);
        mostrarMensagem('Erro ao cadastrar.', false);
      })
      .finally(() => {
        botao.disabled = false;
        botao.innerHTML = originalHTML;
      });
  });

  function filtrarUsuariosTermo(termo) {
    const linhas = document.querySelectorAll('#tabela-usuarios tbody tr');
    linhas.forEach((linha) => {
      const nome = linha.querySelector('.nome').textContent.toLowerCase();
      const usuario = linha.querySelector('.usuario').textContent.toLowerCase();
      const visivel = !termo || nome.includes(termo) || usuario.includes(termo);
      linha.style.display = visivel ? '' : 'none';
    });
  }

  document.getElementById('btn-buscar').addEventListener('click', () => {
    const termo = document.getElementById('busca').value.trim().toLowerCase();
    listarUsuarios().then(() => filtrarUsuariosTermo(termo));
  });

  document.addEventListener('DOMContentLoaded', () => {
    const btnOlho = document.getElementById('icone-senha')?.closest('button');
    if (btnOlho) btnOlho.title = 'Mostrar senha';
  });

  listarUsuarios();
</script>

</body>
</html>
