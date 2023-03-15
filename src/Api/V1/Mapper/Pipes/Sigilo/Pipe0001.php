<?php

declare(strict_types=1);
/**
 * /src/Api/V1/Pipes/Sigilo/Pipe0001.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Api\V1\Mapper\Pipes\Sigilo;

use Exception;
use SuppCore\AdministrativoBackend\Api\V1\DTO\Sigilo as SigiloDTO;
use SuppCore\AdministrativoBackend\Api\V1\Resource\VinculacaoPessoaUsuarioResource;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Entity\Sigilo as SigiloEntity;
use SuppCore\AdministrativoBackend\Mapper\Pipes\PipeInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class Pipe0001.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
class Pipe0001 implements PipeInterface
{
    protected AuthorizationCheckerInterface $authorizationChecker;

    protected RequestStack $requestStack;

    protected TokenStorageInterface $tokenStorage;

    protected VinculacaoPessoaUsuarioResource $vinculacaoPessoaUsuarioResource;

    /**
     * Pipe0001 constructor.
     */
    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage,
        VinculacaoPessoaUsuarioResource $vinculacaoPessoaUsuarioResource
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->vinculacaoPessoaUsuarioResource = $vinculacaoPessoaUsuarioResource;
    }

    public function supports(): array
    {
        return [
            SigiloDTO::class => [
                'onCreateDTOFromEntity',
            ],
        ];
    }

    /**
     * @param SigiloDTO|RestDtoInterface|null $restDto
     * @param SigiloEntity|EntityInterface    $entity
     *
     * @throws Exception
     */
    public function execute(?RestDtoInterface &$restDto, EntityInterface $entity): void
    {
        // não tem request
        if (!$this->requestStack->getCurrentRequest()) {
            return;
        }

        $processo = ($entity->getProcesso() !== null) ? $entity->getProcesso() :
            $entity->getDocumento()?->getJuntadaAtual()?->getVolume()?->getProcesso();

        // não tem direito de ver o processo
        if ((false === $this->authorizationChecker
                    ->isGranted('VIEW', $processo)) ||
            ($processo->getClassificacao() &&
                (false === $this->authorizationChecker
                        ->isGranted('VIEW', $processo->getClassificacao())))
        ) {
            $restDto = new SigiloDTO();
            $restDto->setId($entity->getId());

            return;
        }

        // é usuário interno
        if ($this->authorizationChecker->isGranted('ROLE_COLABORADOR')) {
            return;
        }

        // é usuário externo, mas o processo tem visibilidade externa
        if ($entity->getProcesso()->getVisibilidadeExterna()) {
            return;
        }

        // é usuário externo e tem chave de acesso
        if ((null !== $this->requestStack->getCurrentRequest()->get('context'))) {
            $context = json_decode($this->requestStack->getCurrentRequest()->get('context'));
            if (isset($context->chaveAcesso) &&
                (null !== $context->chaveAcesso) &&
                ($context->chaveAcesso
                    === $entity->getProcesso()->getChaveAcesso())) {
                return;
            }
        }

        $restDto = new SigiloDTO();
        $restDto->setId($entity->getId());
    }

    public function getOrder(): int
    {
        return 1;
    }
}
