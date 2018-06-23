<?php
if(isset($_POST['Enviar']) and ($_POST['Enviar']=='Enviar'))
{
  $facebook_id = $_POST['facebook_id'];
  	//----------------------------------------------------------------------------
    //GET graph.facebook.com/20531316728  getResponse
  /*
    $vRequest = new HttpRequest('https://graph.facebook.com/20531316728', HttpRequest::METH_GET);
    try {
        $vRequest->send();
        if ($vRequest->getResponseCode() == 200) {
          echo "envio";
          echo $vRequest->getResponseBody();
        }
    } catch (HttpException $ex) {
        echo $ex;
    }
   */
  /*
    $opciones = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n" .
                  "Cookie: foo=bar\r\n"
      )
    );

    $contexto = stream_context_create($opciones);
  */
    //----------------------------------------------------------------------------
    /* Ejemplo ubicado en https://www.teletopiasms.no/np/frontpage/gateway/api-http-examples-php
    $url = 'http://api1.teletopiasms.no/httpbridge2/';

	$context = stream_context_create(array(
	    'http' => array(
	        'method' => 'POST',
	        'header' => 'Content-type: application/x-www-form-urlencoded',
	        'content' => http_build_query(
	            array(
	                'auth' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
	                'to' => '47xxxxxxxx',
	                'from' => '2105',
	                'type' => 'text',
	                'data' => utf8_encode('Hello, world! (æøåÆØÅ)'),
	                'price' => 0
	            )
	        ),
	        'timeout' => 60
	    )
	));

	$resp = file_get_contents($url, FALSE, $context);
	print_r($resp);
	*/

	/* ----------------------------------------------------------------------------
    $url = 'https://graph.facebook.com/20531316728';
    $opciones = array(
	    'http' => array(
	        'header' => 'Content-type: application/x-www-form-urlencoded',
	        'method' => 'GET'
	    )
	);

	$context = stream_context_create($opciones);

	$resp = file_get_contents($url, FALSE, $context);
	print_r($resp);
	---------------------------------------------------------------------------- */
	function http_post($url){
        $postdata = array();

        if(strpos($url,"?") !== FALSE){
            $qsr = array();
            $url_r = explode("?", $url);
            $url = $url_r[0];
            parse_str($url_r[1], $qsr);
            $postdata = http_build_query($qsr);
        }

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);
        $output = @file_get_contents($url, false, $context);

        if( ( $output === FALSE ) || ( empty($output) ) ) {
            if (function_exists('curl_init')){ 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close ($ch);
            }
        }
        return $output;
    }

    $output = http_post("https://graph.facebook.com/20531316728");
    print_r($output);
    echo $output;

}
?>
<!DOCTYPE html>
<html  lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Aivo - Test - Recuperar Facebook</title>    
    <style>
      th, #facebook_id
      {
        border-style: solid; 
        border-width: 1px; 
        padding: 5px 5px 5px 5px;
        width:300px;
      }
      td
      {
        padding: 5px 5px 5px 5px;
      }
      .main-footer 
      {
        background: #fff;
        padding: 15px;
        color: #444;
        border-top: 1px solid #d2d6de;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 40px;
      }
    </style>
  </head>
  <body><br><br>
  	<center>
      <h1>Recuperar Perfil de Facebook</h1>
  	  <form action='' method='POST' name='form_facebook_id' id='form_facebook_id' enctype='multipart/form-data' >
        <table>
          <tr>
            <th>
              ID de Facebook
            </th>
          </tr>
          <tr>
            <th>
              <input type="text" name='facebook_id' id='facebook_id' required="required" title='Introduzca el Identificador de Facebook a recuperar'>
            </th>
          </tr>
          <tr>
            <td style='text-align: right;'>
              <input type='submit' name='Enviar' id='Enviar' value='Enviar'>
            </td>  
          </tr>
        </table>
  	  </form>
      <div id="demo"></div>
      <footer class='main-footer'> <p>&copy; <?php echo date('Y'); ?> Raul Osuna / Email: raulosuna2015@gmail.com</p></footer>
  	</center>
    <script type="text/javascript">
      // onsubmit="event.preventDefault(); find();"
      function find(){
        var oForm = document.getElementById('form_facebook_id');
        var txt = "";
        var i;
        for (i = 0; i < oForm.length; i++) {
            txt = txt + oForm.elements[i].name + "=" + oForm.elements[i].value + "&";
        }
        var res = txt.substr(0, txt.length - 1);
        document.getElementById("demo").innerHTML = res;
      }
    </script>
  </body>
</html>
