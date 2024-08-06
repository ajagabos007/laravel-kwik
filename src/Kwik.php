<?php

/**
 * @package Ajagabos\Kwik
 * @filesource
 */
namespace Ajagabos\Kwik;

use ArgumentCountError;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;

/**
 *  @author Philip James Ajagabos <ajagabos007@gmail.com> 
 */
class Kwik {

    /**
     * Payment method
     * @var integer
     */
    protected const PAYMENT_METHOD=32;


    /**
     * Origin booking
     * @var integer
     */
    protected const ORIGIN_BOOKING=1;

    /**
     * Kwik email
     * 
     * @var string
     */
    protected $email;

    /**
     * Kwik password
     * 
     * @var string
     */
    protected string $password;

    /**
     * Kwik is vendor
     * 
     * @var bool
     */
    protected bool $isVendor=true;

    /**
     * Kwik accessToken
     * 
     * @var string
     */
    protected string $accessToken;

     /**
     * Kwik appAccessToken
     * 
     * @var string
     */
    protected string $appAccessToken;

    /**
     * Kwik's API base url
     * 
     * @var string
     */
    protected string $baseUrl;

    /**
     * Kwik domain name for webapp
     * 
     * @var string
     */
    protected string $domainName;

    /**
     * Kwik authenticated vendor details
     * 
     * @var object
     */
    protected object $vendorDetails;

    /**
     *  Response from requests made to Kwik
     * @var \GuzzleHttp\Psr7\Response
     */
    protected ?Response $response;

     /**
     * Instance of Client
     * 
     * @var \GuzzleHttp\Client
     */
    protected Client $client;


    /**
     * Create an instance of kwik
     */
    public function __construct()
    {
        $this->isVendor =  Config::get('kwik.is_vendor') == true ? true : false;
        
        $this->setEmail();
        $this->setPassword();
        $this->setBaseUrl();
        $this->setdomainName();
        $this->setAccessToken();
        $this->setAppAccessToken();
        $this->setClient();
    }

    /**
     * Set Base Url from kwik config file if no value is passed
     * @param string|null $baseUrl
     * 
     * @return void
     */
    public function setBaseUrl(String $baseUrl=null)
    {
        if(is_null($baseUrl))
        {
            $this->baseUrl = Config::get('kwik.base.url');
        } 
        else{
            $this->baseUrl = $baseUrl;
        }
    }

    /**
     * Set domain name from kwik config file if no value is passed
     * 
     * @param string|null $baseUrl
     * @return void
     */
    public function setDomainName(String $domainName=null)
    {
        if(is_null($domainName))
        {
            $this->domainName = Config::get('kwik.domain.name');
        } 
        else{
            $this->domainName = $domainName;
        }
    }

    /**
     * Set kwik email from kwik config file if no value is passed
     * 
     * @param string|null $email
     * @return void
     */
    public function setEmail(String $email=null)
    {
        if(is_null($email))
        {
            $this->email = Config::get('kwik.email');
        } 
        else{
            $this->email = $email;
        }
    }

    /**
     * Set kwik password from kwik config file if no value is passed
     * 
     * @param string|null $password
     * @return void
     */
    public function setPassword(String $password=null)
    {
        if(is_null($password))
        {
            $this->password = Config::get('kwik.password');
        } 
        else{
            $this->password = $password;
        }
    }

    /**
     * Set kwik accessToken from kwik config file if no value is passed
     * 
     * @param string|null $accessToken 
     * @return void
     */
    public function setAccessToken(String $accessToken=null)
    {
        if(is_null($accessToken))
        {
            $this->accessToken = Config::get('kwik.access.token');
        } 
        else{
            $this->accessToken = $accessToken;
        }
    }

    /**
     * Set kwik app access token from kwik config file if no value is passed
     * 
     * @param string|null $accessToken
     * @return void
     */
    public function setAppAccessToken(String $appAccessToken=null)
    {
        if(is_null($appAccessToken))
        {
            $this->appAccessToken = Config::get('kwik.app.access.token');
        } 
        else{
            $this->appAccessToken = $appAccessToken;
        }
    }
    

