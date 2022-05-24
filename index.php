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
    // $file3 = $inbox["data"][$selector]["attachments"][2]["file"];

    echo $id.'<br>';
    echo $file.'<br>';
    echo $file2.'<br>';
    // echo $file3.'<br>';

    echo '<a href="attachments/'.$file.'">var uno</a><br>';
    echo '<a href="'.$file2.'">var do</a><br>';


    // imap_close($email);

    echo "------------------------finish $intento---------------------";


    echo "------------------------second intento---------------------"."<br>";

    // set_time_limit(3000);


    $hostname = '{mail.neumatruck.cl:993/novalidate-cert/imap/ssl}';
    // $hostname = '{mail.neumatruck.cl:110/pop3}';
    // $hostname = '{mail.neumatruck.cl:993/ssl}INBOX';
    // $hostname = '{mail.neumatruck.cl:143/notls}INBOX';
    $username = 'contacto@neumatruck.cl';
    $password = '7340458Tao';

    $inbox = imap_open($hostname, $username, $password) or die("imposible realizar conexion".imap_last_error());

    $emails = imap_search($inbox, 'FROM "Rodrigo.Jara@cl.kghm.com"');

    if($emails){
        $count = 1;
        rsort($emails);

        foreach ($emails as $emails_number) {
            
            $overview = imap_fetchbody($inbox, $emails_number, 2);

            $structure = imap_fetchstructure($inbox, $emails_number);

            $attachments = array();

            if(isset($structure->parts) && count($structure->parts)){
                for ($i=0; $i < count($structure->parts) ; $i++) { 
                    $attachments[$i] = array(
                        'is_attachment' => false,
                        'filname' => '',
                        'name' => '',
                        'attachment' => ''
                    );

                    if($structure->parts[$i]->ifdparameters){
                        foreach ($structure->parts[$i]->dparameters as $object) {
                            if(strtolower($object->attribute) == 'filename'){
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['filename'] = $object->value;
                            }
                        }
                    }

                    if($structure->parts[$i]->ifparameters){
                        foreach ($structure->parts[$i]->parameters as $object) {
                            if(strtolower($object->attribute) == 'name'){
                                $attachments[$i]["is_attachment"] = true;
                                $attachments[$i]["name"] = $object->value;
                            }
                        }
                    }

                    if($attachments[$i]["is_attachment"]){
                        $attachments[$i]['attachment'] = imap_fetchbody($inbox, $emails_number, $i+1);
                        // ? base de encoding BASE64
                        if($structure->parts[$i]->encoding == 3){
                            $attachments[$i]["attachment"] = base64_decode($attachments[$i]["attachment"]);
                        }
                        elseif ($structure->parts[$i]->encoding == 4) {
                            $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                        }

                    }

                  


                }
            }

            foreach ($attachments as $attachment) {
                if($attachment["is_attachment"] ==  1){
                    $filename = $attachment['name'];

                    if(empty($filename)) $filename = $attachment['filename'];

                    if(empty($filename)) $filename = time().'.dat';
                    $folder = "attachment";

                    if(!is_dir($folder)){
                        mkdir($folder);
                    }

                    $fp = fopen("./".$folder."/".$emails_number."-".$filename, "w+");

                    fwrite($fp, $attachment['attachment']);

                    fclose($fp);

                }
            }

        }

    }

    // * close conexion
    
    imap_close($inbox);

    echo "all attachment downloades"."<br>";


    echo "------------------------end intento---------------------"."<br>";

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