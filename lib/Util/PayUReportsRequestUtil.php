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
use PayU\Util\PayUTokensRequestUtil;
use PayU\Util\PayUSubscriptionsRequestUtil;
use PayU\Util\PayUSubscriptionsUrlResolver;
use PayU\Util\HttpClientUtil;
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
 *
 * Utility class to process parameters and send reports requests
 *
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 29/10/2013
 *
 */

class PayUReportsRequestUtil extends CommonRequestUtil{
	
	
	/**
	 * Build a ping request
	 * @param string $lang language to be used
	 * @return the ping request built
	 */
	static function buildPingRequest($lang=null){
	
		if(!isset($lang)){
			$lang = PayU::$language;
		}
	
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::PING);
	
		return $request;
	}
	
	
	/**
	 * Builds an order details reporting request. The order will be query by id
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 */
	public static function buildOrderReportingDetails($parameters, $lang=null){
		
		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::ORDER_DETAIL);
		
		$orderId = intval(CommonRequestUtil::getParameter($parameters, PayUParameters::ORDER_ID));
		
		
		$request->details = CommonRequestUtil::addMapEntry(null, PayUKeyMapName::ORDER_ID, $orderId); 
		
		return $request;
	}
	
	
	/**
	 * Builds an order details reporting request. The order will be query by reference code
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 * 
	 */
	public static function buildOrderReportingByReferenceCode($parameters, $lang=null) {
	
		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::ORDER_DETAIL_BY_REFERENCE_CODE);
		
		$referenceCode = CommonRequestUtil::getParameter($parameters, PayUParameters::REFERENCE_CODE);
		
		$request->details = CommonRequestUtil::addMapEntry(null, PayUKeyMapName::REFERENCE_CODE, $referenceCode);
	
		return $request;
	}
	

	/**
	 * Builds a transaction reporting request the transaction will be query by id
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The complete reporting request to be sent to the server
	 */
	public static function buildTransactionResponse($parameters, $lang=null) {

		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::TRANSACTION_RESPONSE_DETAIL);
		
		$transactionId = CommonRequestUtil::getParameter($parameters, PayUParameters::TRANSACTION_ID);
		
		$request->details = CommonRequestUtil::addMapEntry(null, PayUKeyMapName::TRANSACTION_ID, $transactionId);
	
		return $request;
	}
	
	
}