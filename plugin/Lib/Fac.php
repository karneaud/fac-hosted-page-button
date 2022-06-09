<?php

namespace WPFac\HostedPage\Button\Lib;

use Omnipay\Omnipay;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\FirstAtlanticCommerce\Enums\TransactionCode;
/**
 * Fac class hosted page methods
 * @version 1.0
 */ 
class Fac {
	/**
	 * @var \Omnipay\Gateway $gateway Gateway class to perform PR7 request
	 */ 
	protected $gateway;
	
	function __construct(array $config = []) {
    	$config = array_merge([
        	'merchantId' => '12345678',
        	'merchantPassword' => 'abcdefg',
        	'testMode' => true,
        	'requireAvsCheck' => false
        ], $config );
    	$this->gateway =  Omnipay::create('FirstAtlanticCommerce')->initialize($config);
    }
	/**
	 * Performs request to get the hosted page url link
	 * 
	 * @method hosted_page_request
	 * @param array $params An array of keys:- amount,currency,transactionId,cardHolderResponseUrl
	 * @return Array and array with response [code, message, [ error | data ] ]
	 */ 
	function hosted_page_request(array $params = []) 
    {
    	try {
        	$response = $this->gateway->hostedPage(array_merge(
            			 [
    						'transactionCode' => TransactionCode::HOSTED_PAGE_3DS, //Use values based on requirements 
    						'pageSet' => 'test',
    						'pageName' => 'test1'
                         ], $params
       		 ))->send();

			if ( $response->isSuccessful() ) {
    			$response = [ 'code' => $response->getCode() , 'message' => $response->getMessage(), 'data' => [ 'url' => $response->getRedirectUrl() ] ];
			} else {
    			throw new InvalidResponseException( $response->getMessage(), $response->getCode());
			}
        	
        } catch (\Exception $e) {
        	
        	$response = [ 'code' => $e->getCode() , 'error' => true, 'message' =>  $e->getMessage()  ];
        }
    
    	return $response;
    }
	/**
	 * Performs request to get the transaction results
	 * 
	 * @method hosted_page_result
	 * @param string $token the token return from hosted page
	 * @return Array and array with [response code, message, transaction_id, [error]]
	 */ 
	function hosted_page_result(string $token = null) 
    {
		try {
        	$response = $this->gateway->hostedPageResult([
    			'token' => $token, //token is provided returned in callback after completes hosted page
			])->send();
        
			if ( $response->isSuccessful() ) {
   				$response = [ 'code' => $response->getResponseCode(),
    							'message' => $response->getMessage(),
    							'transaction_id' => $response->getTransactionId() ];
			}
		  else {
    			throw new InvalidResponseException( $response->getMessage(), $response->getCode());
			}
        } catch (\Exception $e) {
        	$response = [ 'code' => $e->getCode() , 'error' => true, 'message' =>  $e->getMessage(), 'transaction_id' => $response? $response->getTransactionId() : null  ];
        }
    
    	return $response;
    }
}