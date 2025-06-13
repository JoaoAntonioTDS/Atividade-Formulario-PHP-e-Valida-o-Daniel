<?php
require_once 'util/Conexao.php';

$con = Conexao::getConexao();
if (isset($_GET["id"])) {
    $sql = "DELETE FROM carros WHERE id = ?";
    $stm = $con->prepare($sql);
    $stm->execute([$_GET["id"]]);
    header("location: index.php");
} else {
    echo "<h1>Parâmetro ID ausente.</h1><a href='index.php'>Voltar</a>";
}
