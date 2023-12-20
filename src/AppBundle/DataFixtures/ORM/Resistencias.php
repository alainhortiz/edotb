<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 08/11/2017
 * Time: 03:20 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Resistencia;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Resistencias extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('clasificacion' => 'RR', 'descripcion' => 'Resistencia a la Rifampicina'),
            array('clasificacion' => 'MDR', 'descripcion' => 'Multidrogorresistencia'),
            array('clasificacion' => 'MR', 'descripcion' => 'Monorresistente'),
            array('clasificacion' => 'XDR', 'descripcion' => 'Extensamente resistente'),
            array('clasificacion' => 'Ninguna', 'descripcion' => 'No es resistente'),
            array('clasificacion' => 'Desconocida', 'descripcion' => 'Se desconoce'),
        );

        foreach ($data as $rec) {
            $resis = new Resistencia();
            $resis->setClasificacion($rec['clasificacion']);
            $resis->setDescripcion($rec['descripcion']);
            $manager->persist($resis);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 16;
    }
}