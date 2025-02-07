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
     * @param $value
     * @return string
     */
    public function transform($value): string
    {
        /** @var Aliment $aliment */
        $aliment = $value;// je dois faire ça à cause du contrat d'interface qui impose $value en params
        if ($aliment === null) {
            return '';
        }
        return $aliment->getPrettyName();
    }

    /**
     * @param $value
     * @return Aliment
     */
    public function reverseTransform($value): Aliment
    {
        $alimentName = $value; // je dois faire ça à cause du contrat d'interface qui impose $value en params
        /** @var Aliment $aliment */
        $aliment = $this->em->getRepository(Aliment::class)->findOneBy([ 'prettyName' => $alimentName ]);
        return $aliment;
    }
}
