<?php
class Aluno {

    private $aluno;
    private $matricula;
    private $curso;

    public function __construct($aluno, $matricula, $curso) {
        $this->aluno = $aluno;
        $this->matricula = $matricula;
        $this->curso = $curso;
    }

    public function getAluno() {
        return $this->aluno;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setAluno($novoAluno) {
        $this->aluno = $novoAluno;
    }

    public function setMatricula($novaMatricula) {
        $this->matricula = $novaMatricula;
    }

    public function setCurso($novoCurso) {
        $this->curso = $novoCurso;
    }
}
?>