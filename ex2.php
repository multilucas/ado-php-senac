<?php
    // Deixe essas duas linhas. Caso contrário, o navegador não vai conseguir rodar os testes.
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    // Deixe isso. Vai te ajudar.
    date_default_timezone_set("America/Sao_Paulo");
    $hoje = (new DateTimeImmutable("now"))->setTime(0, 0, 0, 0);

/*
https://github.com/UthieleGuim/php/blob/master/ex1.php
Exercício 2 - Formulário, parte 1.
Crie uma página PHP com as seguintes características:
- 1. Os campos recebidos por POST são: "nome", "sexo" e "data-nascimento".
- 2. Sempre devolva uma página HTML completa e bem formada (o teste sempre vai passar ela num validador).
- 3. Se os dados estiverem todos bem formados, coloque dentro do <body>, apenas uma tag <p> contendo o seguinte:
     [Nome] é ["um garoto" ou "uma garota"] de [x] anos de idade.
- 4. Se os dados não estiverem todos bem-formado, coloque dentro do <body>, apenas uma tag <p> contendo o texto "Errado".
- 5. Os únicos valores válidos para o campo "sexo" são "M" e "F".
- 6. O campo "data-nascimento" está no formato "yyyy-MM-dd" e deve corresponder a uma data válida.
     - As partes do mês e do dia devem ter 2 dígitos casa e a do ano deve ter 4 dígitos.
- 7. A data de nascimento não pode estar no futuro e nem ser de mais de 120 anos no passado.
- 8. Espaços à direita ou a esquerda do nome devem ser ignorados. O nome nunca deve estar em branco.
- 9. Se qualquer dado não aparecer no POST, isso é considerado um erro.
Dica:
- Procure no material que o professor já deixou pronto.
*/
function anosDesde($de) {
    global $hoje;
    if (!dataValida($de)) return "<p>Errado</p>";
    $data_de = new DateTimeImmutable($de);
    $intervalo = $hoje->diff($data_de);
    return $intervalo->y;
}
function dataValida($data) {
    $d = new DateTimeImmutable($data);
    if ($data !== $d->format("Y-m-d")) return false;
    if ((int) $d->format("Y") <= 0) return false;
    return true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex2-php</title>
</head>
<body>
    <?php
        if(isset($_POST['nome']))$nome= trim($_POST['nome']);else $nome= "";
        if(isset($_POST['data-nascimento']))$data= $_POST['data-nascimento'];else $data= "";
        if(isset($_POST['sexo']))$sexo= $_POST['sexo'];else $sexo="";
        if (empty($nome))echo "<p>Errado</p>";
        else{
            if (!DateTime::createFromFormat("Y-m-d", $data) || $data != DateTime::createFromFormat("Y-m-d", $data)->format("Y-m-d"))echo "<p>Errado</p>";
            else {  
                if (DateTime::createFromFormat("Y-m-d", $data) > $hoje || DateTime::createFromFormat("Y-m-d", $data)->format("Y") <= 0)echo "<p>Errado</p>";
                else {
                    if(anosDesde($data)>120)echo "<p>Errado</p>";
                    else{
                        if($sexo=="M")echo "<p>".$nome." é um garoto de ".anosDesde($data)." anos de idade.</p>";
                        else if($sexo=="F")echo "<p>".$nome." é uma garota de ".anosDesde($data)." anos de idade.</p>";else echo "<p>Errado</p>";
                    }
                }
            }  
        }    
    ?>
</body>
</html>