<?php
include_once('conexao.php'); 
session_start(); 
if (!isset($_SESSION['matricula']) || !isset($_SESSION['nome'])) {
    header("Location: index.php"); // Redireciona para a página de login
    exit();
}
$matricula = $_SESSION['matricula'];
$nome = $_SESSION['nome'];

        $buscar = $dbDB2->prepare("SELECT * FROM candidato_cipa");
        $buscar->execute();
        $resultados = $buscar->fetchAll(PDO::FETCH_ASSOC);

        
        if (isset($_POST['id_votado'])) {
            $id_votado = $_POST['id_votado'];
            
            $buscar = $dbDB->prepare("SELECT ZRA_MAT, ZRA_NOME FROM PROTHEUS_PRD.dbo.ZRA010 WHERE ZRA_MAT = :matricula");
            $buscar->bindParam(':matricula', $matricula);
            $buscar->execute();
            $dados_resultado = $buscar->fetch(PDO::FETCH_ASSOC);

            if ($dados_resultado) {
                $re = $dados_resultado['ZRA_MAT'];
                $inserir = $dbDB2->prepare("INSERT INTO eleitor_cipa (nome, data_votação, id_votado, re) VALUES (:nome, CURRENT_TIMESTAMP, :id_votado, :re)");
                $inserir->bindParam(':nome', $nome);
                $inserir->bindParam(':id_votado', $id_votado);
                $inserir->bindParam(':re', $re);
                $inserir->execute(); 
            }
            if($dados_resultado){
                header("Location: agradecimento.php");
            }
    }
    
  
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>VOTAÇÃO REMOTA - CIPA</title>
</head>


<body >
    <div class="background">

        <header class="card-body d-flex justify-content-center shadow bg-light mb-5 p-0">
                <img src="img/logos.png" alt="" class="col-3  ">
        </header>

        <div class=" card-body col-sm-12 d-flex justify-content-center">
            <div class="card col-sm-11 p-4 border-0  shadow ">
                <h5> <img class="imp" src="img/imp_verde.png" alt=""> VOTAÇÃO REMOTA</h5>
                <ul class="list-unstyled">
                    <li>Permitido votar apenas <strong>uma vez</strong></li>
                    <li class="mt-2">Votação interna!</li>
                </ul>
            </div>
        </div>
                <!------------------------------------------RE------------------------------------------------>
        <div class="card-body d-flex justify-content-center col-sm-12">
            <div class="card d-flex align-items-center border-0 col-sm-11 bg-light pb-3">
                <form class="col-sm-8" action="votoRemoto.php" method="POST">
                    <?php           
                        foreach ($resultados as $row) {

                            echo'<div class=" m-3 d-flex  border-0 shadow align-items-center rounded bg-color">
                                    <img class=" col-sm-3 img-perfil-css m-2" src="'.$row['foto'].'" title="" alt="" />
                                        <div class="text-start d-flex flex-column ms-5 ">
                                            <div class="d-flex input-checkmt-3 mb-3">
                                                <input type="radio" class=" me-2" name="id_votado" value="'.$row['id'].'">
                                                <p class="text-uppercase fw-bolder fst-italic fs-5 m-0 ">'.$row['nome'].'<br></p> 
                                            </div>
                                            <ul class="p-0 fs-6 list-unstyled text-secondary">
                                                <li>número : '. $row['id'] .'</li>
                                                <li>Setor : ' . $row['setor'] . '</li>
                                                <li>Apelido : '. $row['apelido'] .'</li>
                                            </ul>
                                        </div>       
                                </div>';
                                }
                    ?>
                        <div class=" col-sm-5 ms-3 p-0 d-flex justify-content-start ">
                            <input type="submit" value="Votar" class="btn btn-success col-sm-7 btn-voto m-0"> 
                        </div>
                </form>    
            </div>
        </div>
    </div>
</body>
<script src="script.js"></script>

</html>