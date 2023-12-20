<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 04:11 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\TipoEnfermo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TiposEnfermo extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('tipo' => 'Nuevo'),
            array('tipo' => 'Recaída'),
            array('tipo' => 'Fracaso terapéutico'),
            array('tipo' => 'Pérdida al seguimiento'),
        );

        foreach ($data as $rec) {
            $tipoEnfermo = new TipoEnfermo();
            $tipoEnfermo->setTipo($rec['tipo']);
            $manager->persist($tipoEnfermo);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 13;
    }

}