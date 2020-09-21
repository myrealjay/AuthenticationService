<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItCreatesUserSuccessfully(){
        $data=[
            'first_name'=>'James',
            'last_name'=>'Nwachukwu',
            'phone'=>'07011111111',
            'email'=>'test@gmail.com',
            'password'=>'secret'
        ];
        $response=$this->call('POST', '/api/register', $data);

        $this->seeInDatabase('users', ['email' => 'test@gmail.com']);
    }
    public function testItFailsCreatingUserWithoutEmail(){
        $data=[
            'first_name'=>'James',
            'last_name'=>'Nwachukwu',
            'phone'=>'07011111111',
            'password'=>'secret'
        ];
        $response=$this->call('POST', '/api/register', $data);

        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'email' => ['The email field is required.'],
         ]);
    }

    public function testEmailIsUnque(){
        $user=new User();
        $user->first_name="James";
        $user->last_name="Nwachukwu";
        $user->phone="07011111111";
        $user->email="test@gmail.com";
        $user->password=app('hash')->make('secret');
        $user->save();

        $data=[
            'first_name'=>'James',
            'last_name'=>'Nwachukwu',
            'phone'=>'07011111111',
            'email'=>'test@gmail.com',
            'password'=>'secret'
        ];
        $response=$this->call('POST', '/api/register', $data);
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'email' => ['The email has already been taken.'],
         ]);

    }
    public function testItLogsInWithCorrectDetails()
    {
        $user=new User();
        $user->first_name="James";
        $user->last_name="Nwachukwu";
        $user->phone="07011111111";
        $user->email="test@gmail.com";
        $user->password=app('hash')->make('secret');
        $user->save();

        $data=[
            'email'=>'test@gmail.com',
            'password'=>'secret'
        ];

        $response=$this->call('POST', '/api/login', $data);
        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('token',$response->json());
    }

    public function testLoginFailsWithIncorrectData(){
        $user=new User();
        $user->first_name="James";
        $user->last_name="Nwachukwu";
        $user->phone="07011111111";
        $user->email="test@gmail.com";
        $user->password=app('hash')->make('secret');
        $user->save();

        $data=[
            'email'=>'test2@gmail.com',
            'password'=>'secret444'
        ];

        $response=$this->call('POST', '/api/login', $data);
        $this->assertEquals(401, $response->status());
        $this->seeJson([
            'message' => 'Invalid Email or Password',
         ]);
    }
}
