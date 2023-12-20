<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 04:55 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Cultivo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Cultivos extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('clasificacion' => '0', 'descripcion' => 'Ninguna'),
            array('clasificacion' => '1', 'descripcion' => '1 colonias '),
            array('clasificacion' => '2', 'descripcion' => '2 colonias '),
            array('clasificacion' => '3', 'descripcion' => '3 colonias '),
            array('clasificacion' => '4', 'descripcion' => '4 colonias '),
            array('clasificacion' => '5', 'descripcion' => '5 colonias '),
            array('clasificacion' => '6', 'descripcion' => '6-24 colonias '),
            array('clasificacion' => '7', 'descripcion' => '25-100 colonias '),
            array('clasificacion' => '8', 'descripcion' => 'Más de 100 colonias '),
            array('clasificacion' => '9', 'descripcion' => 'Crecimiento confluente '),
        );

        foreach ($data as $rec) {
            $cultivo = new Cultivo();
            $cultivo->setClasificacion($rec['clasificacion']);
            $cultivo->setDescripcion($rec['descripcion']);
            $manager->persist($cultivo);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 8;
    }


}