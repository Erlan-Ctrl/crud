<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    h1 {
      text-align: center;
    }
    form {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .linha {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    label {
      width: 100px;
      text-align: right;
    }
    input[type="text"],
    input[type="password"] {
      flex: 1;
      padding: 6px;
    }
    .linha.id {
      justify-content: space-between;
    }
    .linha.id input {
      flex: 1;
    }
    .linha.id button {
      padding: 6px 15px;
      background-color: #3e613f;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .linha.id button:hover {
      background-color: #375238;
    }
    #mensagem {
      text-align: center;
      font-weight: bold;
      margin-top: 15px;
    }
  
    #tabela-usuarios {
      width: 80%;
      margin: 20px auto;
      border-collapse: collapse;
      display: none;
    }
    #tabela-usuarios th,
    #tabela-usuarios td {
      border: 1px solid #999;
      padding: 8px;
      text-align: left;
    }
    #tabela-usuarios thead tr {
      background-color: #e0e0e0;
    }
  
    #btn-listar {
      padding: 10px 20px;
      background-color: #3a82a3ff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 20px auto;
      display: block;
    }
    
  </style>
</head>
<body>

<h1>Cadastro</h1>

<form id="form-cadastro">
  <div class="linha id">
    <label for="id">ID:</label>
    <input type="text" id="id" name="id" />
    <button type="button" onclick="buscarUsuario()">Buscar</button>
  </div>

  <div class="linha">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="name" required />
  </div>

  <div class="linha">
    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="username" required />
  </div>

  <div class="linha">
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required />
  </div>

  <div class="linha" style="justify-content: center;">
    <button type="submit" style="padding: 10px 20px; background-color: #325f2a; color: white; border: none; border-radius: 5px;">Cadastrar</button>
    <button type="button" onclick="deletarUsuario()" style="padding: 10px 20px; background-color: #8b0000; color: white; border: none; border-radius: 5px; margin-left: 10px;">Deletar</button>
  </div>
</form>

<div id="mensagem"></div>

<button id="btn-listar" onclick="listarUsuarios()">Listar Usuários</button>

<table id="tabela-usuarios">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Usuário</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<script>
  function buscarUsuario() {
    const id = document.getElementById('id').value;

    if (!id) {
      alert('Informe um ID');
      return;
    }

    fetch(`buscar_usuario.php?id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.erro) {
          alert(data.erro);
        } else {
          document.getElementById('nome').value = data.name;
          document.getElementById('usuario').value = data.username;
          document.getElementById('password').value = data.password;
        }
      })
      .catch((error) => {
        console.error('Erro:', error);
      });
  }

  document.getElementById('form-cadastro').addEventListener('submit', function (e) {
    e.preventDefault();

    const nome = document.getElementById('nome').value;
    const usuario = document.getElementById('usuario').value;
    const senha = document.getElementById('password').value;

    const dados = new URLSearchParams();
    dados.append('name', nome);
    dados.append('username', usuario);
    dados.append('password', senha);

    fetch('create.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: dados.toString(),
    })
      .then((response) => response.text())
      .then((mensagem) => {
        const msgDiv = document.getElementById('mensagem');
        msgDiv.textContent = mensagem;
        msgDiv.style.color = mensagem.includes('sucesso') ? 'green' : 'red';

        document.getElementById('nome').value = '';
        document.getElementById('usuario').value = '';
        document.getElementById('password').value = '';
      })
      .catch((error) => {
        const msgDiv = document.getElementById('mensagem');
        msgDiv.textContent = 'Erro ao cadastrar.';
        msgDiv.style.color = 'red';
        console.error('Erro:', error);
      });
  });

  function deletarUsuario() {
    const id = document.getElementById('id').value;

    if (!id) {
      alert('Informe o ID do usuário que deseja deletar.');
      return;
    }

    if (!confirm('Tem certeza que deseja deletar este usuário?')) {
      return;
    }

    const formData = new FormData();
    formData.append('id', id);

    fetch('delete.php', {
      method: 'POST',
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        const msgDiv = document.getElementById('mensagem');
        msgDiv.textContent = data;
        msgDiv.style.color = data.includes('sucesso') ? 'green' : 'red';

        if (data.includes('sucesso')) {
          document.getElementById('id').value = '';
          document.getElementById('nome').value = '';
          document.getElementById('usuario').value = '';
          document.getElementById('password').value = '';
        }
      })
      .catch((error) => {
        console.error('Erro:', error);
        alert('Erro ao tentar deletar o usuário.');
      });
  }

  function listarUsuarios() {
    fetch('read.php', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
      .then((response) => response.json())
      .then((usuarios) => {
        const tabela = document.getElementById('tabela-usuarios');
        const tbody = tabela.querySelector('tbody');
        tbody.innerHTML = '';

        if (usuarios.length === 0) {
          alert('Nenhum usuário encontrado.');
          tabela.style.display = 'none';
          return;
        }

        usuarios.forEach((usuario) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${usuario.id}</td>
            <td>${usuario.name}</td>
            <td>${usuario.username}</td>
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
</script>

</body>
</html>
