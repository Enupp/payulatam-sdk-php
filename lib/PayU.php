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
use PayU\PayUTokens;
use PayU\PayUSubscriptions;
use PayU\PayUCustomers;
use PayU\PayUSubscriptionPlans;
use PayU\PayUCreditCards;
use PayU\PayURecurringBill;
use PayU\PayURecurringBillItem;


/**
 *
 * Holds basic request information
 * 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 20/10/2013
 *
 */
abstract class PayU {
	
	/**
	 * Api version
	 */
	const  API_VERSION = "4.0.1";

	/**
	 * Api name
	 */
	const  API_NAME = "PayU SDK";
	
	
	const API_CODE_NAME = "PAYU_SDK";

	/**
	 * The method invocation is for testing purposes
	 */
	public static $isTest = false;

	/**
	 * The merchant API key
	 */
	public static  $apiKey = null;

	/**
	 * The merchant API Login
	 */
	public static  $apiLogin = null;

	/**
	 * The merchant Id
	 */
	public static  $merchantId = null;

	/**
	 * The request language
	 */
	public static $language = SupportedLanguages::ES;
	

}


/** validates Environment before begin any operation */
Environment::validate();