     /**
     * Set options for making the Client request
     * 
     * @param array<string,string> $options 
     */
    private function setClient(array $options=[]): void
    {
        $this->client = new Client(
            [
                'base_uri' => array_key_exists('base_uri', $options) ? $options['base_uri'] : $this->baseUrl,
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ]
            ]
        );
    }

    /**
     * @param string $relativeUrl
     * @param string $method
     * @param array<string, string> $body
     * @return Kwik
     * @throws Exception
     */
    private function httpRequest(String $method, String $relativeUrl,  array $body = [])
    {
        if (is_null($method)) {
            throw new Exception("Empty method not allowed");
        }

        $params = [
            'is_vendor' => $this->isVendor == true? 1 : 0 ,
        ];

        $body['access_token'] = $this->accessToken;
        $body['domain_name'] = $this->domainName;


        if(!is_null($this->accessToken) && \strlen($this->accessToken) > 0)
        {
            $params['access_token'] = $this->accessToken;
        }

        $request_data = [
            "body" => json_encode($body),
            'query' => $params
        ];
        
        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl.$relativeUrl, $request_data
        );

        return $this;
    }

    /**
     * Get the access token set using the setter or after login
     * 
     * @return string|null
     */
    public function getAccesToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Get the access token set using the setter or after login
     * 
     * @return string|null
     */
    public function getEmail(): string
    {
        return $this->email;
    }

     /**
     * Get the access token set using the setter or after login
     * 
     * @return object|null
     */
    public function getVendorDetails(): object|null
    {
        return $this->vendorDetails ?? null;
    }

    /**
     * Get the access token set using the setter or after login
     * 
     * @return  \GuzzleHttp\Psr7\Response
     */
    public function getResponse(): Response
    {
        return $this->response ?? null;
    }
    
    /**
     * Get the instance of kwik as a plain array.
     *
     * @return array<string, mixed>
     */
    public function toArray() : array
    {
        $items = [];
        $vars = get_object_vars($this);
        $keys = array_keys($vars);

        $callback = function ($value) {
            if($value instanceof Response)
            {
                $response = [
                    'body'  =>  \json_decode ($value->getBody(), true),
                    'status_code' => $value->getStatusCode(),
                    'reason_phrase' => $value->getReasonPhrase(),
                ];
                return $response;
            }

            if(is_object($value))
            {
                return get_object_vars($value);
            }

            return $value;
        };

        try {
            $items = array_map($callback, $vars, $keys);
        } catch (ArgumentCountError) {
            $items = array_map($callback, $vars);
        }
        return array_combine($keys, $items);
    }

    /**
     * Login a vendor using the given credentials or the env variables 
     * 
     * @param array<string, string> $credentials
     * 
     */
    public function login(array $credentials=[])
    {
        $data = [
            'domain_name' => $this->domainName,
            'email' => array_key_exists('email', $credentials) ?  $credentials['email']: $this->email,
            'password' => array_key_exists('password', $credentials) ?  $credentials['password']: $this->password,
        ];
 
        $this->httpRequest('POST', '/vendor_login', $data);

        if($this->response->getReasonPhrase() ==='OK')
        {
            $body = json_decode($this->response->getBody());

            if($body->status == 200)
            {
                $this->vendorDetails = $body->data->vendor_details;
                $this->accessToken = $body->data->access_token ;
                $this->appAccessToken = $body->data->app_access_token ;
            }
          
        }
    }  

    /**
     * Login a vendor using the given credentials or the env variables 
     * 
     * @param array<string, string> $data
     * @return array<string, mix> 
     * 
     */
    public function getVehicles(array $data=[])
    {
        $body['size'] = 1;
        $vehicles = [];
        
        if(array_key_exists('size', $data) && is_int($data['size']))
        {
            $body['size'] = $data['size'];
        }
 
        $this->httpRequest('GET', '/getVehicle', $body);

        return $this->responseData();
    }  

    /**
     * Fetch loader amount 
     * 
     * The api is used to get loaders count mapped with their amount 
     * 
     * @param array<string, string> $data
     * @return array{
     *     loaderInfo: array<int, array{loaders_count: int, loaders_amount: string}>,
     *     is_loaders_enabled: int,
     *     each_loader_amount: int,
     *     max_loader_count: int
     * }
     * 
     */
    public function getLoaders(array $data=[])
    {
       
        $this->httpRequest('GET', '/getLoaderList', $data);

        return $this->responseData();
    }  


    /**
     * cancel  a pickup and delivery task 
     * 
     * @param array<string,string> $data
     */
    public function createTask(array $data=[])
    {       
        $data['payment_method'] = self::PAYMENT_METHOD;
        $data['amount'] = "0.01";

        $this->httpRequest('POST', '/v2/create_task_via_vendor', $data);
        $response =  \json_decode ($this->response->getBody());

        return $this->responseData();
    }

    /**
     * Cancel task
     * 
     * @param array<string,string> $data
     */
    public function cancelTask(array $data=[])
    {       
        $this->httpRequest('POST', '/cancel_vendor_task', $data);

        return $this->responseData();
    }

     /**
     * Fetch added cards
     * 
     * @param array<string,string> $data
     */
    public function getMerchantCards(array $data=[])
    {    
        $data['payment_method'] = self::PAYMENT_METHOD;
        $data['origin_booking'] = self::ORIGIN_BOOKING;
        $this->httpRequest('POST', '/fetch_merchant_cards', $data);

        return $this->responseData();
    }


    public function responseData()
    {
        $data = [];

        if($this->response->getReasonPhrase() ==='OK')
        {
            $response =  \json_decode ($this->response->getBody(), true);

            if(array_key_exists('status', $response) && $response['status']===200)
            {
                $data = $response['data'];
            }
            else {
                \Log::error($response);
                throw new Exception( array_key_exists('message', $response) ? $response['message'] : "Error Processing Request", 1);
            }
           
        }

        return $data;
    }
    

}