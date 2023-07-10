<?php

include("conexao.php");

if (isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    if ($arquivo['error']) {
        die("Falha ao enviar arquivos");
    }
    if ($arquivo['size'] > 2097152) {
        die("arquivo muito grande: Max: 2MB");
    }
    $pasta = "arquivos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extesao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if ($extesao != "jpg" && $extesao != 'png') {
        die("Tipo de arquivo não aceito");
    }

    $path = $pasta . $novoNomeDoArquivo . "." . $extesao;
    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);

    if ($deu_certo) {

        $sql = "INSERT INTO arquivos(nome,path) VALUES('$nomeDoArquivo', '$path')";


        if ($conn->query($sql) === TRUE) {
            echo "<p>Arquivo eviado com sucesso!";
            unset($arquivo);
        }

        // $sql = "INSERT INTO arquivos (nome, path) VALUES ('$nomeDoArquivo', '$path')";
        // if ($conn->query($sql) === TRUE) {
        //     echo "<p>Arquivo eviado com sucesso!";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }
    }

}


$sql = "SELECT * FROM arquivos";
$result = $conn->query($sql);




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=s, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data" action="">
        <label for="">Selecione o arquivos</label>
        <input name="arquivo" type="file" value=""><br>
        <button name="upload" type="submit">Eviar arquivos</button>
    </form>


    <table border="1" cellpadding="10">
        <thead>
            <th>imagem</th>
            <th>Arquivos</th>
            <th>Data ubloa</th>

        </thead>
        <tbody>

            <?php
            while ($arquivo = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><img height="50" src="<?php echo $arquivo['path']; ?>" alt=""></td>
                    <td>
                        <?php echo $arquivo['nome']; ?>
                    </td>
                    <td>
                        <?php echo date("d/m/y H:i", strtotime($arquivo['data_upload'])); ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>





</body>

</html>