<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 18/11/2017
 * Time: 11:00 AM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\PruebaSensibilidad;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PruebasSensibilidad extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('nombre' => 'Método de la Nitrasa - Medio Sólido'),
            array('nombre' => 'Metodo Proporcional - Medio Sólido'),
            array('nombre' => 'Genotype MTBDRplus - Medio Líquido'),
            array('nombre' => 'Ninguna'),
            array('nombre' => 'Genotype MTBDRsl - Medio Líquido'),
        );

        foreach ($data as $rec) {
            $prueba = new PruebaSensibilidad();
            $prueba->setNombre($rec['nombre']);
            $manager->persist($prueba);
        }

        $manager->flush();
    }

    public function getOrder()
    {
       return 12;
    }


}