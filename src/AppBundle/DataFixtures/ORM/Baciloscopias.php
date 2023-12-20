<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 04:40 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Baciloscopia;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Baciloscopias extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('clasificacion' => '0', 'descripcion' => 'Ningún BAAR en las cuatro líneas'),
            array('clasificacion' => '1', 'descripcion' => '1 BAAR en las cuatro líneas recorridas'),
            array('clasificacion' => '2', 'descripcion' => '2 BAAR en las cuatro líneas recorridas'),
            array('clasificacion' => '3', 'descripcion' => '3 BAAR en las cuatro líneas recorridas'),
            array('clasificacion' => '4', 'descripcion' => '4 BAAR en las cuatro líneas recorridas'),
            array('clasificacion' => '5', 'descripcion' => '5 BAAR en las cuatro líneas recorridas'),
            array('clasificacion' => '6', 'descripcion' => 'De 6 a 25 BAAR en  las cuatro líneas recorridas'),
            array('clasificacion' => '7', 'descripcion' => '25 o más BAAR  en las cuatro líneas recorridas'),
            array('clasificacion' => '8', 'descripcion' => '25 o más BAAR en una línea recorrida'),
            array('clasificacion' => '9', 'descripcion' => 'BAAR en la mayoría de los campos'),
        );

        foreach ($data as $rec) {
            $baciloscopia = new Baciloscopia();
            $baciloscopia->setClasificacion($rec['clasificacion']);
            $baciloscopia->setDescripcion($rec['descripcion']);
            $manager->persist($baciloscopia);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }


}