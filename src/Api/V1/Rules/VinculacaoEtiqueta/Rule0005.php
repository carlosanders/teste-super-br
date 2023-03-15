<?php

/** @noinspection PhpUndefinedClassInspection */
declare(strict_types=1);
/**
 * /src/Api/V1/Rules/VinculacaoEtiqueta/Rule0005.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Api\V1\Rules\VinculacaoEtiqueta;

use SuppCore\AdministrativoBackend\Api\V1\DTO\VinculacaoEtiqueta as VinculacaoEtiquetaDTO;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Entity\Usuario;
use SuppCore\AdministrativoBackend\Entity\VinculacaoEtiqueta as VinculacaoEtiquetaEntity;
use SuppCore\AdministrativoBackend\Rules\Exceptions\RuleException;
use SuppCore\AdministrativoBackend\Rules\RuleInterface;
use SuppCore\AdministrativoBackend\Rules\RulesTranslate;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class Rule0005.
 *
 * @descSwagger=O usuário não tem direito de criar ou editar a etiqueta do documento
 * @classeSwagger=Rule0005
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
class Rule0005 implements RuleInterface
{
    private RulesTranslate $rulesTranslate;
    private AuthorizationCheckerInterface $authorizationChecker;
    private TokenStorageInterface $tokenStorage;

    /**
     * Rule0005 constructor.
     */
    public function __construct(
        RulesTranslate $rulesTranslate,
        AuthorizationCheckerInterface $authorizationChecker,
        TokenStorageInterface $tokenStorage
    ) {
        $this->rulesTranslate = $rulesTranslate;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    public function supports(): array
    {
        return [
            VinculacaoEtiquetaDto::class => [
                'beforeCreate',
                'beforeUpdate',
                'beforePatch',
            ],
        ];
    }

    /**
     * @param VinculacaoEtiquetaDto|RestDtoInterface|null $restDto
     * @param VinculacaoEtiquetaEntity|EntityInterface    $entity
     *
     * @throws RuleException
     */
    public function validate(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): bool
    {
        if ($restDto->getDocumento() &&
            $this->tokenStorage->getToken() &&
            $this->tokenStorage->getToken()->getUser()) {
            /** @var Usuario $usuario */
            $usuario = $this->tokenStorage->getToken()->getUser();
            $documento = $restDto->getDocumento();
            // usuário externo? Não pode.
            if (!$usuario->getColaborador()) {
                $this->rulesTranslate->throwException('vinculacao_etiqueta', '0005');
            }
            // pode editar?
            if (false === $this->authorizationChecker->isGranted('EDIT', $documento)) {
                $this->rulesTranslate->throwException('vinculacao_etiqueta', '0005');
            }

            $processo = $documento->getJuntadaAtual()?->getVolume()->getProcesso();
            if ($documento->getJuntadaAtual() &&
                (
                (false === $this->authorizationChecker->isGranted('EDIT', $processo)) ||
                ($processo->getClassificacao() &&
                        $processo->getClassificacao()->getId() &&
                        (false === $this->authorizationChecker->isGranted('EDIT', $processo->getClassificacao()))
                ))) {
                $this->rulesTranslate->throwException('vinculacao_etiqueta', '0005');
            }
        }

        return true;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
