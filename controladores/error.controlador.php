<?php 

function errores( $error, $mensaje, $fichero, $linea ) {
    echo "<b>: :ERROR: :</b><br/>" ;
    echo "Sentimos comunicarle que se ha producido un error";
    echo "Tipo de error: $error: $mensaje en $fichero en la línea $linea";

}

function error( $numero, $texto ){
    // Grabado Log
    $ddf = fopen( 'error.log', 'a' );
    fwrite($ddf,"[".date("r")."] Error $numero: $texto\r\n");
    fclose($ddf);
}

function gestorErrores( $númerr, $menserr, $nombrearchivo, $númlínea, $vars ) 
{
    // marca de tiempo para la entrada del error
    $fh = date("Y-m-d H:i:s (T)");

    // definir una matriz asociativa de cadena de error
    // en realidad las únicas entradas que deberíamos
    // considerar son E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING y E_USER_NOTICE
    $tipoerror = array (
                E_ERROR              => 'Error',
                E_WARNING            => 'Warning',
                E_PARSE              => 'Parsing Error',
                E_NOTICE             => 'Notice',
                E_CORE_ERROR         => 'Core Error',
                E_CORE_WARNING       => 'Core Warning',
                E_COMPILE_ERROR      => 'Compile Error',
                E_COMPILE_WARNING    => 'Compile Warning',
                E_USER_ERROR         => 'User Error',
                E_USER_WARNING       => 'User Warning',
                E_USER_NOTICE        => 'User Notice',
                E_STRICT             => 'Runtime Notice',
                E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
                );
    // conjunto de errores por el cuál se guardará un seguimiento de una variable
    $errores_usuario = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
    
    $err = "<errorentry>\n";
    $err .= "\t<datetime>" . $fh . "</datetime>\n";
    $err .= "\t<errornum>" . $númerr . "</errornum>\n";
    $err .= "\t<errortype>" . $tipoerror[$númerr] . "</errortype>\n";
    $err .= "\t<errormsg>" . $menserr . "</errormsg>\n";
    $err .= "\t<scriptname>" . $nombrearchivo . "</scriptname>\n";
    $err .= "\t<scriptlinenum>" . $númlínea . "</scriptlinenum>\n";

    if (in_array($númerr, $errores_usuario)) {
        // $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
        $err .= "\t<vartrace>" . $vars . "</vartrace>\n";
    }
    $err .= "</errorentry>\n\n";
    
    // para probar
    // echo $err;

    // guardar al registro de errores, y enviarme un e-mail si hay un error crítico de usuario
    error_log($err, 3, "error.log");
    if ($númerr == E_USER_ERROR) {
        mail("soporte@reportsystem.com.ar", "Error Crítico de Usuario", $err);
    }
}
