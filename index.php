<?php                 
    include_once('conexao.php'); 
    session_start();

    if(isset($_POST['mat'])){ 
        $matricula = $_POST['mat'];
        $consulta = $dbDB->prepare("SELECT ZRA_MAT, ZRA_NOME FROM PROTHEUS_PRD.dbo.ZRA010 WHERE ZRA_MAT = :matricula   AND ZRA_DEMISS = '' AND ZRA_SITFOL = '' AND ZRA_MAT NOT LIKE '000%'");
        $consulta->bindParam(':matricula', $matricula);
        $consulta->execute();
        $result = $consulta->fetch(PDO::FETCH_ASSOC);
                                
        if ($result) {
            $_SESSION['matricula'] = $result['ZRA_MAT'];
            $_SESSION['nome'] = $result['ZRA_NOME'];
        } else {
            $_SESSION['matricula'] = null;
            $_SESSION['nome'] = null;
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var modal = new bootstrap.Modal(document.getElementById("exampleModal2"));
                        modal.show();
                    });
                  </script>';
        } if($matricula){
            $verifica= $dbDB->prepare("SELECT re FROM ELIPSE_E3.dbo.eleitor_cipa WHERE re = :matricula");
            $verifica->bindParam(':matricula', $matricula);
            $verifica->execute();
            $verificado = $verifica->fetch(PDO::FETCH_ASSOC);
        }
        if($verificado){
            echo'<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var modal = new bootstrap.Modal(document.getElementById("exampleModal"));
                        modal.show();
                    });
                </script>';
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
        <script src="script.js"></script>
        <title>VOTAÇÃO REMOTA - CIPA</title>
    </head>

<body >
    <div class="background-100vh-css">
        <header class="card-body d-flex justify-content-center shadow bg-light mb-3 p-0">
                <img src="img/logos.png" alt="" class="col-3  ">
        </header>

            <div class=" card-body col-sm-12 d-flex justify-content-center mt-5 pt-0">
                <div class="card col-sm-11 border-0 lista-DataWake bg-transparent d-flex align-items-end pt-0 pe-0">
                    <div class="card card-body col-sm-2 container-adm align-items-center p-1 ">
                        <a href="login.php">Painel Administrador </a>
                    </div>
                </div>
            </div>
            <div class=" card-body col-sm-12 d-flex justify-content-center">
                <div class="card col-sm-11 p-3 border-0 container-DataWake lista-DataWake">
                    <h5 class="drop "> <img class="imp" src="img/imp_verde.png" alt=""> VOTAÇÃO REMOTA</h5>
                    <ul>
                        <li>Permitido votar apenas <strong>uma vez</strong></li>
                        <li class="mt-2">Votação interna!</li>
                    </ul>
                </div>
            </div>
                <!------------------------------------------RE------------------------------------------------>
            <div class="card-body col-sm-12 d-flex justify-content-center mb-5 ">
                <div class="card col-sm-11 p-4 border-0 container-DataWake">
                    <form action="" method="POST" class="row g-3">
                        <div class="col-md-3">
                            <label for="re" class="form-label">RE:</label>
                            <input type="number" class="form-control" name="mat" id="matricula" > 
                        </div>
                        <div class="col-md-6">
                            <label for="nome" class="form-label">NOME:</label>
                                <?php
                                    if(isset($result) && isset($_SESSION['nome'])){
                                        echo '<input type="text" id="nome" class="form-control" disabled value="' .  $_SESSION['nome'] . '">';
                                    }else{
                                        echo '<input type="text" id="nome"  class="form-control" disabled value="">';
                                    }
                                ?>
                        </div>
                        <div class="col-md-3">
                            <label for="nome" class="form-label">Seu RE:</label>
                            <?php
                                if(isset($_POST['mat']) && isset($_SESSION['matricula'])){ 
                                    echo '<input type="text" id="re" class="form-control" disabled value="' .  $_SESSION['matricula'] . '">';
                                }else{
                                    echo '<input type="text" id="re" class="form-control" disabled value="">';
                                }
                            ?>
                        </div>
                        <div class="col-sm-4 d-flex mt-4">   
                            <button class=" btn btn-outline-success me-5" id="consulta" type="submit">Consultar</button>
                            <?php
                                if(isset($verificado)){
                                    if(($verificado )){
                                        echo'<div class="card bg-danger align-items-center p-1 pe-3 ps-3 ">
                                                <p class="m-0 fw-bolder">Acesse com outro RE:</p>
                                            </div>';
                                    }else{
                                        echo'<a href="votoRemoto.php" class="btn btn-success" id="btn_acesso" >Acessar</a>';
                                    }  
                                }           
                            ?>
                        </div> 
                    </form>
                </div>
            </div>

    </div>
      
    
    <!-- Modal usuario repetido-->
        <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                    </div>
                <div class="modal-body">
                    "Você já votou uma vez, Você não pode mais volta";
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal usuario não ecncontrado-->
        <div class="modal fade " id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                    </div>
                <div class="modal-body">
                    "O usúario não foi encontrado, digite novamente.";
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn1">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
</body>
</html>