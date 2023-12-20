<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 08/11/2017
 * Time: 03:49 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\ResultadoTratamiento;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ResultadosTratamiento extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('resultado' => 'Curado'),
            array('resultado' => 'Tratamiento completo'),
            array('resultado' => 'Fracaso al tratamiento'),
            array('resultado' => 'Fallecido'),
            array('resultado' => 'Pérdida en el seguimiento'),
            array('resultado' => 'No evaluado'),
            array('resultado' => 'Reparo de Diagnóstico'),
        );

        foreach ($data as $rec) {
            $resultado = new ResultadoTratamiento();
            $resultado->setResultado($rec['resultado']);
            $resultado->setModulo('Registro de Casos');
            $manager->persist($resultado);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 11;
    }


}