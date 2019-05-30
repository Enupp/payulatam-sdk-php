<?php

namespace PayU\Util;

use PayU\Api\SupportedLanguages;
use PayU\Api\PayUKeyMapName;
use PayU\Api\PayUCommands;
use PayU\Api\PayUTransactionResponseCode;
use PayU\Api\PayUHttpRequestInfo;
use PayU\Api\PayUResponseCode;
use PayU\Api\PayuPaymentMethodType;
use PayU\Api\PaymentMethods;
use PayU\Api\PayUCountries;
use PayU\Exceptions\PayUErrorCodes;
use PayU\Exceptions\PayUException;
use PayU\Exceptions\ConnectionException;
use PayU\Api\PayUConfig;
use PayU\Api\RequestMethod;
use PayU\Util\SignatureUtil;
use PayU\Api\TransactionType;
use PayU\Util\PayURequestObjectUtil;
use PayU\Util\PayUParameters;
use PayU\Util\CommonRequestUtil;
use PayU\Util\RequestPaymentsUtil;
use PayU\Util\UrlResolver;
use PayU\Util\PayUReportsRequestUtil;
use PayU\Util\PayUTokensRequestUtil;
use PayU\Util\PayUSubscriptionsRequestUtil;
use PayU\Util\PayUSubscriptionsUrlResolver;
use PayU\Util\PayUApiServiceUtil;

use PayU\Api\Environment;

use PayU\PayUBankAccounts;
use PayU\PayUPayments;
use PayU\PayUReports;
use PayU\PayUTokens;
use PayU\PayUSubscriptions;
use PayU\PayUCustomers;
use PayU\PayUSubscriptionPlans;
use PayU\PayUCreditCards;
use PayU\PayURecurringBill;
use PayU\PayURecurringBillItem;
use PayU\PayU;


/**
 * Utility class for send http request
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0
*/
class HttpClientUtil {
	
	
	const CONTENT_TYPE = 'Content-Type: application/json; charset=UTF-8';
	
	const ACCEPT = 'Accept: application/json';
	
	const CONTENT_LENGTH =  'Content-Length: ';
	
	const ACCEPT_LANGUAGE = 'Accept-Language: ';
	
	/**
	 * Sends a request type json
	 * @param Object $request this object is encode to json is used to request data
	 * @param PayUHttpRequestInfo $payUHttpRequestInfo object with info to send an api request
	 * @return string response
	 * @throws RuntimeException
	 */
	static function sendRequest($request, PayUHttpRequestInfo $payUHttpRequestInfo){
		
		$httpHeader = array(
		HttpClientUtil::CONTENT_TYPE,
		HttpClientUtil::CONTENT_LENGTH . strlen($request),
		HttpClientUtil::ACCEPT);
		if((isset($payUHttpRequestInfo->lang))){
			array_push($httpHeader,HttpClientUtil::ACCEPT_LANGUAGE . '$payUHttpRequestInfo->lang');
		}
		
		
		$curl = curl_init($payUHttpRequestInfo->getUrl());
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $payUHttpRequestInfo->method);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER,$httpHeader);
		
		if(isset($payUHttpRequestInfo->user) && isset ($payUHttpRequestInfo->password)){
			curl_setopt($curl, CURLOPT_USERPWD, $payUHttpRequestInfo->user . ":" . $payUHttpRequestInfo->password);
		}
		
		$curlResponse = curl_exec($curl);
		
		$httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		if($curlResponse === false && $httpStatus === 0){
			throw new ConnectionException(PayUErrorCodes::CONNECTION_EXCEPTION, 'the url [' . $payUHttpRequestInfo->getUrl() . '] did not respond');
		}
		
 		if ($curlResponse === false) {
 			$requestInfo = http_build_query(curl_getinfo($curl), ' ', ',');
 			$curlMsgError = sprintf(" error occured during curl exec info: curl message[%s], curl error code [%s], curl request details [%s]", 
 					curl_error($curl), curl_errno($curl), $requestInfo);
			
 			curl_close($curl);
 			throw new RuntimeException($curlMsgError);
 		}
		
		curl_close($curl);
		
		if(empty($curlResponse)){
			return $httpStatus;
		}else{
			return $curlResponse;
		}
		
	}
	
}