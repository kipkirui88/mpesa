<?php

include 'conn.php';
 		header("Content-Type: application/json");

     $response = '{
         "ResultCode": 0, 
         "ResultDesc": "Confirmation Received Successfully"
     }';
 
     // DATA
     $mpesaResponse = file_get_contents('php://input');
 
     // log the response
     $logFile = "M_PESAConfirmationResponse.txt";

     $jsonMpesaResponse = json_decode($mpesaResponse, true);

     $transaction = array(
            `:TransactionType` => $jsonMpesaResponse['TransactionType'],
            `:TransID` => $jsonMpesaResponse['TransID'],
            `:TransTime`=> $jsonMpesaResponse['TransTime'],
            `:TransAmount`=> $jsonMpesaResponse['TransAmount'],
            `:BusinessShortCode`=> $jsonMpesaResponse['BusinessShortCode'], 
            `:BillRelNumber`=> $jsonMpesaResponse['BillRelNumber'],
            `:InvoiceNumber`=> $jsonMpesaResponse['InvoiceNumber'],
            `:OrgAccountBalance`=> $jsonMpesaResponse['OrgAccountBalance'],
            `:ThirdPartyTransID`=> $jsonMpesaResponse['ThirdPartyTransID'],
            `:MSISDN`=> $jsonMpesaResponse['MSISDN'], 
            `:FirstName`=> $jsonMpesaResponse['FirstName']
     );
 
     // write to file
     $log = fopen($logFile, "a");
 
     fwrite($log, $mpesaResponse);
     fclose($log);
 
     echo $response;
     insert_response($transaction)


?>     
