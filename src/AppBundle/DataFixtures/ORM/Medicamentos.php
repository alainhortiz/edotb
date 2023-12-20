<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 10/10/2017
 * Time: 02:20 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\MedicamentoPrimeraLinea;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Medicamentos extends  AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('nombre' => 'Isoniazida'),
            array('nombre' => 'Rifampicina'),
            array('nombre' => 'Etambutol'),
            array('nombre' => 'Pirazinamida'),
        );

        foreach ($data as $rec) {
            $medicamento = new MedicamentoPrimeraLinea();
            $medicamento->setNombre($rec['nombre']);
            $medicamento->setModulo('Registro de Casos');
            $manager->persist($medicamento);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}