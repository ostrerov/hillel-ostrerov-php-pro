<?php

namespace Tests\Unit\Services\ArrayService;

use App\Services\ArrayService\ForthArrayService;
use PHPUnit\Framework\TestCase;

class ForthArrayServiceTest extends TestCase
{
    protected ForthArrayService $forthArrayService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->forthArrayService = new ForthArrayService();
    }

    /**
     * @dataProvider handleProvider
     */
    public function testHandle(array $data, int $expectedResult): void
    {
        $filteredData = $this->forthArrayService->handle($data);

        $this->assertSame($expectedResult, $filteredData);
    }

    public static function handleProvider(): array
    {
        return [
            'biggerThen25AndOddNumbers' => [
                'data' => [15, 1, 25, 26, 21, 72, 48, 80, 96, 89, 0, 100, 28, 10],
                'expectedResults' => 7
            ],

            'biggerThen25WithOddNumbersAndMixedData' => [
                'data' => ['afs', '14', 26, '72', '30', 82, 90, 91],
                'expectedResults' => 3
            ]
        ];
    }
}
