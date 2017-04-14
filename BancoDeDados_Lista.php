<HTML>
    <HEAD>
        <TITLE>Banco de Dados: Lista</TITLE>
    </HEAD>
    <BODY>
        <TABLE border=1>
            <TR>
                <TH>Nome</TH>
                <TH>E-mail</TH>
                <TH>Idade</TH>
                <TH>Sexo</TH>
                <TH>Estado Civil</TH>
                <TH>Humanas</TH>
                <TH>Exatas</TH>
                <TH>Biológicas</TH>
                <TH>Hash da senha</TH>
                <TH>Ações</TH>
            </TR>
<?php

    try
    {
        $connection = new PDO("mysql:host=127.0.0.1;dbname=cursophp", "root", "37738789");
        $connection->exec("set names utf8");
    }
    catch(PDOException $e)
    {
        echo "Falha: " . $e->getMessage();
        exit();
    }
    
    if(isset($_REQUEST["excluir"]) && $_REQUEST["excluir"] == true)
    {
        $stmt = $connection->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bindParam(1, $_REQUEST["id"]);
        $stmt->execute();
        
        if($stmt->errorCode() != "00000")
        {
            echo "Erro código " . $stmt->errorCode() . ": ";
            echo implode(", ", $stmt->errorInfo());
        }
        else
        {
            echo "Sucesso: usuário removido com sucesso<BR><BR>";
        }
    }
    
    $rs = $connection->prepare("SELECT * FROM usuarios");
    
    if($rs->execute())
    {
        while($registro = $rs->fetch(PDO::FETCH_OBJ))
        {
            echo "<TR>";
            
            echo "<TD>" . $registro->nome . "</TD>";
            echo "<TD>" . $registro->email . "</TD>";
            echo "<TD>" . $registro->idade . "</TD>";
            echo "<TD>" . $registro->sexo . "</TD>";
            echo "<TD>" . $registro->estado_civil . "</TD>";
            echo "<TD>" . $registro->humanas . "</TD>";
            echo "<TD>" . $registro->exatas . "</TD>";
            echo "<TD>" . $registro->biologicas . "</TD>";
            echo "<TD>" . $registro->senha . "</TD>";
            
            echo "<TD>";
            echo "<A href='?excluir=true&id=" . $registro->id . "'>(exclusão)</A>";
            echo "<A href='BancoDeDados_Alterar.php?id=" . $registro->id . "'>(alteração)</A>";
            echo "<A href='BancoDeDados_Senha.php?id=" . $registro->id . "'>(alteração de senha)</A>";
            echo "<TD>";
            
            echo "</TR>";
        }
    }
    else
    {
        echo "Falha na seleção de usuários<BR>";
    }

?>
        </TABLE>
        
        <BR>
        <A href="BancoDeDados_Cadastro.php">Criar um novo registro</A>
    </BODY>
</HTML>