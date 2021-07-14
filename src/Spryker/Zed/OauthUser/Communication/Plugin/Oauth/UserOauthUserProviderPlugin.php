<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthUser\Communication\Plugin\Oauth;

use Generated\Shared\Transfer\OauthUserTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\OauthUser\OauthAgentConnectorConfig;
use Spryker\Zed\OauthExtension\Dependency\Plugin\OauthUserProviderPluginInterface;
use Spryker\Zed\OauthUser\OauthUserConfig;

/**
 * @method \Spryker\Zed\OauthUser\Business\OauthUserFacadeInterface getFacade()
 * @method \Spryker\Zed\OauthUser\OauthUserConfig getConfig()
 */
class UserOauthUserProviderPlugin extends AbstractPlugin implements OauthUserProviderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Returns true if `user_credentials` grant type is provided.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthUserTransfer $oauthUserTransfer
     *
     * @return bool
     */
    public function accept(OauthUserTransfer $oauthUserTransfer): bool
    {
        //password grant + correct client (backend?)
        return $oauthUserTransfer->getGrantType() === OauthUserConfig::GRANT_TYPE_USER_CREDENTIALS;
    }

    /**
     * {@inheritDoc}
     * - Reads user data and provides it for access token.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthUserTransfer $oauthUserTransfer
     *
     * @return \Generated\Shared\Transfer\OauthUserTransfer
     */
    public function getUser(OauthUserTransfer $oauthUserTransfer): OauthUserTransfer
    {
        return $this->getFacade()->getUserOauthUser($oauthUserTransfer);
    }
}
