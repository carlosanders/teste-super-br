<?php

declare(strict_types=1);
/**
 * /src/Api/V1/Triggers/Notificacao/Trigger0003.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Api\V1\Triggers\Notificacao;

use Exception;
use SuppCore\AdministrativoBackend\Api\V1\Resource\NotificacaoResource;
use SuppCore\AdministrativoBackend\Counter\Message\PushMessage;
use SuppCore\AdministrativoBackend\DTO\RestDtoInterface;
use SuppCore\AdministrativoBackend\Entity\EntityInterface;
use SuppCore\AdministrativoBackend\Entity\Notificacao as NotificacaoEntity;
use SuppCore\AdministrativoBackend\Transaction\TransactionManager;
use SuppCore\AdministrativoBackend\Triggers\TriggerInterface;

/**
 * Class Trigger0003.
 *
 * @descSwagger=Faz o push da quantidade de notificações pendentes de leitura do destinatário após apagar!
 * @classeSwagger=Trigger0003
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
class Trigger0003 implements TriggerInterface
{
    private TransactionManager $transactionManager;

    /**
     * Trigger0010 constructor.
     */
    public function __construct(
        TransactionManager $transactionManager
    ) {
        $this->transactionManager = $transactionManager;
    }

    public function supports(): array
    {
        return [
            NotificacaoEntity::class => [
                'afterDelete',
            ],
        ];
    }

    /**
     * @param NotificacaoEntity|EntityInterface $entity
     *
     * @throws Exception
     */
    public function execute(?RestDtoInterface $restDto, EntityInterface $entity, string $transactionId): void
    {
        $pushMessage = new PushMessage();
        $pushMessage->setIdentifier('notificacoes_pendentes');
        $pushMessage->setChannel(
            $entity->getDestinatario()->getUsername()
        );
        $pushMessage->setResource(
            NotificacaoResource::class
        );
        $pushMessage->setCriteria(
            [
                'destinatario.username' => 'eq:'.$entity->getDestinatario()->getUsername(),
                'dataHoraLeitura' => 'isNull',
            ]
        );

        $this->transactionManager->addAsyncDispatch($pushMessage, $transactionId);
    }

    public function getOrder(): int
    {
        return 1000;
    }
}
