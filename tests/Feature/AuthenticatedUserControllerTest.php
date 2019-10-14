<?php

namespace Tests\Feature;

use App\User;
use App\Action;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthenticatedUserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    private function GenerateFakeUserAction() {
        factory(User::class,10)->create()
        ->each(function($user){ for ($i=0; $i <2 ; $i++) { 
        $user->initiatedActions()->save(factory(Action::class)->create());
    }});

    } 

   private function userJsonStructure(){
    return[ 
    'data' => [  
    'id',
    'name', 
    'email',
    'email_verified_at',
    'created_at',
    'updated_at',]
       
    ];  
   } 

   private function userSample(){
       return [
        'name' => 'jean',
        'email' => 'jean@mail.com',
        'password' => 'jean',
       ];
   }

   private function userSampleDB(){
    return [
     'name' => 'jean',
     'email' => 'jean@mail.com',
    ];
}


    private function userSample2(){
        return [
        'name' => 'jean',
        'email' => 'lmouhouv@mail.com',
        'password' => 'jean',
        ];
    }

    private function userSampleDB2(){
    return [
    'name' => 'jean',
    'email' => 'lmouhouv@mail.com',
    ];
    }






    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


     /** @test */
   public function register_User()
   {
         $this->withoutExceptionHandling();

         $response = $this->post('api/register', $this->userSample());

         $response->assertStatus(200);

         $this->assertAuthenticated($guard = null);

         $this->assertDatabaseHas('users', $this->userSampleDB());
         
    }

      /** @test */
   public function fisrtOrRegister_User()
   {
         $this->withoutExceptionHandling();

         $response1 = $this->post('api/register', $this->userSample());

         $response2 = $this->post('api/register', $this->userSample());

         $response1->assertStatus(200);

         $response2->assertStatus(200);

         $this->assertAuthenticated($guard = null);

         $this->assertDatabaseHas('users', $this->userSampleDB());
         
    }


   /** @test */
   public function get_All_users()
   {
         $user = factory(User::class)->create();

         $response = $this->actingAs($user)->get('/api/users');

         $this->assertAuthenticated($guard = null);

         $response->assertStatus(200);
    }

    /** @test */
    public function get_User_By_Id_ResponseWithStructure()
    {    
         $this->GenerateFakeUserAction();

         $user = factory(User::class)->create();

         $id= rand(1 , 10);
         
         $response = $this->actingAs($user)->get('/api/users/'.$id.'');

         $this->assertAuthenticated($guard = null);

         $response->assertStatus(200);

         $response->assertJsonStructure($this->userJsonStructure());
             
    }


      /** @test */
      public function delete_User_By_Id()
      {   
            $this->GenerateFakeUserAction();

            $user = factory(User::class)->create();

            $id= rand(1 , 10);
            
            $response = $this->actingAs($user)->delete('/api/users/'.$id.'');

            $this->assertAuthenticated($guard = null);
        
            $response->assertStatus(401);
      }


        /** @test */
     public function delete_CurrentUser()
     {   
        $this->GenerateFakeUserAction();

        $this->withoutExceptionHandling();

        $response1 = $this->post('api/register', $this->userSample());

        $this->assertDatabaseHas('users', $this->userSampleDB());

        $this->assertAuthenticated($guard = null);
    
        $response1->assertStatus(200);

        $response2 = $this->delete('api/currentUser');

        $response2->assertStatus(204);

        $this->assertDatabaseMissing('users', $this->userSampleDB());
     }


       /** @test */
       public function Update_User_By_Id()
       {   
            $this->withoutExceptionHandling();
            $this->GenerateFakeUserAction();

            $response1 = $this->post('api/register', $this->userSample());

            $this->assertDatabaseHas('users', $this->userSampleDB());

            $this->assertAuthenticated($guard = null);
           
            $response2 = $this->Put('/api/users/5', $this->userSample2());
         
            $response2->assertStatus(201);

            $this->assertDatabaseMissing('users', $this->userSampleDB());

            $this->assertDatabaseHas('users', $this->userSampleDB2());
       }

}
