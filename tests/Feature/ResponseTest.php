<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    
    /** @test */
    public function PageLoadTest() {   
        //Check page is giving correct code response
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test **/
    public function CallApiWithValidCityTest() {

        //Check the API is returning correctly when given an accurate city name
        $response = $this->call('POST', 'search', array(
            '_token' => csrf_token(),
            'city' => 'Ledbury'
        ));

        $response->assertStatus(200);
    }

    /** @test **/
    public function CallApiWithInvalidCityTest() {

        //Check the API is returning correctly when given an inaccurate city name
        $response = $this->call('POST', 'search', array(
            '_token' => csrf_token(),
            'city' => 'NoName'
        ));

        $response->assertStatus(200);
    }

}
