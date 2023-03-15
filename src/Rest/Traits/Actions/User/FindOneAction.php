<?php

declare(strict_types=1);
/**
 * /src/Rest/Traits/Actions/User/FindOneAction.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Rest\Traits\Actions\User;

use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SuppCore\AdministrativoBackend\Annotation\RestApiDoc;
use SuppCore\AdministrativoBackend\Rest\Traits\Methods\FindOneMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Trait FindOneAction.
 *
 * Trait to add 'findOneAction' for REST controllers for 'ROLE_USER' users.
 *
 * @see \SuppCore\AdministrativoBackend\Rest\Traits\Methods\FindOneMethod for detailed documents.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
trait FindOneAction
{
    // Traits
    use FindOneMethod;

    /**
     * @Route(
     *      "/{id}",
     *      requirements={
     *          "id" = "\d+",
     *      },
     *      methods={"GET"},
     *  )
     *
     * @Security("is_granted('ROLE_USER')")
     *
     * @RestApiDoc()
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     *
     * @throws LogicException
     * @throws Throwable
     * @throws HttpException
     * @throws MethodNotAllowedHttpException
     */
    public function findOneAction(Request $request, int $id): Response
    {
        return $this->findOneMethod($request, $id);
    }
}
