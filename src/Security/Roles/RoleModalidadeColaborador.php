<?php

declare(strict_types=1);
/**
 * /src/Security/Roles/RoleModalidadeColaborador.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Security\Roles;

use SuppCore\AdministrativoBackend\Entity\Usuario;
use SuppCore\AdministrativoBackend\Security\RoleInterface;
use SuppCore\AdministrativoBackend\Utils\StringService;

/**
 * Class RoleModalidadeColaborador.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
class RoleModalidadeColaborador implements RoleInterface
{
    /**
     * @param Usuario $usuario
     *
     * @return string|null ?string
     */
    public function getRole(Usuario $usuario): ?string
    {
        if ($usuario->getColaborador() &&
            $usuario->getColaborador()->getAtivo() &&
            $usuario->getColaborador()->getModalidadeColaborador()->getValor()
            ) {
            return 'ROLE_'.StringService::iso2upper(
                str_replace(' ', '_', $usuario->getColaborador()->getModalidadeColaborador()->getValor())
            );
        }

        return null;
    }
}
