<?php

function bd_lms_exist($key) {
    $DB = new DBPDO();
    $lms = $DB->fetch("SELECT * FROM lms WHERE lms_key = '$key'");
    if ($lms <> false) {
        return $lms;
    } else return false;
}

function bd_resource_total($lms) {
    $DB = new DBPDO();
    $total = $DB->fetch("SELECT COUNT(resource_id) as total FROM resources WHERE resource_lms_id = '".$lms['lms_id']."'");
    if ($total <> false) {
        return $total['total'];
    } else return false;
}

function bd_resource_exist($lms,$context) {
    $lms_id = $lms['lms_id'];
    $resource_link_id = $context->getResourceLKey();    
    $DB = new DBPDO();    
    $resource = $DB->fetch("SELECT * FROM resources WHERE resource_link_id = '$resource_link_id' and resource_lms_id = $lms_id");
    //var_dump($resource);
    if ($resource <> false) {
        return $resource;
    } else return false;
}

function bd_resource_create($lms,$context) {
    $vars['resource_lms_id']        = $lms['lms_id'];
    $vars['resource_link_id']       = $context->getResourceLKey();
    $vars['resource_name']          = $context->getResourceTitle();
    $vars['resource_grade_url']     = $context->getResourceGradeURL();
    $vars['resource_grade_basic']   = $context->isReourceGradeBasic();
    $vars['resource_active']        = true;
    $query = "INSERT INTO `resources` SET ";
        foreach($vars as $key=>$value){
            $query .= "`{$key}` = '{$value}', ";
        }
    $query = trim($query, ', ');
    $DB = new DBPDO();
    $DB->execute($query);
    //Agregamos el índice del recurso que acabamos de crear
    $vars['resource_id'] = $DB->lastInsertId();
    return $vars;
}

function bd_user_exist($lms,$context) {
    $user_id_lms = $lms['lms_id'];
    $user_id_user_lms = $context->getUserLKey();
    $DB = new DBPDO();    
    $user = $DB->fetch("SELECT * FROM users WHERE user_id_user_lms = '$user_id_user_lms' and user_id_lms = $user_id_lms");
    //var_dump($user);
    if ($user <> false) {
        return $user;
    } else return false;
}

function bd_user_create($lms,$context) {
    $vars['user_id_lms']        = $lms['lms_id'];
    $vars['user_id_user_lms']   = $context->getUserLKey();
    $vars['user_email']         = $context->getUserEmail();
    $vars['user_name']          = $context->getUserName();
    $vars['user_lastname']      = $context->getUserLastname();
    $vars['user_active']        = true;
    $query = "INSERT INTO `users` SET ";
        foreach($vars as $key=>$value){
            $query .= "`{$key}` = '{$value}', ";
        }
    $query = trim($query, ', ');
    $DB = new DBPDO();
    $DB->execute($query);
    //Agregamos el índice del recurso que acabamos de crear
    $vars['user_id'] = $DB->lastInsertId();
    return $vars;    
}

function bd_user_resource_exist($user,$resource) {
    $user_id = $user['user_id'];
    $resource_id = $resource['resource_id'];
    $DB = new DBPDO();    
    $user_resource = $DB->fetch("SELECT * FROM users_resources WHERE ur_user_id = '$user_id' and ur_resource_id = $resource_id");
    //var_dump($user_resource);
    if ($user_resource <> false) {
        return $user_resource;
    } else return false;    
}

function bd_user_resource_create($lms,$context,$user,$resource) {
    $vars['ur_user_id']             = $user['user_id'];
    $vars['ur_resource_id']         = $resource['resource_id'];
    $vars['ur_user_instructor']     = $context->isInstructor();
    $vars['ur_user_grade_sourcedid']= $context->getUserResultSourceId();
    $vars['ur_active']              = true;
    $query = "INSERT INTO `users_resources` SET ";
        foreach($vars as $key=>$value){
            $query .= "`{$key}` = '{$value}', ";
        }
    $query = trim($query, ', ');
    $DB = new DBPDO();
    $DB->execute($query);
    //Agregamos el índice del recurso que acabamos de crear
    $vars['ur_id'] = $DB->lastInsertId();
    return $vars;    
}