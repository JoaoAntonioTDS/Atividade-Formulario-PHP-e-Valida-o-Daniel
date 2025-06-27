<?php
require_once 'util/Conexao.php';

function traduzirMotor($codigo) {
    if ($codigo == "E") return "Elétrico";
    elseif ($codigo == "C") return "Combustão";
    elseif ($codigo == "H") return "Híbrido";
    else return "???";
}

function traduzirCor($codigo) {
    if ($codigo == "B") return "Branco";
    elseif ($codigo == "P") return "Preto";
    elseif ($codigo == "V") return "Vermelho";
    elseif ($codigo == "A") return "Amarelo";
    elseif ($codigo == "Z") return "Azul";
    elseif ($codigo == "E") return "Verde";
    elseif ($codigo == "C") return "Cinza";
    elseif ($codigo == "R") return "Rosa";
    elseif ($codigo == "M") return "Marrom";
    else return "???";
}

$con = Conexao::getConexao();

$sql = "SELECT * FROM carros";
$stm = $con->prepare($sql);
$stm->execute();
$carros = $stm->fetchAll();

$msgErro = "";
$marca = "";
$modelo = "";
$motor = "";
$cor = "";
$ano = "";

if (isset($_POST["marca"])) {
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $motor = $_POST["motor"];
    $cor = $_POST["cor"];
    $ano = $_POST["ano"];

    $erros = [];

    if (!$marca)
        array_push($erros, "Informe a marca!");
    elseif (strlen($marca) < 2 || strlen($marca) > 20)
        array_push($erros, "A marca deve ter entre 2 e 20 caracteres!");

    if (!$modelo)
        array_push($erros, "Informe o modelo!");
    elseif (strlen($modelo) < 2 || strlen($modelo) > 20)
        array_push($erros, "O modelo deve ter entre 2 e 20 caracteres!");

    if (!$motor)
        array_push($erros, "Informe o tipo de motor!");

    if (!$cor)
        array_push($erros, "Informe a cor!");

    if (!$ano)
        array_push($erros, "Informe o ano!");
    elseif ($ano < 1800 || $ano > 2026)
        array_push($erros, "O ano deve estar entre 1800 e 2026!");

    if (count($erros) == 0) {
        $sql = "INSERT INTO carros (marca, modelo, motor, cor, ano)
                VALUES (?, ?, ?, ?, ?)";
        $stm = $con->prepare($sql);
        $stm->execute([$marca, $modelo, $motor, $cor, $ano]);

        header("location: index.php");
    } else {
        $msgErro = implode("<br>", $erros);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Carros</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>Listagem de Carros</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Motor</th>
            <th>Cor</th>
            <th>Ano</th>
            <th>Excluir</th>
        </tr>
        <?php foreach ($carros as $c): ?>
            <tr>
                <td><?= $c["id"] ?></td>
                <td><?= $c["marca"] ?></td>
                <td><?= $c["modelo"] ?></td>
                <td><?= traduzirMotor($c["motor"]) ?></td>
                <td><?= traduzirCor($c["cor"]) ?></td>
                <td><?= $c["ano"] ?></td>
                <td><a href="excluir.php?id=<?= $c['id']; ?>" onclick="return confirm('Confirmar exclusão?')">Excluir</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h1>Formulário</h1>
    <form action="" method="post">
        <div>
            <label>Marca:</label>
            <input type="text" name="marca" value="<?= $marca ?>" />
        </div>
        <div>
            <label>Modelo:</label>
            <input type="text" name="modelo" value="<?= $modelo ?>" />
        </div>
        <div>
            <label>Motor:</label>
            <select name="motor">
                <option value="">Selecione</option>
                <option value="E" <?= $motor == 'E' ? "selected" : "" ?>>Elétrico</option>
                <option value="C" <?= $motor == 'C' ? "selected" : "" ?>>Combustão</option>
                <option value="H" <?= $motor == 'H' ? "selected" : "" ?>>Híbrido</option>
            </select>
        </div>
        <div>
            <label>Cor:</label>
            <select name="cor">
                <option value="">Selecione</option>
                <option value="B" <?= $cor == 'B' ? "selected" : "" ?>>Branco</option>
                <option value="P" <?= $cor == 'P' ? "selected" : "" ?>>Preto</option>
                <option value="V" <?= $cor == 'V' ? "selected" : "" ?>>Vermelho</option>
                <option value="A" <?= $cor == 'A' ? "selected" : "" ?>>Amarelo</option>
                <option value="Z" <?= $cor == 'Z' ? "selected" : "" ?>>Azul</option>
                <option value="E" <?= $cor == 'E' ? "selected" : "" ?>>Verde</option>
                <option value="C" <?= $cor == 'C' ? "selected" : "" ?>>Cinza</option>
                <option value="R" <?= $cor == 'R' ? "selected" : "" ?>>Rosa</option>
                <option value="M" <?= $cor == 'M' ? "selected" : "" ?>>Marrom</option>
            </select>
        </div>
        <div>
            <label>Ano:</label>
            <input type="number" name="ano" value="<?= $ano ?>" min="1800" max="2026" />
        </div>
        <div>
            <button type="submit">Gravar</button>
        </div>
        <div style="color:red;"><?= $msgErro ?></div>
    </form>
</body>
</html>

