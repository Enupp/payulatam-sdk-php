<?php

namespace PayU\Exceptions;

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
use PayU\PayU;


/**
 * 
 * Contains the error codes  used in exceptions
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0
 * 
 */
class PayUErrorCodes{
	
	/** json serialization error */
	const JSON_SERIALIZATION_ERROR = 'JSON_SERIALIZATION_ERROR';
	
	/** json deserialization error */
	const JSON_DESERIALIZATION_ERROR= 'JSON_DESERIALIZATION_ERROR';
	
	/** invalid parameters for build request */
	const INVALID_PARAMETERS= 'INVALID_PARAMETERS';
	
	/** connection error */
	const CONNECTION_EXCEPTION= 'CONNECTION_EXCEPTION';
	
	/** general api error */
	const API_ERROR= 'API_ERROR';
}