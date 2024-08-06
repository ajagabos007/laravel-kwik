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
class LoaderTest extends TestCase 
{

    /**
     * Test vendor can login
     * 
     * @return void
     */
    public function test_kwik_can_fetch_loaders(): void
    {
        $kwik = new Kwik();

        $kwik->login(); 
        $this->assertInstanceOf(Response::class, $kwik->getResponse());
        $this->assertNotNull($kwik->getVendorDetails());
        $this->assertEquals($kwik->getEmail(), $kwik->getVendorDetails()->email); 
        $this->assertNotNull($kwik->getAccesToken());

        $loaders = $kwik->getLoaders(); 
        $this->assertNotNull($loaders);
        $this->assertIsArray($loaders);
        $this->assertNotEmpty($loaders);
    }
}