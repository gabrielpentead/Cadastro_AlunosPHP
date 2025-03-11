<?php
class CadastroAlunos {
    private $alunos = [];

    public function __construct() {
        // Verifica se já existe uma lista de alunos na sessão
        if (isset($_SESSION['alunos'])) {
            $this->alunos = $_SESSION['alunos'];
        }
    }

    // Método para cadastrar um aluno
    public function cadastrarAluno(Aluno $aluno) {
        $this->alunos[] = $aluno;
        $_SESSION['alunos'] = $this->alunos; 
    }

    // Método para listar todos os alunos cadastrados
    public function listarAlunos() {
        return $this->alunos;
    }

    // Método para editar as informações de um aluno
    public function editarAluno($matricula, $novoNome, $novoCurso) {
        foreach ($this->alunos as $aluno) {
            if ($aluno->getMatricula() == $matricula) {
                $aluno->setAluno($novoNome);
                $aluno->setCurso($novoCurso);
                break;
            }
        }
        $_SESSION['alunos'] = $this->alunos; 
    }

    // Método para excluir um aluno pelo número de matrícula
    public function excluirAluno($matricula) {
        $this->alunos = array_filter($this->alunos, function($aluno) use ($matricula) {
            return $aluno->getMatricula() != $matricula;
        });
        $_SESSION['alunos'] = $this->alunos; 
    }
}
?>
