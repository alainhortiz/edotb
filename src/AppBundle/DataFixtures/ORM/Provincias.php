<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 10:27 AM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Provincia;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Provincias extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('codigo' => '21', 'nombre' => 'PINAR DEL RIO'),
            array('codigo' => '22', 'nombre' => 'ARTEMISA'),
            array('codigo' => '23', 'nombre' => 'LA HABANA'),
            array('codigo' => '24', 'nombre' => 'MAYABEQUE'),
            array('codigo' => '25', 'nombre' => 'MATANZAS'),
            array('codigo' => '26', 'nombre' => 'VILLA CLARA'),
            array('codigo' => '27', 'nombre' => 'CIENFUEGOS'),
            array('codigo' => '28', 'nombre' => 'SANCTI SPIRITUS'),
            array('codigo' => '29', 'nombre' => 'CIEGO DE AVILA'),
            array('codigo' => '30', 'nombre' => 'CAMAGUEY'),
            array('codigo' => '31', 'nombre' => 'LAS TUNAS'),
            array('codigo' => '32', 'nombre' => 'HOLGUIN'),
            array('codigo' => '33', 'nombre' => 'GRANMA'),
            array('codigo' => '34', 'nombre' => 'SANTIAGO DE CUBA'),
            array('codigo' => '35', 'nombre' => 'GUANTANAMO'),
            array('codigo' => '4001', 'nombre' => 'ISLA DE LA JUVENTUD'),
        );

        foreach ($data as $rec) {
            $provincia = new Provincia();
            $provincia->setCodigo($rec['codigo']);
            $provincia->setNombre($rec['nombre']);
            $manager->persist($provincia);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}