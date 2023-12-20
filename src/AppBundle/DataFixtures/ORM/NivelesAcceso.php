<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 10/10/2017
 * Time: 11:49 AM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\NivelAcceso;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class NivelesAcceso extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('nivel' => 'unidad'),
            array('nivel' => 'municipal'),
            array('nivel' => 'provincial'),
            array('nivel' => 'nacional'),
        );

        foreach ($data as $rec) {
            $nivelAcceso = new NivelAcceso();
            $nivelAcceso->setNivel($rec['nivel']);
            $manager->persist($nivelAcceso);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }


}