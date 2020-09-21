<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

     public function testItCanFetchAUserWithId(){
        $user=new User();
        $user->first_name="James";
        $user->last_name="Nwachukwu";
        $user->phone="07011111111";
        $user->email="test@gmail.com";
        $user->password=app('hash')->make('secret');
        $user->save();

        $this->actingAs($user)
             ->get('/api/users/1')
             ->seeJson([
                 'id'=>1,
                'email' => 'test@gmail.com',
             ]);
     }

     public function testItCanFetchAllUsers(){
        $user=new User();
        $user->first_name="James";
        $user->last_name="Nwachukwu";
        $user->phone="07011111111";
        $user->email="test@gmail.com";
        $user->password=app('hash')->make('secret');
        $user->save();

        $user2=new User();
        $user2->first_name="Ben";
        $user2->last_name="Mark";
        $user2->phone="07011111112";
        $user2->email="test2@gmail.com";
        $user2->password=app('hash')->make('secret');
        $user2->save();

        $response=$this->actingAs($user)
        ->get('/api/users')
        ->seeJson([
                'id'=>1,
                'email' => 'test@gmail.com',
            ]);
            $response->seeJson([
                'id'=>2,
                'email' => 'test2@gmail.com',
            ]);

     }
}
