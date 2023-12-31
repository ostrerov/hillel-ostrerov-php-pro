<?php

namespace Tests\Unit\Services\Login\Handlers;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\WhiteList\WhiteListIpRepository;
use App\Services\RequestService;
use App\Services\Users\Login\Handlers\CheckWhiteListIpHandler;
use App\Services\Users\Login\LoginDTO;
use Carbon\Carbon;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CheckWhiteListIpHandlerTest extends TestCase
{
    protected WhiteListIpRepository $whiteListIpRepository;
    protected LoginDTO $DTO;
    protected UserIterator $user;
    protected RequestService $requestService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->user = $this->createMock(UserIterator::class);
        $this->requestService = $this->createMock(RequestService::class);
        $this->whiteListIpRepository = $this->createMock(WhiteListIpRepository::class);
    }

    public function testValidData(): void
    {
        $userId = 1;
        $userIp = '127.0.0.1';


        $user = new UserIterator((object)[
            'id' => $userId,
            'name' => 'test',
            'email' => 'test@test.loc',
            'created_at' => Carbon::now(),
        ]);

        $DTO = new LoginDTO('test@test.loc', 'secret');
        $DTO->setUser($user);

        $this->whiteListIpRepository
            ->expects(self::once())
            ->method('existByUserIdAndIp')
            ->with($userId, $userIp)
            ->willReturn(true);

        $this->requestService
            ->expects(self::once())
            ->method('getIp')
            ->willReturn($userIp);

        $handler = new CheckWhiteListIpHandler($this->whiteListIpRepository, $this->requestService);

        $result = $handler->handle($DTO, function ($DTO) {
            return $DTO;
        });

        $this->assertSame($DTO, $result);
    }

    public function testInvalidData(): void
    {
        $userId = 2;
        $userIp = '127.0.0.2';


        $user = new UserIterator((object)[
            'id' => $userId,
            'name' => 'test2',
            'email' => 'test2@test.loc',
            'created_at' => Carbon::now(),
        ]);

        $DTO = new LoginDTO('test@test.loc', 'secret');
        $DTO->setUser($user);

        $this->whiteListIpRepository
            ->expects(self::once())
            ->method('existByUserIdAndIp')
            ->with($userId, $userIp)
            ->willReturn(false);

        $this->requestService
            ->expects(self::once())
            ->method('getIp')
            ->willReturn($userIp);

        $handler = new CheckWhiteListIpHandler($this->whiteListIpRepository, $this->requestService);

        $result = $handler->handle($DTO, function ($DTO) {
            return $DTO;
        });

        $this->assertSame($result, $DTO);
    }
}
