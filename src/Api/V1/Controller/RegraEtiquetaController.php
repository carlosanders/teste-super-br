<?php

declare(strict_types=1);
/**
 * /src/Controller/RegraEtiquetaController.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Api\V1\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SuppCore\AdministrativoBackend\Api\V1\Resource\RegraEtiquetaResource;
use SuppCore\AdministrativoBackend\Rest\Controller;
use SuppCore\AdministrativoBackend\Rest\ResponseHandler;
use SuppCore\AdministrativoBackend\Rest\Traits\Actions;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/v1/administrativo/regra_etiqueta")
 *
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 *
 * @OA\Tag(name="RegraEtiqueta")
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 *
 * @method RegraEtiquetaResource getResource()
 */
class RegraEtiquetaController extends Controller
{
    // Traits
    use Actions\Colaborador\FindOneAction;
    use Actions\Colaborador\FindAction;
    use Actions\Colaborador\CreateAction;
    use Actions\Colaborador\UpdateAction;
    use Actions\Colaborador\PatchAction;
    use Actions\Colaborador\DeleteAction;
    use Actions\Colaborador\CountAction;

/** @noinspection MagicMethodsValidityInspection */

    /**
     * RegraEtiquetaController constructor.
     */
    public function __construct(
        RegraEtiquetaResource $resource,
        ResponseHandler $responseHandler
    ) {
        $this->init($resource, $responseHandler);
    }
}
