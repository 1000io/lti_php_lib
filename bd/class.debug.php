<?php
//Mostramos proceso LTI
if ($lti_success) {
    echo '<p>Conexión válida</p>';
    if ($resource) {
            echo '<p>El recurso existe</p>';
            echo '<pre>';
            var_dump($resource);        
            echo '</pre>';
    } else {
         echo '<p>El recurso existe NO existe</p>';
         if ($resource_new) {
            echo '<pre>';
            echo '<p>Recurso creado</p>';
            var_dump($resource);
            echo '</pre>';
         }
    }
    echo '<p>El número máximo de conexiones LTI es de '.$lms['lms_max_resources'].' y hay un total de '.$total_resources.'</p>';    
    if ($user) {
            echo '<p>El usuario existe</p>';
            echo '<pre>';
            var_dump($user);        
            echo '</pre>';
    } else {
        echo '<p>El usuario NO existe</p>';
         if ($user_new) {
            echo '<p>Usuario creado</p>';
            echo '<pre>';
            var_dump($user);
            echo '</pre>';
         }
    }    
    if ($user_resource) {
            echo '<p>El usuario existe en el recurso</p>';
            echo '<pre>';
            var_dump($user_resource);        
            echo '</pre>';
    } else {
        echo '<p>El usuario NO existe en el recurso</p>';
         if ($user_resource_new) {
            echo '<p>Usuario creado en el recurso</p>';
            echo '<pre>';
            var_dump($user_resource);
            echo '</pre>';
         }
    }
    if (!$found) {
        echo '<p>NO hay servicios disponibles</p>';
    }
} else if ($context->valid && !$lti_active) {
    echo '<p>La conexión NO está activa</p>';
} else {
    echo '<p>Conexión NO permitida</p>';
}

//Información de contexto
if ($lti_success) {    
    echo '<p>Context Information</p>';
    echo '<pre>';
    echo htmlent_utf8($context->dump());
    echo '</pre>';
}

//Mostramos todos los valores
echo '<p>Base String:</p>';
echo '</pre>';
echo htmlent_utf8($context->basestring);
echo '</pre>';

//Variables del POST
echo '<p>Raw POST Parameters:</p>';
ksort($_POST);
echo '<pre>';
foreach($_POST as $key => $value ) {
    if (get_magic_quotes_gpc()) $value = stripslashes($value);
    echo htmlent_utf8($key) . "=" . htmlent_utf8($value) . " (".mb_detect_encoding($value).")</br>";
}
echo '</pre>';

//Variables del GET
echo '<p>Raw GET Parameters:</p>';
ksort($_GET);
echo '<pre>';
foreach($_GET as $key => $value ) {
    if (get_magic_quotes_gpc()) $value = stripslashes($value);
    echo htmlent_utf8($key) . "=" . htmlent_utf8($value) . " (".mb_detect_encoding($value).")</br>";
}
echo '</pre>';