<?php 
   include_once('conexao.php'); 
   session_start();
   $re = "";
   $nome = "";
   $setor =  "";
   $apelido = "";
   $imagemErro = "";
   $menssagemErro = "";
   $duplicataErro = "";
   $mensagemSucesso = "";
   
 if(isset($_SESSION['re'])){

    $re = $_SESSION['re'];
    $nome = $_SESSION['nome'];
    $setor =  $_SESSION['setor'];
 }

   if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["apelido"])){
        $menssagemErro = " * DIGITE UM APELIDO ";
    }else{
        $apelido = $_POST["apelido"];
    }

    if (!empty($apelido)) {   

        if(empty($_FILES["imagem"])){
            $imagemErro = "selecione uma imagem ";
        }else{
            $foto = basename($_FILES["imagem"]["name"]);
            $diretorio_temp = $_FILES['imagem']['tmp_name'];
            $img_extensao = strtolower(pathinfo($foto,PATHINFO_EXTENSION));
            $novo_nome_imagem = md5(uniqid()) . "." . $img_extensao;
            $upload_diretorio = 'uploads/';
            $arquivo_imagem = $upload_diretorio . $novo_nome_imagem;

            if($foto){
                move_uploaded_file($diretorio_temp, $arquivo_imagem );
            }else{
                echo "Erro ao enviar a foto";
            }
        }
         // Verificar se o RE já existe no banco de dados
        $verificarRe = $dbDB2->prepare("SELECT COUNT(*) FROM candidato_cipa WHERE re = :re");
        $verificarRe->bindParam(':re', $re);
        $verificarRe->execute();
        $repetido = $verificarRe->fetchColumn();
        if ($repetido > 0) {
            $duplicataErro = "JÁ EXISTE UM REGISTRO COM ESTE RE NO BANCO DE DADOS.";
        } else{
            $inserir = $dbDB2->prepare("INSERT INTO candidato_cipa (re, nome, data_cipa, setor, apelido, foto)VALUES(:re, :nome, CURRENT_TIMESTAMP, :setor, :apelido, :foto)");
            $inserir->bindParam(':re', $re);
            $inserir->bindParam(':nome', $nome);
            $inserir->bindParam(':setor', $setor);
            $inserir->bindParam(':apelido', $apelido);
            $inserir->bindParam(':foto', $arquivo_imagem);
            if ($inserir->execute()) {
                $re = "" ;
                $nome = "" ;
                $setor = "" ;
                $apelido = "";
                $mensagemSucesso = "Inserção no banco de dados realizada com sucesso!";
            }
        }
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


    <body class="">
        <div class="background-100vh-css">

            <header class="card-body d-flex justify-content-center shadow bg-light mb-5 p-0">
                    <img src="img/logos.png" alt="" class="col-3  ">
            </header>
            <div class=" card-body col-sm-12 d-flex justify-content-center ">
                <div class="card col-sm-11 border-0  bg-transparent d-flex align-items-end">
                    <div class=" card col-sm-2 align-items-center p-1 container-adm ">
                        <a href="eleicao.php" >Acompanhe a votação</a>
                    </div>
                </div>
            </div>
            <div class="card-body col-sm-12 d-flex justify-content-center  ">

                <div class="card col-sm-11 p-4 border-0">

                    <form action="buscarCandidato.php" method="POST" >
                        <div class="col-md-2 col-sm-2 col-lg-2 d-flex flex-row justify-content-center align-items-center">
                            <label for="re" class="form-label ms-2">RE:</label>
                            <input type="number" class="form-control me-2" name="re" id="re" >
                            <button class=" btn btn-outline-success  " id="buscar" type="submit">Buscar</button> 
                        </div>
                    </form>

                    <form  action="inscricaoCandidato.php" method="POST" enctype ="multipart/form-data" class=" row d-flex flex-column">
                        <div class="col-md-4 col-sm-4 col-lg-4 d-flex mb-4 mt-4 ">
                            <label for="imagem">Selecione uma imagem:</label>
                            <input type="file" id="imagem" name="imagem" accept="image/*" required class="shadow btn btn-outline-success">
                        </div>     
                        <div class="d-flex flex-row col-sm-12 align-items-center justify-content-around">
                            <div class="col-md-1  col-sm-1  col-lg-1  ">
                                <label for="re" class="form-label">Seu RE:</label>
                                <?php echo '<input type="number" class="form-control" disabled name="re" id="re" value = "'.$re.'">' ?>
                            </div>                           
                            <div class="col-md-4 col-sm-4 col-lg-4">
                                <label for="nome" class="form-label">NOME:</label>
                                <?php echo '<input type="text" id="nome" name= "nome" disabled class="form-control" value=" ' .$nome. ' "> ' ?>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4 ">
                                <label for="setor" class="form-label">SETOR:</label>
                                <?php echo '<input type="text" id="setor" name= "setor" disabled class="form-control" value=" ' .$setor. ' ">  ' ?>
                            </div>

                            <div class="col-md-2 col-sm-2 col-lg-2 ">
                                <label for="apelido" class="form-label ">APELIDO:</label>
                                <div class="flex-column d-flex">
                                    <input type="text" name="apelido" id="apelido" class="form-control  <?php echo (!empty($menssagemErro)) ? 'is-invalid' : ''; ?>"placeholder="" value="">
                                    <span class="invalid-feedback "><?php echo $menssagemErro; ?></span>
                                </div>
                            </div> 
                        </div>

                        <button id="cadastrar" type="submit" class="btn btn-outline-success mt-5 <?php echo (!empty($duplicataErro)) ? 'is-invalid' : ''; ?>">Cadastrar</button>
                        <span class="invalid-feedback"><?php echo $duplicataErro; ?></span>
                        <span class="success-message"><?php echo $mensagemSucesso; ?></span>
                    </form>
                </div>
            </div>
        </div>

    </body>
    <script src="script.js"></script>
</html>