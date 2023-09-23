<?php 
include_once('conexao.php'); 
session_start(); 

// $vencedor = $dbDB2->prepare(" SELECT eleitor.id_votado, candidato.nome, COUNT(eleitor.id_votado) AS Qtd
// FROM [eleitor_cipa ] AS eleitor
// INNER JOIN [candidato_cipa] AS candidato ON eleitor.id_votado = candidato.id
// GROUP BY eleitor.id_votado, candidato.nome
// HAVING COUNT(eleitor.id_votado) > 1
// ORDER BY COUNT(eleitor.id_votado) DESC;");
// $vencedor->execute();
// $vencer = $vencedor->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>VOTAÇÃO REMOTA - CIPA</title>
</head>

<body class="background">

<header class="card-body d-flex justify-content-center shadow bg-light mb-5 p-0">
        <img src="img/logos.png" alt="" class="col-3  ">
</header>
<div class=" card-body col-sm-12 d-flex justify-content-center pt-0">
    <div class="card col-sm-11 border-0 lista-DataWake bg-transparent d-flex align-items-end pt-0 pe-0">
        <div class="card card-body col-sm-2 container-adm align-items-center p-1 ">
            <a href="inscricaoCandidato.php">Cadastrar Candidatos</a>
        </div>
    </div>
</div>
<div class="card-body col-sm-12 d-flex justify-content-center  mb-5  ">
    <div class="card col-sm-12 p-4 border-0 container-DataWake ">
    <iframe title="powerBI_Eleições" width="1250" height="550" src="https://app.powerbi.com/reportEmbed?reportId=8b0c6817-2e32-4680-8599-478bf690d25b&autoAuth=true&ctid=5a2406cb-5537-40aa-be45-2f468a017a80"></iframe>    </div>
</div>
 
      <!---------------------FOOTER---------------------->

    <script src="script.js"></script>
</body>
</html>