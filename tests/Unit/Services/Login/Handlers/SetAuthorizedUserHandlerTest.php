<?php

namespace Tests\Unit\Services\Login\Handlers;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;
use App\Services\Users\Login\Handlers\SetAuthorizedUserHandler;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\UserAuthService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SetAuthorizedUserHandlerTest extends TestCase
{
    protected UserRepository $userRepository;
    protected UserAuthService $userAuthService;
    protected SetAuthorizedUserHandler $setAuthorizedUserHandler;
    protected LoginDTO $loginDTO;
    protected UserIterator $userIterator;


    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userAuthService = $this->createMock(UserAuthService::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->setAuthorizedUserHandler = new SetAuthorizedUserHandler(
            $this->userRepository,
            $this->userAuthService,
        );
        $this->loginDTO = $this->createMock(LoginDTO::class);
        $this->user = $this->createMock(UserIterator::class);
    }

    public function testValidData(): void
    {
        $userId = 1;

        $this->userRepository
            ->expects(self::once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn($this->user);

        $this->userAuthService
            ->expects(self::once())
            ->method('getUserId')
            ->willReturn($userId);

        $this->loginDTO
            ->expects(self::once())
            ->method('setUser')
            ->with($this->user);

        $result = $this->setAuthorizedUserHandler->handle($this->loginDTO, function ($loginDTO) {
            return $loginDTO;
        });

        $this->assertInstanceOf(UserIterator::class, $result->getUser());
    }
}
