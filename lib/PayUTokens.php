<?php

namespace PayU;

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
use PayU\Util\HttpClientUtil;
use PayU\Util\PayUApiServiceUtil;

use PayU\Api\Environment;

use PayU\PayUBankAccounts;
use PayU\PayUPayments;
use PayU\PayUReports;
use PayU\PayUSubscriptions;
use PayU\PayUCustomers;
use PayU\PayUSubscriptionPlans;
use PayU\PayUCreditCards;
use PayU\PayURecurringBill;
use PayU\PayURecurringBillItem;


/**
 * Manages all PayU tokens operations 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 31/10/2013
 *
 */
class PayUTokens{
	
	/**
	 * Creates a credit card token
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function create($parameters, $lang = null){
	
		$required = array(PayUParameters::CREDIT_CARD_NUMBER,
						  PayUParameters::PAYER_NAME,
						  PayUParameters::PAYMENT_METHOD,
						  PayUParameters::PAYER_ID,
						  PayUParameters::CREDIT_CARD_EXPIRATION_DATE);
		
		CommonRequestUtil::validateParameters($parameters, $required);		
		
		$request = PayUTokensRequestUtil::buildCreateTokenRequest($parameters,$lang);
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::PAYMENTS_API, RequestMethod::POST);
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
	}
	
	
	/**
	 * Finds a credit card token
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function find($parameters, $lang = null){
		
		$tokenId = CommonRequestUtil::getParameter($parameters, PayUParameters::TOKEN_ID);
		$required = null;
		
		if($tokenId == null){
			$required = array(PayUParameters::START_DATE, PayUParameters::END_DATE);
		}else{
			$required = array(PayUParameters::TOKEN_ID);
		}
	
		CommonRequestUtil::validateParameters($parameters, $required);
		
		$request = PayUTokensRequestUtil::buildGetCreditCardTokensRequest($parameters,$lang);
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::PAYMENTS_API,RequestMethod::POST);
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
	}
	
	/**
	 * Removes a credit card token
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function remove($parameters, $lang=null){
		
		$required = array(PayUParameters::TOKEN_ID,
							PayUParameters::PAYER_ID);
		
		CommonRequestUtil::validateParameters($parameters, $required);
		
		$request = PayUTokensRequestUtil::buildRemoveTokenRequest($parameters,$lang);
		
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::PAYMENTS_API,RequestMethod::POST);
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
	}
	
}