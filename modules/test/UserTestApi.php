<?php

namespace app\modules\test;

use ApiTester;

class UserTestApi
{
    public function createUserGet(ApiTester $I)
    {
        $I->sendGet('members');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => [
                    'id'         => ['type' => 'integer'],
                    'name'       => ['type' => 'string'],
                    'started_on' => ['type' => 'string']
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }
}