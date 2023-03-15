<?php

declare(strict_types=1);
/**
 * /src/Document/ModalidadeGeneroPessoa.php.
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */

namespace SuppCore\AdministrativoBackend\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class ModalidadeGeneroPessoa.
 *
 * @ES\ObjectType()
 *
 * @author Advocacia-Geral da União <supp@agu.gov.br>
 */
class ModalidadeGeneroPessoa
{
    /**
     * @ES\Id()
     */
    protected int $id;

    /**
     * @ES\Property(type="text", analyzer="string_analyzer")
     */
    protected string $valor;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ModalidadeGeneroPessoa
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getValor(): string
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     *
     * @return ModalidadeGeneroPessoa
     */
    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
