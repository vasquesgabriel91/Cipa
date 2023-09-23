<?php 
   include_once('conexao.php'); 
   session_start();
 
   if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['re'])) {

        $re = $_POST["re"];

        $consulta = $dbDB->prepare("SELECT ZRA_MAT, ZRA_NOME, ZRA_CCDESC FROM PROTHEUS_PRD.dbo.ZRA010 WHERE ZRA_MAT = :re");
        $consulta->bindParam(':re', $re);
        $consulta->execute();
        $result = $consulta->fetch(PDO::FETCH_ASSOC);
        header("Location: inscricaoCandidato.php");


        if($result){
            $_SESSION['re'] = $result['ZRA_MAT'];
            $_SESSION['nome'] = $result['ZRA_NOME'];
            $_SESSION['setor'] = $result['ZRA_CCDESC'];
        }
    }
}
?>