<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DataSourceTest extends TestCase
{

    /**
     * @return void
     */
    public function test_csv_available_and_retrun_data()
    {
        $this->withoutExceptionHandling();
        $this->assertTrue(file_exists('storage/export.csv'));
        
        $response = $this->json('GET', '/api/getall', [
                              'name' => 'test-name',
                              'data' => [100,90,89]
                         ])->assertStatus(200);
    }
}
