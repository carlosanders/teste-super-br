<?php

declare(strict_types=1);
/**
 * /src/Api/V1/Rules/VinculacaoEspecieProcessoWorkflow/Rule0001.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Api\V1\Rules\VinculacaoEspecieProcessoWorkflow;

use SuppCore\AdministrativoBackend\Api\V1\DTO\VinculacaoEspecieProcessoWorkflow;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Rules\Exceptions\RuleException;
use SuppCore\AdministrativoBackend\Rules\RuleInterface;
use SuppCore\AdministrativoBackend\Rules\RulesTranslate;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class Rule0001.
 *
 * @descSwagger=Verifica se a espécie de processo é do mesmo gênero do workflow!
 * @classeSwagger=Rule0001
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
class Rule0001 implements RuleInterface
{

    /**
     * Rule0001 constructor.
     */
    public function __construct(private RulesTranslate $rulesTranslate) {
    }

    public function supports(): array
    {
        return [
            VinculacaoEspecieProcessoWorkflow::class => [
                'beforeCreate'
            ],
        ];
    }

    /**
     * @param RestDtoInterface|null $restDto
     * @param EntityInterface $entity
     * @param string $transactionId
     * @return bool
     * @throws RuleException
     */
    public function validate(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): bool
    {
        if ($restDto->getWorkflow()->getGeneroProcesso() !== $restDto->getEspecieProcesso()->getGeneroProcesso()) {
            $this->rulesTranslate->throwException('vinculacaoEspecieProcessoWorkflow', '0001');
        }

        return true;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
