<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryMainTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testCreateCategory()
    {
        $categoryData = [
            'name' => 'New Category'
        ];

        $response = $this->postJson('/api/categories', $categoryData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'name', 'created_at', 'updated_at'
                 ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'New Category'
        ]);
    }
    //it will go to Route Resource and get method post with function store category


    public function testFetchAllCategories()
    {
        $user = User::factory()->create();

        Category::factory()->count(3)->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id', 'name','hidden', 'created_at', 'updated_at'
                         ]
                     ]
                 ]);

        $response->assertJsonCount(3, 'data');
    }

    // will go to function index in controller categories 
}
