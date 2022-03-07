<?php
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 07.03.2022
 * Time: 22:35
 */


namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * Class ConferenceControllerTest
 *
 * @package App\Tests\Controller
 */
class ConferenceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Оставьте свой отзыв!');
    }
}
