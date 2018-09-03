<?php
// Server in the this format: <computer>\<instance name> or 
// <server>,<port> when using a non default port number

if(isset($_POST['carrera'])){
    return generateFolio();
}

function getConnection(){
    $server ="(local)";
    $connectionInfo = array( "Database"=>"ingweb");

    // Connect to MSSQL
    $conn = sqlsrv_connect($server, $connectionInfo);
    if (!$conn) {
        echo  json_encode(sqlsrv_errors());
    }
    return $conn;
}

function generateFolio(){
    $conn= getConnection();
    $sp = "{call updateControl(?,?)}";
    $carrera = $_POST['carrera'];
    $folio=0;
    $params = array(
        array($carrera, SQLSRV_PARAM_IN),
        array(&$folio, SQLSRV_PARAM_OUT)
    );
    $stm = sqlsrv_query($conn, $sp, $params);
    sqlsrv_next_result($stm);
    if($stm===false){
        print "Error";
        echo  json_encode(sqlsrv_errors());
    }

    echo $params[1][0];
    sqlsrv_close( $conn);  
    return $folio;
}

?>
