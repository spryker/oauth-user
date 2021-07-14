<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthUser\Business\OauthUserProvider;

use Generated\Shared\Transfer\CustomerIdentifierTransfer;
use Generated\Shared\Transfer\OauthUserTransfer;
use Generated\Shared\Transfer\UserCriteriaTransfer;
use Spryker\Zed\OauthUser\Business\Adapter\PasswordEncoderAdapterInterface;
use Spryker\Zed\OauthUser\Dependency\Facade\OauthUserToUserFacadeInterface;
use Spryker\Zed\OauthUser\Dependency\Service\OauthUserToUtilEncodingServiceInterface;

class UserOauthUserProvider implements UserOauthUserProviderInterface
{
    /**
     * @var \Spryker\Zed\OauthUser\Dependency\Facade\OauthUserToUserFacadeInterface
     */
    protected $userFacade;

    /**
     * @var \Spryker\Zed\OauthUser\Dependency\Service\OauthUserToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \Spryker\Zed\OauthUser\Business\Adapter\PasswordEncoderAdapterInterface
     */
    protected $passwordEncoderAdapter;

    /**
     * @param \Spryker\Zed\OauthUser\Dependency\Facade\OauthUserToUserFacadeInterface $userFacade
     * @param \Spryker\Zed\OauthUser\Dependency\Service\OauthUserToUtilEncodingServiceInterface $utilEncodingService
     * @param \Spryker\Zed\OauthUser\Business\Adapter\PasswordEncoderAdapterInterface $passwordEncoderAdapter
     */
    public function __construct(
        OauthUserToUserFacadeInterface $userFacade,
        OauthUserToUtilEncodingServiceInterface $utilEncodingService,
        PasswordEncoderAdapterInterface $passwordEncoderAdapter
    ) {
        $this->userFacade = $userFacade;
        $this->utilEncodingService = $utilEncodingService;
        $this->passwordEncoderAdapter = $passwordEncoderAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\OauthUserTransfer $oauthUserTransfer
     *
     * @return \Generated\Shared\Transfer\OauthUserTransfer
     */
    public function getUserOauthUser(OauthUserTransfer $oauthUserTransfer): OauthUserTransfer
    {
        $oauthUserTransfer->setIsSuccess(false);

        $userTransfer = $this->userFacade->findUser((new UserCriteriaTransfer())->setEmail($oauthUserTransfer->getUsername()));
        if (!$userTransfer) {
            return $oauthUserTransfer;
        }

        $isAuthorized = $this->passwordEncoderAdapter->isPasswordValid(
            $userTransfer->getPassword(),
            $oauthUserTransfer->getPassword(),
            null
        );

        if (!$isAuthorized) {
            return $oauthUserTransfer;
        }

        $oauthUserTransfer
            ->setUserIdentifier($this->utilEncodingService->encodeJson(['username' => $userTransfer->getUsername()]))
            ->setIsSuccess(true);

        return $oauthUserTransfer;
    }
}
