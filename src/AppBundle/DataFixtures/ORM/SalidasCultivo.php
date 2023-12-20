<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 22/01/2018
 * Time: 11:15 AM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\SalidaCultivo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SalidasCultivo extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('salida' => 'Complejo Mycobacterium tuberculosis'),
            array('salida' => 'Micobacteria no tuberculosa'),
            array('salida' => 'Contaminado'),
            array('salida' => 'No realizado'),
            array('salida' => 'Negativo'),
        );

        foreach ($data as $rec) {
            $salidaCultivo = new SalidaCultivo();
            $salidaCultivo->setSalida($rec['salida']);
            $manager->persist($salidaCultivo);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 17;
    }


}