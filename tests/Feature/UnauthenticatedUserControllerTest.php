<?php

namespace Tests\Feature;

use App\User;
use App\Action;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UnauthenticatedUserControllerTest extends TestCase
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
   public function get_All_users_Unauthenticated_User()
   {

         $response = $this->get('/api/users');

         $response->assertStatus(200);
    }

    /** @test */
    public function get_User_By_Id_ResponseWithStructure_Unauthenticated_User()
    {   
        $this->GenerateFakeUserAction();

         $id= rand(1 , 10);
         
         $response = $this->get('/api/users/'.$id.'');

         $response->assertStatus(200);

         $response->assertJsonStructure($this->userJsonStructure());
             
    }


      /** @test */
      public function create_User_By_Id_Unauthenticated_User()
      {   
        $this->withoutExceptionHandling();
          $this->GenerateFakeUserAction();
          
          $id= rand(1 , 10);
           
           $response = $this->delete('/api/users/'.$id.'');
        
           $response->assertStatus(401);
      }


       /** @test */
       public function Update_User_By_Id_Unauthenticated_User()
       {   
         $this->withoutExceptionHandling();
           $this->GenerateFakeUserAction();
           
            $response = $this->Put('/api/users/6', $this->userSample());
         
            $response->assertStatus(401);
       }

     /** @test */
    public function delete_User_By_Id_Unauthenticated_User()
    {   
        $this->withoutExceptionHandling();
        $this->GenerateFakeUserAction();
        
        $id= rand(1 , 10);
         
        $response =  $this->withHeaders([
            'Accept' => 'application/json',])
            ->delete('/api/users/'.$id.'');
            
         $response->assertStatus(401);
    }


     /** @test */
     public function delete_CurrentUser_Unauthenticated_User()
     {   
         $this->withoutExceptionHandling();
         $this->GenerateFakeUserAction();
         
         $id= rand(1 , 10);
          
         $response =  $this->withHeaders([
             'Accept' => 'application/json',])
             ->delete('/api/currentUser');
             
          $response->assertStatus(401);
     }

}
