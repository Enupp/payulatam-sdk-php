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
 * This class has utility methods for objects used in the request
 *  
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0
 */
class PayURequestObjectUtil{
	
	/**
	 * Remove null values of object or array
	 * @param Object $object parameter with null values
	 * @throws InvalidArgumentException if the object parameter is null
	 * @return the object processed
	 */
	public static function removeNullValues($object){
		
		if(!isset($object)){
			throw new InvalidArgumentException("the object to remove null values is null ");
		}
		
		if(!is_object($object) && !is_array($object)){
			throw new InvalidArgumentException("the parameter is not a object or array");
		}
		
		if(is_object($object)){
			foreach($object as $k => $v){
				if($v === null){
					unset($object->$k);
				}else if(is_object($object->$k) || is_array($object->$k)){
					$tempObject = PayURequestObjectUtil::removeNullValues($object->$k);
					if(!isset($tempObject)){
						unset($object->$k);
					}else{
						$object->$k = $tempObject;
					}
					
				}
			}
		}else if(is_array($object)){
			foreach($object as $k => $v){
				if($v === null){
					unset($object[$k]);
				}else if(is_object($object[$k]) || is_array($object[$k])){
					$tempObject = PayURequestObjectUtil::removeNullValues($object[$k]);
					if(!isset($tempObject)){
						unset($object[$k]);
					}else{
						$object[$k] = $tempObject;
					}
						
				}
			}
		}
		
		if(count((array)$object) === 0){
			return null;
		}else{
			return $object;
		}
	}
	
	
	/**
	 * Convert to utf-8 the string values
	 * @param Object or array $object parameter with string values 
	 * @throws InvalidArgumentException if the object parameter is null or it isn't a object
	 * @return the object processed 
	 */
	public static function encodeStringUtf8($object){
		if(!isset($object)){
			throw new InvalidArgumentException("the object to enconde  is null ");
		}
		
		if(!is_object($object) && !is_array($object)){
			throw new InvalidArgumentException("the parameter is not a object or array");
		}
		
		if(is_object($object)){
			foreach($object as $k => $v){
				if($v != null && is_string($v)  && mb_detect_encoding($v,'UTF-8') != 'UTF-8'){
					$object->$k = utf8_encode($v);
				}else if(is_object($object->$k)){
					$object->$k = PayURequestObjectUtil::encodeStringUtf8($object->$k);
				}
			}
		}else if(is_array($object)){
			foreach($object as $k => $v){
				if($v != null && is_string($v)  && mb_detect_encoding($v,'UTF-8') != 'UTF-8'){
					$object[$k] = utf8_encode($v); 
				}else if(is_object($object[$k]) || is_array($object[$k])){
					$object[$k] = PayURequestObjectUtil::encodeStringUtf8($object[$k]);
				}
			}
		}
		
		return $object;
	}
	
	/**
	 * Adjust miliseconds from epoch to date format 
	 * @param the object or array $data
	 * @throws InvalidArgumentException
	 * @return the object or array processed
	 */
	public static function formatDates($data){
		if(!isset($data)){
			throw new InvalidArgumentException("the object to format dates is null ");
		}
		
		if(!is_object($data) && !is_array($data) ){
			throw new InvalidArgumentException("the parameter to format dates is not a object or array");
		}
		
		
		
		foreach($data as $k => $v){
			if(PayURequestObjectUtil::isKeyDateField($k)){
				if(is_array($data)){
					$miliseconds = $data[$k];
					$data[$k] = PayURequestObjectUtil::getDate($miliseconds); 
				}else if(is_object($data)){
					$miliseconds = $data->$k;
					$data->$k = PayURequestObjectUtil::getDate($miliseconds);
				}
			}else if(is_object($data) && (is_object($data->$k) || is_array($data->$k))){
				$data->$k = PayURequestObjectUtil::formatDates($data->$k);
			}else if(is_array($data) && (is_object($data[$k]) || is_array($data[$k]))){
				$data[$k] =  PayURequestObjectUtil::formatDates($data[$k]);
			}
		}
		
		return $data;
	}
	
	/**
	 * Validates if the key in the object belows a date field
	 * @param string $key the field name
	 * @return boolean true if the key field is in the data fields name false the otherwise
	 */
	private static function isKeyDateField($key){
		$dateFields = array('EXPIRATION_DATE', 
							'operationDate',
							'currentPeriodStart', 
							'currentPeriodEnd',
							'dateCharge');

		foreach($dateFields as $field){
			if($field === $key){
				return true;
			}			
		}
		
		return false;
	}
	
	/**
	 * Format a integer to a date string using PayUConfig::PAYU_DATE_FORMAT
	 * @param integer $miliseconds
	 * @throws InvalidArgumentException
	 * @return the date string
	 */
	public static function getDate($miliseconds){
		$formattedValue = floatval($miliseconds);
		if($formattedValue == 0 || $formattedValue == 1){
			throw new InvalidArgumentException("the value in miliseconds for date is invalid");
		}
		
		$seconds = round($formattedValue/1000);
		return date(PayUConfig::PAYU_DATE_FORMAT, $seconds);
	}
	
}