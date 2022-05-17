<?php
    $intento = 4;
    echo "------------------------iniciando $intento------------------------"."<br>";

    require_once("lib/class.imap.php");

    $email = new Imap();


    $intxo = null;

    if($email->connect(
        '{mail.neumatruck.cl:143/notls}INBOX',
        'contacto@neumatruck.cl',
        '7340458Tao'
    )){

        $inbox = $email->getMessages("html");

    }
     
    echo getType($inbox);

    echo '<pre>';
    print_r($inbox);
    echo '------------<pre>';

   


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

<div class="container">
	<div class="row">
		<div class="col-md-12"> 
			<h3 align="center">Email Inbox <a href="mailto:hello@bachors.com">hello@bachors.com</a></h3>
			<a class="github-button" href="https://github.com/bachors/Email-Inbox-IMAP" data-icon="octicon-cloud-download" data-size="large" aria-label="Download bachors/Email-Inbox-IMAP on GitHub">Download</a>
			<hr>

			<table id="myTable" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Subject</th>
						<th>Name</th>
						<th>Email</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody id="inbox">

				</tbody>
			</table>
				
		</div>					
	</div>					
</div>

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