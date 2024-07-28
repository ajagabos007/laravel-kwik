<?php 

/**
 * @ignore Exclude from phpDocumentor documentation.
 */

namespace Ajagabos\Kwik\Tests\Feature;

use Ajagabos\Kwik\Kwik;
use Tests\TestCase;

use GuzzleHttp\Psr7\Response;

/**
 * @author Philip James Ajagabos <ajagabos007@gmail.com> 
 * 
 */
class LoginTest extends TestCase 
{

    /**
     * Test vendor can login
     * 
     * @return void
     */
    public function test_vendor_can_login_to_kwik(): void
    {
        $kwik = new Kwik();

        $kwik->login(); 
        $this->assertInstanceOf(Response::class, $kwik->getResponse());
        $this->assertNotNull($kwik->getVendorDetails());
        $this->assertEquals($kwik->getEmail(), $kwik->getVendorDetails()->email); 
        $this->assertNotNull($kwik->getAccesToken());
        $this->assertNotNull($kwik->getAccesToken());
    }
}