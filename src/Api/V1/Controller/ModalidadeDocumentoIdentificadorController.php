<?php

declare(strict_types=1);
/**
 * /src/Controller/ModalidadeDocumentoIdentificadorController.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Api\V1\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SuppCore\AdministrativoBackend\Api\V1\Resource\ModalidadeDocumentoIdentificadorResource;
use SuppCore\AdministrativoBackend\Rest\Controller;
use SuppCore\AdministrativoBackend\Rest\ResponseHandler;
use SuppCore\AdministrativoBackend\Rest\Traits\Actions;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/v1/administrativo/modalidade_documento_identificador")
 *
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 *
 * @OA\Tag(name="ModalidadeDocumentoIdentificador Management")
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 *
 * @method ModalidadeDocumentoIdentificadorResource getResource()
 */
class ModalidadeDocumentoIdentificadorController extends Controller
{
    // Traits
    use Actions\User\FindOneAction;
    use Actions\User\FindAction;
    use Actions\Root\CreateAction;
    use Actions\Root\UpdateAction;
    use Actions\Root\PatchAction;
    use Actions\Root\DeleteAction;
    use Actions\Colaborador\CountAction;

/** @noinspection MagicMethodsValidityInspection */

    /**
     * ModalidadeDocumentoIdentificadorController constructor.
     */
    public function __construct(
        ModalidadeDocumentoIdentificadorResource $resource,
        ResponseHandler $responseHandler
    ) {
        $this->init($resource, $responseHandler);
    }
}
