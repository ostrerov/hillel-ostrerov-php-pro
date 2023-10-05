<?php

namespace Tests\Unit\Services\Login\Handlers;

use App\Services\Users\Login\Handlers\CheckValidDataHandler;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\UserAuthService;
use PHPUnit\Framework\TestCase;

class CheckValidDataHandlerTest extends TestCase
{
    protected UserAuthService $userAuthService;
    protected CheckValidDataHandler $checkValidDataHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userAuthService = $this->createMock(UserAuthService::class);
        $this->checkValidDataHandler = new CheckValidDataHandler(
            $this->userAuthService
        );
    }

    public function testValidData(): void
    {
        $DTO = new LoginDTO('test@test.loc', 'secret');

        $this->userAuthService
            ->expects(self::once())
            ->method('authAttempt')
            ->willReturn(true);


        $result = $this->checkValidDataHandler
            ->handle($DTO, function ($DTO) {
//                echo 'closure $next works';
                return $DTO;
            });

        $this->assertSame($result, $DTO);
    }


    public function testInvalidData()
    {
        $DTO = new LoginDTO('test2@test.loc', 'secret');

        $this->userAuthService
            ->expects(self::once())
            ->method('authAttempt')
            ->willReturn(false);


        $result = $this->checkValidDataHandler
            ->handle($DTO, function ($DTO) {
                return $DTO;
            });

        $this->assertSame($result, $DTO);
    }
}
