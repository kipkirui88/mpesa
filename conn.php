<?php 

function insert_response($jsonMpesaResponse){
try{
    $con = new PDO("mysql:dbhost=localhost;dbname=mpesa", 'root', '');
    echo "Connection was successful";
}
catch(PDOException $e){
    die("Error Connecting ".$e->getMessage());
}

try{
    $insert = $con->prepare("INSERT INTO `deposit`(`TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, 
    `BillRelNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`)
    VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRelNumber, :InvoiceNumber, :OrgAccountBalance, 
    :ThirdPartyTransID, :MSISDN, :FirstName)");
    $insert->execute((array)($jsonMpesaResponse));

    $Transaction = fopen('error.txt', 'a');
    fwrite($Transaction, json_encode($jsonMpesaResponse));
    fclose(($Transaction));
}
catch(PDOException $e){
    $errlog = fopen('error.txt', 'a');
    fwrite($errlog, $e->getMessage());
    fclose(($errlog));

    $logFailedTransaction = fopen('failedTransaction.txt', 'a');
    fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
    fclose($logFailedTransaction);
}
}
?>