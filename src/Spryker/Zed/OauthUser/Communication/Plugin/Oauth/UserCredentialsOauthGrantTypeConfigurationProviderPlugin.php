<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthUser\Communication\Plugin\Oauth;

use Generated\Shared\Transfer\OauthGrantTypeConfigurationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\OauthExtension\Dependency\Plugin\OauthGrantTypeConfigurationProviderPluginInterface;
use Spryker\Zed\OauthUser\Business\League\Grant\UserCredentialsGrantType;
use Spryker\Zed\OauthUser\OauthUserConfig;

/**
 * @method \Spryker\Zed\OauthUser\OauthUserConfig getConfig()
 * @method \Spryker\Zed\OauthUser\Business\OauthUserFacade getFacade()
 */
class UserCredentialsOauthGrantTypeConfigurationProviderPlugin extends AbstractPlugin implements OauthGrantTypeConfigurationProviderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Returns configuration of `agent_credentials` grant type.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\OauthGrantTypeConfigurationTransfer
     */
    public function getGrantTypeConfiguration(): OauthGrantTypeConfigurationTransfer
    {
        return (new OauthGrantTypeConfigurationTransfer())
            ->setIdentifier(OauthUserConfig::GRANT_TYPE_USER_CREDENTIALS)
            ->setFullyQualifiedClassName(UserCredentialsGrantType::class);
    }
}
