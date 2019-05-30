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
 * Util class to build the url to api operations
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0, 16/09/2014
 *
 */
abstract class UrlResolver{
	
	/** constant to add operation */
	const ADD_OPERATION = "add";
	
	/** constant to edit operation */
	const EDIT_OPERATION = "edit";
	
	/** constant to delete operation */
	const DELETE_OPERATION = "delete";
	
	/** constant to get operation */
	const GET_OPERATION = "get";
	
	/** constant to query operation */
	const QUERY_OPERATION = "query";
	
	/** constant to get list operation */
	const GET_LIST_OPERATION = "getList";	
	
	/** contains the url info to each entity and operation this is built in the constructor class */
	protected $urlInfo;
	
	/**
	 * build an url segment using the entity, operation and the url params
	 * @param string $entity
	 * @param string $operation
	 * @param string $params
	 * @throws InvalidArgumentException
	 * @return the url segment built
	 */
	public function getUrlSegment($entity, $operation, $params = NULL){
	
		if(!isset($this->urlInfo[$entity])){
			throw new InvalidArgumentException("the entity " . $entity. 'was not found ');
		}
	
		if(!isset($this->urlInfo[$entity][$operation])){
			throw new InvalidArgumentException("the request method " . $requestMethod. 'was not found ');
		}
	
		$numberParams = $this->urlInfo[$entity][$operation]['numberParams'];
	
		if(!isset($params) && $numberParams > 0){
			throw new InvalidArgumentException("the url needs " . $numberParams. ' parameters ');
		}
	
		if(isset($params) && count($params) != $numberParams){
			throw new InvalidArgumentException("the url needs " . $numberParams. ' parameters  but ' . count($params) . 'was received');
		}
	
		if(!is_array($params)){
			$params = array($params);
		}
	
		return vsprintf($this->urlInfo[$entity][$operation]['segmentPattern'],$params);
	
	}	
	
}
