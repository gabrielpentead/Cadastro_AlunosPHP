<?php
session_start();

// Classe Aluno
class Aluno {
    private $nome;
    private $matricula;
    private $curso;

    public function __construct($nome, $matricula, $curso) {
        $this->nome = $nome;
        $this->matricula = $matricula;
        $this->curso = $curso;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }
}

// Classe CadastroAlunos
class CadastroAlunos {
    private $alunos = [];
    private $arquivo = "alunos.txt";

    public function __construct() {
        $this->carregarAlunos();
    }

    private function carregarAlunos() {
        if (file_exists($this->arquivo)) {
            $dados = file_get_contents($this->arquivo);
            $lista = json_decode($dados, true);
            if ($lista) {
                foreach ($lista as $item) {
                    $this->alunos[] = new Aluno($item['nome'], $item['matricula'], $item['curso']);
                }
            }
        }
    }

    private function salvarAlunos() {
        $dados = [];
        foreach ($this->alunos as $aluno) {
            $dados[] = [
                'nome' => $aluno->getNome(),
                'matricula' => $aluno->getMatricula(),
                'curso' => $aluno->getCurso()
            ];
        }
        file_put_contents($this->arquivo, json_encode($dados));
    }

    public function cadastrarAluno(Aluno $aluno) {
        $this->alunos[] = $aluno;
        $this->salvarAlunos();
    }

    public function listarAlunos() {
        return $this->alunos;
    }

    public function editarAluno($matricula, $novoNome, $novoCurso) {
        foreach ($this->alunos as $aluno) {
            if ($aluno->getMatricula() == $matricula) {
                $aluno->setNome($novoNome);
                $aluno->setCurso($novoCurso);
                $this->salvarAlunos();
                return;
            }
        }
    }

    public function excluirAluno($matricula) {
        foreach ($this->alunos as $key => $aluno) {
            if ($aluno->getMatricula() == $matricula) {
                unset($this->alunos[$key]);
            }
        }
        $this->alunos = array_values($this->alunos);
        $this->salvarAlunos();
    }

    public function validarMatricula($matricula) {
        foreach ($this->alunos as $aluno) {
            if ($aluno->getMatricula() == $matricula) {
                return false;
            }
        }
        return true;
    }
}

$cadastro = new CadastroAlunos();

// Lógica de Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Lógica de Login
if (!isset($_SESSION['usuario'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        if ($usuario === 'admin' && $senha === 'senha123') {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php"); // Redireciona para evitar reenvio do formulário
            exit;
        } else {
            $erro = 'Usuário ou senha incorretos.';
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="estilo.css">
    </head>
    <body>
        <h1>Login</h1>
        <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
        <form method="post">
            Usuário: <input type="text" name="usuario" required><br>
            Senha: <input type="password" name="senha" required><br>
            <input type="submit" name="login" value="Entrar">
        </form>
    </body>
    </html>

    <?php
    exit;
}

// Lógica de Cadastro e Listagem de Alunos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] == 'excluir') {
        $cadastro->excluirAluno($_POST['matricula']);
    } elseif ($_POST['acao'] == 'editar') {
        $cadastro->editarAluno($_POST['matricula'], $_POST['novo_nome'], $_POST['novo_curso']);
    } else {
        $nome = $_POST['nome'];
        $matricula = $_POST['matricula'];
        $curso = $_POST['curso'];

        if ($cadastro->validarMatricula($matricula)) {
            $aluno = new Aluno($nome, $matricula, $curso);
            $cadastro->cadastrarAluno($aluno);
        } else {
            echo "<p style='color: red;'>Matrícula já existente!</p>";
        }
    }
}

$alunos = $cadastro->listarAlunos();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Alunos</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    <p><a href="?logout">Sair</a></p>
    
    <form method="post">
        Nome: <input type="text" name="nome" required><br>
        Matrícula: <input type="text" name="matricula" required><br>
        Curso: <input type="text" name="curso" required><br>
        <input type="submit" name="acao" value="Cadastrar">
    </form>

    <h2>Lista de Alunos</h2>
    <ul>
        <?php foreach ($alunos as $aluno): ?>
            <li>
                <?php echo $aluno->getNome() . ' - ' . $aluno->getMatricula() . ' - ' . $aluno->getCurso(); ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="acao" value="excluir">
                    <input type="hidden" name="matricula" value="<?php echo $aluno->getMatricula(); ?>">
                    <input type="submit" value="Excluir">
                </form>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="matricula" value="<?php echo $aluno->getMatricula(); ?>">
                    Novo Nome: <input type="text" name="novo_nome" required>
                    Novo Curso: <input type="text" name="novo_curso" required>
                    <input type="submit" value="Editar">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>