<?php

/**
 * @package Ajagabos\Kwik\Tests\Unit
 * @ignore Exclude from phpDocumentor documentation.
 */

namespace Ajagabos\Kwik\Tests\Unit;

use Tests\TestCase;
// use PHPUnit\Framework\TestCase;


/**
 * @category Ajagabos\Kwik\Tests\Unit
 * @author Philip James Ajagabos 
 * @link ajagabos007@gmail.com
 * @link https:/facebook.com
 * 
 * @ignore
 */
class EnvVariableTest extends TestCase
{
    /**
     * Test env kwik's email is set
     * 
     * @return void
     */
    public function test_kwik_email_env_variable_set(): void
    {
        
        $this->assertTrue(!is_null(env('KWIK_EMAIL')));
    }

    /**
     * Test env kwik's password is set
     * 
     * @return void
     */
    public function test_kwik_password_env_variable_set(): void
    {
        
        $this->assertTrue(!is_null(env('KWIK_PASSWORD')));
    }


    /**
     * Test env kwik domain name is set
     * 
     * @return void
     */
    public function test_kwik_domain_name_env_variable_set(): void
    {
        
        $this->assertTrue(!is_null(env('KWIK_DOMAIN_NAME')));
    }

    /**
     * Test env kwik api_base_url is set
     * 
     * @return void
     */
    public function test_kwik_api_base_url_env_variable_set(): void
    {
        
        $this->assertTrue(!is_null(env('KWIK_API_BASE_URL')));
    }

    /**
     * Test kwik api base url 
     * 
     * @return void
     */
    public function test_kwik_api_base_url_returns_a_successful_response(): void
    {
        if(is_null(env('KWIK_API_BASE_URL')))
        {
            $this->markTestSkipped(
                'The KWIK_API_BASE_URL is not env',
            );
        }

        $response = $this->get(env('KWIK_API_BASE_URL'));

        $response->assertStatus(200);
    }
}
