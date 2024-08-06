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
class TaskTest extends TestCase 
{

    /**
     * kiwi can create task test
     * 
     * @return void
     */
    public function test_kwik_can_create_task(): void
    {
        $kwik = new Kwik();
        $kwik->login(); 
        $this->assertInstanceOf(Response::class, $kwik->getResponse());
        $this->assertNotNull($kwik->getVendorDetails());
        $this->assertEquals($kwik->getEmail(), $kwik->getVendorDetails()->email); 
        $this->assertNotNull($kwik->getAccesToken());

        $task = $kwik->createTask(); 
        $this->assertNotNull($task);
        $this->assertIsArray($task);

        $this->assertNotEmpty($task);

        dd($task);
    }

     /**
     * kiwi can cancel task test
     * 
     * @return void
     */
    public function test_kwik_can_cancel_task(): void
    {
        $kwik = new Kwik();
        $kwik->login(); 
        $this->assertInstanceOf(Response::class, $kwik->getResponse());
        $this->assertNotNull($kwik->getVendorDetails());
        $this->assertEquals($kwik->getEmail(), $kwik->getVendorDetails()->email); 
        $this->assertNotNull($kwik->getAccesToken());

        $task = $kwik->cancelTask(); 
        $this->assertNotNull($task);
        $this->assertIsArray($task);

        $this->assertNotEmpty($task);
    }
}