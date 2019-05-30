<?php

namespace PayU\Api;

use PayU\Api\SupportedLanguages;
use PayU\Api\PayUKeyMapName;
use PayU\Api\PayUCommands;
use PayU\Api\PayUTransactionResponseCode;
use PayU\Api\PayUHttpRequestInfo;
use PayU\Api\PayUResponseCode;
use PayU\Api\PayuPaymentMethodType;
use PayU\Api\PaymentMethods;
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
 * Class contains payments countries in the PayU SDK. Sometimes when a payment
 * method is processed by several countries is necessary to specify the country
 * due currency issues.
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0,, 29/10/2013
 */
class PayUCountries{

	/**
	 * When the payment country is Argentina.
	 */
	const AR = 'AR';
	/**
	 * When the payment country is Brazil.
	 */
	const BR = 'BR';
	/**
	 * When the payment country is Chile.
	 */
	const CL = 'CL';
	/**
	 * When the payment country is Colombia.
	 */
	const CO = 'CO';
	/**
	 * When the payment country is Mexico.
	 */
	const MX = 'MX';
	
	/**
	 * When the payment country is Panama.
	 */
	const PA = 'PA';
	/**
	 * When the payment country is Peru.
	 */
	const PE = 'PE';
	
	/**
	 * When the payment country is United States.
	 */
	const US = 'US';
	

}
