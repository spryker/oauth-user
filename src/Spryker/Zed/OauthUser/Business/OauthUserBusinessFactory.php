<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthUser\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\OauthUser\Business\Adapter\PasswordEncoderAdapter;
use Spryker\Zed\OauthUser\Business\Adapter\PasswordEncoderAdapterInterface;
use Spryker\Zed\OauthUser\Business\OauthUserProvider\UserOauthUserProvider;
use Spryker\Zed\OauthUser\Business\OauthUserProvider\UserOauthUserProviderInterface;
use Spryker\Zed\OauthUser\Dependency\Facade\OauthUserToUserFacadeInterface;
use Spryker\Zed\OauthUser\Dependency\Service\OauthUserToUtilEncodingServiceInterface;
use Spryker\Zed\OauthUser\OauthUserDependencyProvider;

/**
 * @method \Spryker\Zed\OauthUser\OauthUserConfig getConfig()
 */
class OauthUserBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\OauthUser\Business\OauthUserProvider\UserOauthUserProviderInterface
     */
    public function createAgentOauthUserProvider(): UserOauthUserProviderInterface
    {
        return new UserOauthUserProvider(
            $this->getUserFacade(),
            $this->getUtilEncodingService(),
            $this->createPasswordEncoderAdapter()
        );
    }

    /**
     * @return \Spryker\Zed\OauthUser\Business\Adapter\PasswordEncoderAdapterInterface
     */
    public function createPasswordEncoderAdapter(): PasswordEncoderAdapterInterface
    {
        return new PasswordEncoderAdapter();
    }

    /**
     * @return \Spryker\Zed\OauthUser\Dependency\Facade\OauthUserToUserFacadeInterface
     */
    public function getUserFacade(): OauthUserToUserFacadeInterface
    {
        return $this->getProvidedDependency(OauthUserDependencyProvider::FACADE_USER);
    }

    /**
     * @return \Spryker\Zed\OauthUser\Dependency\Service\OauthUserToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): OauthUserToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(OauthUserDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
