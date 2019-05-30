<?php

namespace PayU\Api;

use PayU\Api\SupportedLanguages;
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
 * Contains the attribute name for the differents operation against api
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 17/10/2013
 *
 */
class PayUKeyMapName{
	
	/** property name to the the transaction  value */ 
	const TX_VALUE = "TX_VALUE";
	
	/** property name for the the transaction  tax */
	const TX_TAX = "TX_TAX";
	
	/** property name to the the transaction  tax return base */
	const TX_TAX_RETURN_BASE = "TX_TAX_RETURN_BASE";
	
	/** property name to the the transaction  installments number */
	const TRANSACTION_INSTALLMENTS_NUMBER = "INSTALLMENTS_NUMBER";
	
	/** property name to the order id to api request */
	const ORDER_ID = PayUParameters::ORDER_ID;
	
	/** property name to the reference code to api request */
	const REFERENCE_CODE = PayUParameters::REFERENCE_CODE;
	
	/** property name to the transaction id to api request */
	const TRANSACTION_ID = PayUParameters::TRANSACTION_ID;
	
	/** property name to the plan value */
	const PLAN_VALUE = "PLAN_VALUE";
	
	/** property name to the plan tax */
	const PLAN_TAX = "PLAN_TAX";
	
	/** property name to the plan tax return base */
	const PLAN_TAX_RETURN_BASE = "PLAN_TAX_RETURN_BASE";
	
	/** property name to the item value */
	const ITEM_VALUE = "ITEM_VALUE";
	
	/** property name to the item tax */
	const ITEM_TAX = "ITEM_TAX";
	
	/** property name to the item tax return base */
	const ITEM_TAX_RETURN_BASE = "ITEM_TAX_RETURN_BASE";
	
	/** PSE financial institution code (Bank code) */
	const  FINANCIAL_INSTITUTION_CODE = "FINANCIAL_INSTITUTION_CODE";
	
	/** PSE financial institution name (Bank Name) */
	const FINANCIAL_INSTITUTION_NAME = "FINANCIAL_INSTITUTION_NAME";
	
	/** PSE payer person type (N - Natural or J - Legal) */
	const  USER_TYPE = "USER_TYPE";
	
	/** PSE First reference */
	const  PSE_REFERENCE1 ="PSE_REFERENCE1";
	
	/** PSE Second reference */
	const  PSE_REFERENCE2 ="PSE_REFERENCE2";
	
	/** PSE Third reference */
	const  PSE_REFERENCE3 ="PSE_REFERENCE3";	
	
	/**
	 * The response page URL
	 */
	const RESPONSE_URL = "RESPONSE_URL";
	
}