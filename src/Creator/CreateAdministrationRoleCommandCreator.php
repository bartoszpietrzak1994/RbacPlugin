<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Extractor\RequestAdministrationRolePermissionsExtractorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class CreateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    /** @var RequestAdministrationRolePermissionsExtractorInterface */
    private $requestAdministrationRolePermissionsExtractor;

    public function __construct(
        RequestAdministrationRolePermissionsExtractorInterface $requestAdministrationROlePermissionsExtractor
    ) {
        $this->requestAdministrationRolePermissionsExtractor = $requestAdministrationROlePermissionsExtractor;
    }

    public function fromRequest(Request $request): Command
    {
        /** @var ParameterBag $requestAttributes */
        $requestAttributes = $request->request;

        $permissions = $this->requestAdministrationRolePermissionsExtractor->extract($requestAttributes->all());

        $command = new CreateAdministrationRole(
            $requestAttributes->get('administration_role_name'),
            $permissions
        );

        return $command;
    }
}
