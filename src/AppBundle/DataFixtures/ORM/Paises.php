<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 11/11/2017
 * Time: 11:56 AM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Pais;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Paises extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('codigo' => '192', 'nombre' => 'CUBA'),
        );

        foreach ($data as $rec) {
            $pais = new Pais();
            $pais->setCodigo($rec['codigo']);
            $pais->setNombre($rec['nombre']);
            $manager->persist($pais);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 14;
    }


}