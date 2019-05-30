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
use PayU\PayURecurringBillItem;
use PayU\PayU;


/**
 * Manages all PayU recurring bill operations 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 25/09/2014
 *
 */
class PayURecurringBill{
	
	
	
	/**
	 * Finds a recurring bill by id
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function find($parameters, $lang = null){
	
		$required = array(PayUParameters::RECURRING_BILL_ID);
		CommonRequestUtil::validateParameters($parameters, $required);
		$recurringBillId = CommonRequestUtil::getParameter($parameters, PayUParameters::RECURRING_BILL_ID);
	
		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ENTITY,
				PayUSubscriptionsUrlResolver::GET_OPERATION,
				array($recurringBillId));
	
		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::GET);
		return PayUApiServiceUtil::sendRequest(NULL, $payUHttpRequestInfo);
	}
	
	
	/**
	 * Finds all bill filtered by 
	 * - customer id
	 * - date begin
	 * - date final
	 * - payment method
	 * - subscription Id
	 * 
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the subscription plan list
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function listRecurringBills($parameters, $lang = null){
	
		$request = new \stdClass();
		$request->customerId = CommonRequestUtil::getParameter($parameters, PayUParameters::CUSTOMER_ID);
		$request->dateBegin = CommonRequestUtil::getParameter($parameters, PayUParameters::RECURRING_BILL_DATE_BEGIN);
		$request->dateFinal = CommonRequestUtil::getParameter($parameters, PayUParameters::RECURRING_BILL_DATE_FINAL);
		$request->paymentMethod = CommonRequestUtil::getParameter($parameters, PayUParameters::RECURRING_BILL_PAYMENT_METHOD_TYPE);
		$request->state = CommonRequestUtil::getParameter($parameters, PayUParameters::RECURRING_BILL_STATE);
		$request->subscriptionId = CommonRequestUtil::getParameter($parameters, PayUParameters::SUBSCRIPTION_ID);
		$request->limit = CommonRequestUtil::getParameter($parameters, PayUParameters::LIMIT);
		$request->offset = CommonRequestUtil::getParameter($parameters, PayUParameters::OFFSET);
	
		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ENTITY,
				PayUSubscriptionsUrlResolver::QUERY_OPERATION);
	
		$urlSegment = CommonRequestUtil::addQueryParamsToUrl($urlSegment, $request);
	
		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::GET);
		return PayUApiServiceUtil::sendRequest(null, $payUHttpRequestInfo);
	}
	
	
}

