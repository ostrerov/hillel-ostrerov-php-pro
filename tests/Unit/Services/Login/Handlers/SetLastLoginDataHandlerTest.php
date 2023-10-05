<?php

namespace Tests\Unit\Services\Login\Handlers;

use App\Repositories\LastLoginData\LastLoginDataRepository;
use App\Repositories\Users\Iterators\UserIterator;
use App\Services\RequestService;
use App\Services\Users\Login\Handlers\SetLastLoginDataHandler;
use App\Services\Users\Login\LoginDTO;
use Carbon\Carbon;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SetLastLoginDataHandlerTest extends TestCase
{

    protected LastLoginDataRepository $lastLoginDataRepository;
    protected RequestService $requestService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->lastLoginDataRepository = $this->createMock(LastLoginDataRepository::class);
        $this->requestService = $this->createMock(RequestService::class);
    }

    public function testLastLoginDataHandler(): void
    {

        $userIp = '127.0.0.1';

        $user = new UserIterator((object)[
            'id'        => 1,
            'name'      => 'Test',
            'email'     => 'test@test.loc',
            'created_at' => Carbon::now(),
        ]);

        $DTO = new LoginDTO('test@test.loc', 'secret');
        $DTO->setUser($user);

        $this->lastLoginDataRepository
            ->expects(self::once())
            ->method('store');

        $this->requestService
            ->expects(self::once())
            ->method('getIp')
            ->willReturn($userIp);

        $handler = new SetLastLoginDataHandler(
            $this->lastLoginDataRepository,
            $this->requestService,
        );

        $result = $handler->handle($DTO, function ($DTO) {
            return $DTO;
        });

        $this->assertSame($result, $DTO);
    }
}
