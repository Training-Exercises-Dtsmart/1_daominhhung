<?php

namespace tests\unit;

use Codeception\Test\Unit;
use Codeception\Util\HttpCode;

class ApiTest extends Unit
{
    /**
     * @var \ApiTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester = $this->getModule('ApiTester');
    }

    public function testCreateUserGet()
    {
        $this->tester->sendGet('members');
        $this->tester->seeResponseCodeIs(HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');

        $validResponseJsonSchema = json_encode(
            [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'id'         => ['type' => 'integer'],
                        'name'       => ['type' => 'string'],
                        'started_on' => ['type' => 'string']
                    ],
                    'required' => ['id', 'name', 'started_on'],
                ],
            ]
        );

        $this->tester->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }
}
