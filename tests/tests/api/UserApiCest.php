<?php

namespace tests\api;

use ApiTester;
use Faker\Factory;

class UserApiCest
{
    private $authToken;
    private $faker;

    /**
     * @throws \Exception
     */
    public function _before(ApiTester $I)
    {
        $this->faker = Factory::create();
        $response = $I->sendPOST(env('API_UNIT_TEST') . '/user/login', [
            'username' => 'daominhhung2203@gmail.com',
            'password' => '123123123'
        ]);
        $I->seeResponseCodeIs(200);
        $this->authToken = $I->grabDataFromResponseByJsonPath('$.data.data.access_token')[0];
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
    }

    public function _after(ApiTester $I)
    {

    }

    public function index(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
        $I->sendGET(env('API_UNIT_TEST') . '/user');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*].*');
    }

    public function login(ApiTester $I)
    {
        $I->sendPOST(env('API_UNIT_TEST') . '/user/login', [
            'username' => 'daominhhung1@gmail.com',
            'password' => '123123123',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*]');
    }

    public function register(ApiTester $I)
    {
        $I->sendPOST(env('API_UNIT_TEST') . '/user/register', [
            'username' => 'daominhhung2203@gmail.com',
            'password' => '123123123',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*]');
    }

    public function logout(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
        $I->sendPOST(env('API_UNIT_TEST') . '/user/logout?id=35');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data');
    }
//
//    public function updateUser(ApiTester $I)
//    {
//        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
//        $I->sendPUT(env('API_UNIT_TEST') . 'users/user/update-user/?id=1', [
//            'name' => $this->faker->name,
//            'email' => $this->faker->email,
//        ]);
//        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
//        $I->seeResponseIsJson();
//        $I->seeResponseJsonMatchesJsonPath('$.data');
//    }

}