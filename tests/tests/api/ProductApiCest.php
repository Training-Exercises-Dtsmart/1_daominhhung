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
        $I->sendGET(env('API_UNIT_TEST') . '/product');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*].*');
    }

    public function create(ApiTester $I)
    {
        $I->sendPOST(env('API_UNIT_TEST') . '/product/create', [
            'name' => $this->faker->word,
            'image' => 'default.png',
            'price' => '24000000',
            'stock' => '100',
            'description' => $this->faker->sentence,
            'category_id' => '1',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.data[*]');
    }

    public function update(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
        $I->sendPUT(env('API_UNIT_TEST') . '/product/update?id=58', [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data');
    }

        public function delete(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
        $I->sendDelete(env('API_UNIT_TEST') . '/product/delete?id=58');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data');
    }

    public function search(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->authToken);
        $searchQuery = 'Iphone15'; // Adjust according to your needs
        $I->sendGET(env('API_UNIT_TEST') . '/product?search=' . $searchQuery);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => true]);
    }

}