<?php
    
    ####################### CONEXÃO COM O BANCO #################
    $host ="localhost";
    $user = "root";
    $pass = "1*1databyte1*1";
    $db = "formulario_site";
    $tabela = "solicitacao_orcamento";

    $con = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($con,"utf8");
    mysqli_query($con,"SET NAMES 'utf8'");
    mysqli_query($con,'SET character_set_connection=utf8');
    mysqli_query($con,'SET character_set_client=utf8');
    mysqli_query($con,'SET character_set_results=utf8');
    ##############################################################

    $nome = $_POST["form_nome"]; 
    $telefone = $_POST["form_telefone"];
    $email = $_POST["form_email"];
    $servico_selecionado = $_POST["opcao_servico"];
    $descricao_servico = $_POST["form_descricao"]; 
    $descricao_assunto = $_POST["form_assunto"]; 
    
    // PEGANDO O VALOR DO CAPCTHA
    if (isset($_POST['g-recaptcha-response'])) {
    $captcha_data = $_POST['g-recaptcha-response'];
    }

    if (!$captcha_data) {
        header("Location: https://databytetecnologia.com.br/");
        exit; 
    } else {
        $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcvzaAUAAAAAJ_Wodkq6ZrlmCbeP2Oamf_HqGDq&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']);
        
        if ($resposta.success) {
            
            date_default_timezone_set('America/Bahia');
            $data_solicitacao = date('Y-m-d H:i:s');

            $query = ("INSERT INTO $tabela (`nome`, `telefone`, `email`, `servico_selecionado`, `descricao_servico`, `data_solicitacao`) VALUES ('$nome','$telefone','$email','$servico_selecionado','$descricao_servico','$data_solicitacao')");
            $retorno = mysqli_query($con, $query);

            sendMessage();
            header("Location: https://databytetecnologia.com.br/");
            exit;

            function sendMessage(){
            $content = array(
                "en" => 'Nova Solicitação de Orçamento DataByte Tecnologia'
                );

            $fields = array(
                'app_id' => "cd09a010-fe03-45b1-8a51-52ffe26708ff",
                'included_segments' => array('All'),
            'data' => array("foo" => "bar"),
            'android_led_color' => "001955",
            'android_accent_color' => "001955",
            'small_icon' =>"ic_stat_onesignal_default",
            'large_icon' =>"https://databytetecnologia.com.br/arquivos/images/logos/icon.png",
            'contents' => $content    );

                $fields = json_encode($fields);
            print("\nJSON sent:\n");
            print($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                               'Authorization: Basic ODk5ZGNhYjItOGRiZS00NjBlLWI3ZjAtYjMxNmVlMWRlMWMw'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
            }   

        } else {

            header("Location: https://databytetecnologia.com.br/");
            exit;
        }
    }     
?>