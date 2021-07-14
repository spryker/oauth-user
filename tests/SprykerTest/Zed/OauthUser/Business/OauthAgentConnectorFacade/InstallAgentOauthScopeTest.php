<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\OauthAgentConnector\Business\OauthAgentConnectorFacade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OauthScopeTransfer;
use Spryker\Zed\OauthUser\OauthAgentConnectorConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group OauthUser  * @group Business
 * @group OauthAgentConnectorFacade
 * @group InstallAgentOauthScopeTest
 * Add your own group annotations below this line
 */
class InstallAgentOauthScopeTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\OauthAgentConnector\OauthAgentConnectorBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testInstallAgentOauthScopeWillInitAgentScopes(): void
    {
        // Arrange
        $agentScopeIdentifier = current((new OauthAgentConnectorConfig())->getAgentScopes());
        $oauthScopeTransfer = (new OauthScopeTransfer())->setIdentifier($agentScopeIdentifier);

        // Act
        $this->tester->getFacade()->installAgentOauthScope();

        // Assert
        $agentOauthScopeTransfer = $this->tester->getLocator()->oauth()->facade()
            ->findScopeByIdentifier($oauthScopeTransfer);
        $this->assertNotNull($agentOauthScopeTransfer, 'Installed scopes should be findable by identifier.');
    }
}
