# PROJETO LISTA DE TAREFAS - CARLOS EDUARDO DE SOUSA

Este sistema web permite o cadastro, listagem, exclusão, conclusão e edição de tarefas com ou sem prazo. O sistema utiliza PHP, MySQL e JavaScript, com autenticação de usuários.

---

# FUNCIONALIDADES

- Cadastro de usuários
- Login com autenticação de sessão
- Adição de tarefas (com ou sem prazo)
- Validação de datas (fim não pode ser anterior ao início)
- Listagem automática das tarefas cadastradas
- Edição das datas da tarefa
- Marcar como concluída (com destaque visual)
- Exclusão de tarefas
- Upload de foto de perfil
- Logout

---

# ESTRUTURA DE PASTAS

controllers/
├── index.php                 ← Redireciona para login ou lista
├── install.php               ← Instalação automática do banco
├── login.php                 ← Autenticação
├── logout.php                ← Logout
├── TarefaController.php      ← CRUD de tarefas
├── UsuarioController.php     ← CRUD de usuários

includes/
├── conexao.php               ← Conexão com banco
├── verifica_instalacao.php   ← Verifica se DB foi instalado

views/
├── lista_de_tarefas.php      ← Tela principal do sistema
├── cadastro_usuario.html     ← Tela de cadastro
├── login.html                ← Tela de login
├── instalador.html           ← Tela de instalação

css/
├── cadastro_usuario.css
├── login.css
├── lista_de_tarefas.css

JS/
├── cadastro_usuario.js
├── instalador.js
├── lista_de_tarefas.js

models/
├── tarefas.php
├── usuarios.php

database/
└── banco_de_dados.sql        ← Estrutura do banco

imagens/
├── Foto-padrão.png           ← Avatar padrão
├── Cabeçalho FMU.png         ← Logo FMU

README.txt                    ← Este arquivo

---

# INSTALAÇÃO

1. Pré-requisitos:
   - XAMPP ou WAMP com MySQL e Apache
   - PHP 7.4+

2. Passos:
   - Coloque a pasta do projeto dentro de "htdocs"
   - Inicie o Apache e MySQL via XAMPP
   - Acesse no navegador:
     **http://localhost/Projeto_Lista_Tarefas/views/instalador.html** para criar o banco de dados na sua máquina e depois automaticamente ser direcionado para a página de login.

     **http://localhost/Projeto_Lista_Tarefas/index.php** acesse no caso de já estar logado e continuar a partir da lista de tarefas ou no caso de já ter criado o banco de dados.

3. **Cadastro e login**:
   - Após instalação, vá para a tela de login
   - Cadastre um novo usuário
   - Faça login e comece a cadastrar tarefas

---

# LÓGICA DE FUNCIONAMENTO

- Todas as tarefas são relacionadas ao id_usuario autenticado via sessão
- As ações são feitas via fetch (AJAX puro com FormData e URLSearchParams)
- Tarefas e usuários são persistidos no banco de dados
- As tarefas são carregadas automaticamente ao abrir a tela
- Sessão expirada redireciona para login.html

---

# BASE DE DADOS

Caso precise importar manualmente, o arquivo `database/banco_de_dados.sql` contém:

- Tabela usuarios
- Tabela tarefas

Exemplo de consulta das tabelas no MySQL

USE LISTA_TAREFAS;

SELECT * FROM `USUARIOS`;
SELECT * FROM `TAREFAS`;
---

Carlos Eduardo de Sousa  
Projeto acadêmico desenvolvido para a FMU
RA: 09026691  
Desenvolvido com PHP, MySQL, HTML 5, CSS 3 e JavaScript.
