<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    <form action="processar_cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula" required><br><br>

        <label for="curso">Curso:</label>
        <input type="text" id="curso" name="curso" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>