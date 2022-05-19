<?php
    $intento = 4;
    echo "------------------------iniciando $intento------------------------"."<br>";

    require_once("lib/class.imap.php");

    $email = new Imap();


    $inbox = null;

    if($email->connect(
        '{mail.neumatruck.cl:143/notls}INBOX',
        'contacto@neumatruck.cl',
        '7340458Tao'
    )){
        // * inbox son los datos del correo
        // ! se debe descargar el archivo adjunto
        // ? se debe realizar lo urgente
        //  TODO 
        
        $inbox = $email->getMessages("html");
      
        // echo $documents;

    }
    // * $body es ela vairab le con el correo 
    // 
    
    $selector = 2;

    $id = $inbox["data"][$selector]["uid"];
    $body = $inbox["data"][$selector]["message"];
    $attachments = $inbox["data"][$selector]["attachments"];
    $file = $inbox["data"][$selector]["attachments"][0]["file"];
    $file2 = $inbox["data"][$selector]["attachments"][1]["file"];
    $file3 = $inbox["data"][$selector]["attachments"][2]["file"];

    echo $id.'<br>';
    echo $file.'<br>';
    echo $file2.'<br>';
    echo $file3.'<br>';

    echo '<a href="attachments/'.$file.'">var uno</a><br>';
    echo '<a href="'.$file2.'">var do</a><br>';

    $url = "{mail.neumatruck.cl:993/imap/ssl/novalidate-cert}INBOX";
    $id = "contacto@neumatruck.cl";
    $pwd = "7340458Tao";
    $imap = imap_open($url, $id, $pwd);

     $mailbox = imap_open ("{correo.servidor.com:993/imap/ssl/novalidate-cert}INBOX", "correo@usuario.com", "PASSWORD");

    if (!$mailbox){
        die('murio');
    }

    echo "<h1>Buzones</h1>\n";
    $carpetas = imap_listmailbox($mailbox, "{correo.patronato.unam.mx:993}", "*");

    if ($carpetas == false) {
        echo "Llamada fallida<br />\n";
    } else {
        foreach ($carpetas as $val) {
            echo $val . "<br />\n";
        }
    }

    echo "<h1>Cabeceras en INBOX</h1>\n";
    $cabeceras = imap_headers($mailbox);

    if ($cabeceras == false) {
        echo "Llamada fallida<br />\n";
    } else {
        foreach ($cabeceras as $val) {
            echo $val . "<br />\n";
        }
    }



    $numMessages = imap_num_msg($mailbox);
    for ($i = $numMessages; $i > 0; $i--) {
        $header = imap_header($mailbox, $i);

        $fromInfo = $header->from[0];
        $replyInfo = $header->reply_to[0];

        // print_r($header);

        $details = array(
            "fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
                ? $fromInfo->mailbox . "@" . $fromInfo->host : "",
            "fromName" => (isset($fromInfo->personal))
                ? $fromInfo->personal : "",
            "replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
                ? $replyInfo->mailbox . "@" . $replyInfo->host : "",
            "replyName" => (isset($replyTo->personal))
                ? $replyto->personal : "",
            "subject" => (isset($header->subject))
                ? $header->subject : "",
            "udate" => (isset($header->udate))
                ? $header->udate : "",
            "Unseen" => (isset($header->Unseen))
                ? $header->Unseen  : "-"
        );
        $uid = imap_uid($mailbox, $i);

        echo "<ul>";
        echo "<li><strong>From:</strong>" . $details["fromName"];
        echo " " . $details["fromAddr"] . "</li>";
        echo "<li><strong>Subject:</strong> " . $details["subject"] . "</li>";
        echo "<li><strong>Estatus:</strong> " . $details["Unseen"] . "</li>";
        echo '<li><a href="test_imap_attachment.php?folder=' . $folder . '&uid=' . $i . '">Read</a></li>';
        echo "</ul>";
    }


    imap_close($mailbox);

    // --------------------------------------------------


    $mailbox = imap_open ("{mail.neumatruck.cl:993/imap/ssl/novalidate-cert}INBOX", "contacto@neumatruck.cl", "7340458Tao");

    if (!$mailbox){
        die('murio');
    }

    echo "<h1>Buzones</h1>\n";
    $carpetas = imap_listmailbox($mailbox, "{mail.neumatruck.cl:993}", "*");

    if ($carpetas == false) {
        echo "Llamada fallida<br />\n";
    } else {
        foreach ($carpetas as $val) {
            echo $val . "<br />\n";
        }
    }

    echo "<h1>Cabeceras en INBOX</h1>\n";
    $cabeceras = imap_headers($mailbox);

    if ($cabeceras == false) {
        echo "Llamada fallida<br />\n";
    } else {
        foreach ($cabeceras as $val) {
            echo $val . "<br />\n";
        }
    }



    $numMessages = imap_num_msg($mailbox);
    for ($i = $numMessages; $i > 0; $i--) {
        $header = imap_header($mailbox, $i);

        $fromInfo = $header->from[0];
        $replyInfo = $header->reply_to[0];

        // print_r($header);

        $details = array(
            "fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
                ? $fromInfo->mailbox . "@" . $fromInfo->host : "",
            "fromName" => (isset($fromInfo->personal))
                ? $fromInfo->personal : "",
            "replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
                ? $replyInfo->mailbox . "@" . $replyInfo->host : "",
            "replyName" => (isset($replyTo->personal))
                ? $replyto->personal : "",
            "subject" => (isset($header->subject))
                ? $header->subject : "",
            "udate" => (isset($header->udate))
                ? $header->udate : "",
            "Unseen" => (isset($header->Unseen))
                ? $header->Unseen  : "-"
        );
        $uid = imap_uid($mailbox, $i);

        echo "<ul>";
        echo "<li><strong>From:</strong>" . $details["fromName"];
        echo " " . $details["fromAddr"] . "</li>";
        echo "<li><strong>Subject:</strong> " . $details["subject"] . "</li>";
        echo "<li><strong>Estatus:</strong> " . $details["Unseen"] . "</li>";
        echo '<li><a href="test_imap_attachment.php?folder=' . $folder . '&uid=' . $i . '">Read</a></li>';
        echo "</ul>";
    }


    imap_close($mailbox);


    echo "------------------------finish $intento---------------------";

?>


<!DOCTYPE html>
<!-- Bootstrap -->
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet">
<!-- dataTables -->
<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
body {
	padding: 20px 10px 20px 10px
}
</style>

<script async defer src="https://buttons.github.io/buttons.js"></script>


<!-- Modal message -->		
<div id="addModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Message</h4>
       </div>
       <div class="modal-body" id="message">
         
       </div>
     </div>
   </div>
</div>

<!-- jQuery -->
<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<!-- Bootstrap -->
<!-- dataTables -->
<!-- loading-overlay -->
<script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
<script>		

	var json;
    let parametros = {"inbox":""};
	// $.LoadingOverlay("show");
    console.log("iniciando el ajax")
    $.ajax({
        data: parametros,
        type: "POST",
        url:  "json.php", 
        beforeSend:function(){
           
        },
        success:function(response){
            console.log(response);
        }
    });
	console.log("termindo el ajax")
</script>
<!-- https://www.youtube.com/watch?v=xFQxTB0awiU&t=332s -->
<!-- url de test -->
<!-- http://emailimap.neumatruck.cl/ -->