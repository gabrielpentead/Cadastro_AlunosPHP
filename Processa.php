<?php
require_once 'Aluno.php';
require_once 'CadastroAlunos.php';

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $curso = $_POST['curso'];

    // Cria uma instância da classe Aluno
    $aluno = new Aluno($nome, $matricula, $curso);

    // Cria uma instância da classe CadastroAlunos
    $cadastro = new CadastroAlunos();

    // Cadastra o aluno
    $cadastro->cadastrarAluno($aluno);

    // Lista todos os alunos cadastrados
    $alunosCadastrados = $cadastro->listarAlunos();

    // Exibe os alunos cadastrados
    echo "<h2>Alunos Cadastrados:</h2>";
    foreach ($alunosCadastrados as $aluno) {
        echo "Nome: " . $aluno->getAluno() . "<br>";
        echo "Matrícula: " . $aluno->getMatricula() . "<br>";
        echo "Curso: " . $aluno->getCurso() . "<br><br>";
    }
}
?>