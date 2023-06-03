<?php
   header('Cache-control: private, no-cache');
   header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set('memory_limit', -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
//   error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
   error_reporting(E_ALL);
   define('ROOT', dirname(__DIR__));
   define('DS', DIRECTORY_SEPARATOR);
   require ROOT.DS.'autoload.php';
// Session;
   $sessao = new sessao();
   $usuario = $sessao->get('Gaucho_usuario');
   $id = $sessao->get('Gaucho_id');
   $entidade = $sessao->get('Gaucho_entidade');
   require_once '../xajax/xajax_core/xajax.inc.php';
   $xajax = new xajax();
// $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error.log');
   $xajax->register(XAJAX_FUNCTION, 'Manda_Email');
   $xajax->processRequest();
   $xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <!-- SmartMenus core CSS (required) -->
     <link rel="stylesheet" href="../css/bootstrap.min.css">
     <link rel="stylesheet" href="../css/all.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../css/style4.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>

    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <!--script type="text/javascript" src="js/deal.js"></script -->
    <!-- "sm-blue" menu theme (optional, you can use your own CSS, too) -->
    <?php $xajax->printJavascript('../xajax'); ?>
  </head>

  <body class="opaco">

<!-- Page Content -->
         <div class="container-fluid fundo">
           <div class="row">

        <div class="col-lg-12">
            <h1 class="page-header">Contato
                <small>Apreciamos sua opinião!</small>
            </h1>
        </div>

    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-sm-8">
            <h3>Fale conosco!</h3>

            <form role="form" name="contato" id="contato" method="POST" action="#">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="input1">Nome</label>
                        <input type="text" name="nome" class="form-control" id="input1" value="<?php echo $usuario; ?>">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input2">Email</label>
                        <input type="email" name="email" class="form-control" id="input2">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input3">Telefone</label>
                        <input type="phone" name="telefone" class="form-control" id="input3">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input3">Assunto</label>
                        <input type="phone" name="assunto" class="form-control" id="input3" value="<?php echo $entidade; ?>">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-lg-12">
                        <label for="input4">Mensagem</label>
                        <textarea name="mensagem" class="form-control" rows="6" id="input4"></textarea>
                    </div>
                    <div class="form-group col-lg-12">
                        <input type="hidden" name="save" value="contact">
                        <button type="submit" class="btn btn-primary" onclick="xajax_Manda_Email(xajax.getFormValues('contato')); return false;">Enviar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-4">
            <h3>JGWeb Software </h3>
            <h4>Sistemas Sob Medida</h4>

            <p><i class="fa fa-phone"></i> <abbr title="Fone:">P</abbr>: (+55)54-99947-5408</p>

            <p><i class="fa fa-envelope"></i> <abbr title="Email">E</abbr>: <a
                    href="mailto:joao_goulart@jgoulart.eti.br">joao_goulart@jgoulart.eti.br</a></p>

            <p><i class="fa fa-clock"></i> <abbr title="Horário">H</abbr>: Segunda a Sexta: 8:00 as 17:00</p>
            <ul class="list-unstyled list-inline list-social-icons">
                <li class="tooltip-social twitter-link"><a href="@Jgoulart5628" data-toggle="tooltip"
                                                           data-placement="top" title="Twitter"><i
                        class="fab fa-twitter-square fa-2x"></i></a></li>
                <li class="tooltip-social google-plus-link"><a href="#google-plus-page" data-toggle="tooltip"
                                                               data-placement="top" title="Google+"><i
                        class="fab fa-google-plus-square fa-2x"></i></a></li>
            </ul>
        </div>

    </div>
    <!-- /.row -->

  </div><!-- /.container -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
 </body>
</html>
<?php
  function Manda_Email($dados)  {
    $resp = new xajaxResponse();
    $sql    = $dados['mensagem']; 
    $fone   = $dados['telefone'];
    $assunto = $dados['assunto'];
    //usuario
    $usu    = $dados['nome'];
    //dados da sessao
    $ip    = $_SERVER["REMOTE_ADDR"];

    // montando o texto

    $from     = $dados['email'];
    $to       = "joao_goulart@jgoulart.eti.br, jean.csoares@gmail.com";
    $subj     = $assunto;
    if (!$subj) { $subj = 'Teste de aplicativo'; }

    $body     = '<html><head></head><body>
                   <p>O usuário: '.$usu.'
                   <p>Na Máquina: '.$ip.'
                   <p>No telefone: '.$fone.'
                   <p><b>'.$sql.'</b></body></hmtl>';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= "From: $from ";
    mail($to, $subj, $body, $headers);
    /*
     $from = "joao_goulart@jgoulart.eti.br";
     $to = "goulart.joao@gmail.com";
     $subject = "Checking PHP mail";
     $message = "PHP mail works just fine";
     $headers = "From:" . $from;
     mail($to,$subject,$message, $headers);
     echo "The email message was sent.";
    */
     $resp->alert('Mensagem para : '.$to.' Enviada !'); 
     return $resp;   
}     
