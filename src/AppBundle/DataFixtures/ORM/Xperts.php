<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 05:04 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Xpert;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Xperts extends  AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('clasificacion' => 'T', 'descripcion' => 'MTB detectado , resistencia a rifampicina no detectada'),
            array('clasificacion' => 'RR', 'descripcion' => 'MTB detectado , resistencia a rifampicina detectada'),
            array('clasificacion' => 'TI', 'descripcion' => 'MTB detectado , resistencia a rifampicina indeterminada'),
            array('clasificacion' => 'N', 'descripcion' => 'MTB no detectado'),
            array('clasificacion' => 'I', 'descripcion' => 'Inválido / sin resultado / error'),
        );

        foreach ($data as $rec) {
            $xpert = new Xpert();
            $xpert->setClasificacion($rec['clasificacion']);
            $xpert->setDescripcion($rec['descripcion']);
            $manager->persist($xpert);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 15;
    }


}