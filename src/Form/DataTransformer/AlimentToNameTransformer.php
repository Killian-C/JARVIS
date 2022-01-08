<?php


namespace App\Form\DataTransformer;


use App\Entity\Aliment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class AlimentToNameTransformer implements DataTransformerInterface
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Aliment|null $aliment
     * @return mixed|void
     */
    public function transform($aliment): string
    {
        if ($aliment === null) {
            return '';
        }
        return $aliment->getName();
    }

    /**
     * @param string $alimentName
     * @return Aliment
     */
    public function reverseTransform($alimentName): Aliment
    {
        /** @var Aliment $aliment */
        $aliment = $this->em->getRepository(Aliment::class)->findOneBy([ 'name' => $alimentName ]);
        return $aliment;
    }
}
