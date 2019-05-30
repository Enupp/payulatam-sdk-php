<?php

namespace PayU\Api;

use PayU\Api\SupportedLanguages;
use PayU\Api\PayUKeyMapName;
use PayU\Api\PayUCommands;
use PayU\Api\PayUTransactionResponseCode;
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
 * This class helps to build the request api info 
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 29/10/2013
 *
 */
class PayUHttpRequestInfo{
	
	/** the http method to the request */
	var $method;
	
	/** the environment to the request*/
	var $environment;
	
	/** the segment to add the url to the request*/
	var $segment;
	
	/** the user for Basic Http authentication */
	var $user;
	
	/** the password for Basic Http authentication */
	var $password;
	
	/** the language to be include in the header request */
	var $lang;
	
	
	
	/**
	 * 
	 * @param string $environment
	 * @param string $method
	 * @param string $segment
	 */
	function __construct($environment, $method, $segment = null) {
		$this->environment = $environment;
		$this->method = $method;
		$this->segment = $segment;
	}
	
	
	/**
	 * Builds the url for the environment selected
	 */
	public function getUrl(){
		if(isset($this->segment)){
			return Environment::getApiUrl($this->environment) . $this->segment;
		}else{
			return Environment::getApiUrl($this->environment);
		}
	}
	
	
	
}