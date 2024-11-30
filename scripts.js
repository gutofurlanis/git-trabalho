const tabela = document.getElementById('tabela-pacientes');
const pesquisaInput = document.getElementById('pesquisa');
const adicionarBtn = document.getElementById('adicionar');
const formCadastro = document.getElementById('form-cadastro'); // Referência ao formulário
const cancelarBtn = document.getElementById('cancelar'); // Botão cancelar no formulário

// Função para buscar os dados dos pacientes do banco de dados
function buscarPacientes() {
    // Exemplo de lógica para buscar pacientes via API (ou banco)
    // Substitua por uma requisição real ao banco de dados.
    console.log("Buscando pacientes...");
}

// Função para exibir o formulário de cadastro
function exibirFormulario() {
    // Redireciona para a página de cadastro
    window.location.href = 'cadastrar_pessoa.php'; // Aqui, o link é para a página de cadastro
}

// Função para ocultar o formulário de cadastro
function ocultarFormulario() {
    formCadastro.style.display = 'none';
}

// Função para filtrar os pacientes por nome
function filtrarPacientes() {
    const filtro = pesquisaInput.value.toLowerCase();
    const linhas = tabela.querySelectorAll('tbody tr');

    linhas.forEach((linha) => {
        const nome = linha.querySelector('td:first-child').textContent.toLowerCase();
        if (nome.includes(filtro)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
}

// Função para editar paciente
function editarPaciente(id) {
    // Redireciona para a página de edição passando o ID do paciente
    window.location.href = `editar.php?id=${id}`;
}

// Função para excluir paciente
function excluirPaciente(id) {
    if (confirm('Você tem certeza que deseja excluir este paciente?')) {
        // Redireciona para a página excluir.php passando o ID
        window.location.href = `excluir.php?id=${id}`;  // Alterado para excluir.php
    }
}

// Adiciona os eventos para os botões de editar e excluir
function adicionarEventosAcoes() {
    // Acha todos os botões de editar e excluir na tabela
    const editarButtons = document.querySelectorAll('.editar');
    const excluirButtons = document.querySelectorAll('.excluir');

    // Adiciona evento de editar
    editarButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id'); // Pega o ID do paciente
            editarPaciente(id); // Chama a função de editar
        });
    });

    // Adiciona evento de excluir
    excluirButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id'); // Pega o ID do paciente
            excluirPaciente(id); // Chama a função de excluir
        });
    });
}

// Eventos principais
pesquisaInput.addEventListener('input', filtrarPacientes); // Filtrar ao digitar
adicionarBtn.addEventListener('click', exibirFormulario); // Redireciona para o cadastro ao clicar em "+"
cancelarBtn.addEventListener('click', ocultarFormulario); // Ocultar formulário ao clicar em "Cancelar"

// Chama a função para buscar os pacientes inicialmente
buscarPacientes();

// Chama a função para adicionar os eventos de editar e excluir depois que a tabela for carregada
adicionarEventosAcoes();
