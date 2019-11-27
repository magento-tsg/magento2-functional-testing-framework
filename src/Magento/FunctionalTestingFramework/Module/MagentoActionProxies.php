<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\FunctionalTestingFramework\Module;

use Codeception\Module as CodeceptionModule;
use Magento\FunctionalTestingFramework\DataGenerator\Handlers\PersistedObjectHandler;
use Magento\FunctionalTestingFramework\DataGenerator\Handlers\CredentialStore;
use Magento\FunctionalTestingFramework\Exceptions\TestFrameworkException;

/**
 * Class MagentoActionProxies
 *
 * Contains all proxy functions whose corresponding MFTF actions need to be accessible for AcceptanceTester $I
 *
 * @package Magento\FunctionalTestingFramework\Module
 */
class MagentoActionProxies extends CodeceptionModule
{
    /**
     * PersistedObjectHandler instance
     *
     * @var PersistedObjectHandler
     */
    private static $persistHandler = null;

    /**
     * Create an entity
     *
     * @param string $key                 StepKey of the createData action.
     * @param string $scope
     * @param string $entity              Name of xml entity to create.
     * @param array  $dependentObjectKeys StepKeys of other createData actions that are required.
     * @param array  $overrideFields      Array of FieldName => Value of override fields.
     * @param string $storeCode
     * @return void
     */
    public function createEntity(
        $key,
        $scope,
        $entity,
        $dependentObjectKeys = [],
        $overrideFields = [],
        $storeCode = ''
    ) {
        if (!self::$persistHandler) {
            self::$persistHandler = PersistedObjectHandler::getInstance();
        }

        self::$persistHandler->createEntity(
            $key,
            $scope,
            $entity,
            $dependentObjectKeys,
            $overrideFields,
            $storeCode
        );
    }

    /**
     * Retrieves and updates a previously created entity
     *
     * @param string $key                 StepKey of the createData action.
     * @param string $scope
     * @param string $updateEntity        Name of the static XML data to update the entity with.
     * @param array  $dependentObjectKeys StepKeys of other createData actions that are required.
     * @return void
     */
    public function updateEntity($key, $scope, $updateEntity, $dependentObjectKeys = [])
    {
        if (!self::$persistHandler) {
            self::$persistHandler = PersistedObjectHandler::getInstance();
        }

        self::$persistHandler->updateEntity(
            $key,
            $scope,
            $updateEntity,
            $dependentObjectKeys
        );
    }

    /**
     * Performs GET on given entity and stores entity for use
     *
     * @param string  $key                 StepKey of getData action.
     * @param string  $scope
     * @param string  $entity              Name of XML static data to use.
     * @param array   $dependentObjectKeys StepKeys of other createData actions that are required.
     * @param string  $storeCode
     * @param integer $index
     * @return void
     */
    public function getEntity($key, $scope, $entity, $dependentObjectKeys = [], $storeCode = '', $index = null)
    {
        if (!self::$persistHandler) {
            self::$persistHandler = PersistedObjectHandler::getInstance();
        }

        self::$persistHandler->getEntity(
            $key,
            $scope,
            $entity,
            $dependentObjectKeys,
            $storeCode,
            $index
        );
    }

    /**
     * Retrieves and deletes a previously created entity
     *
     * @param string $key   StepKey of the createData action.
     * @param string $scope
     * @return void
     */
    public function deleteEntity($key, $scope)
    {
        if (!self::$persistHandler) {
            self::$persistHandler = PersistedObjectHandler::getInstance();
        }

        self::$persistHandler->deleteEntity($key, $scope);
    }

    /**
     * Retrieves a field from an entity, according to key and scope given
     *
     * @param string $stepKey
     * @param string $field
     * @param string $scope
     * @return string
     */
    public function retrieveEntityField($stepKey, $field, $scope)
    {
        if (!self::$persistHandler) {
            self::$persistHandler = PersistedObjectHandler::getInstance();
        }

        return self::$persistHandler->retrieveEntityField($stepKey, $field, $scope);
    }

    /**
     * Get encrypted value by key
     *
     * @param string $key
     * @return string|null
     * @throws TestFrameworkException
     */
    public function getSecret($key)
    {
        return CredentialStore::getInstance()->getSecret($key);
    }
}
