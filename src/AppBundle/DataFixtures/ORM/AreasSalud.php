<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 10/10/2017
 * Time: 12:28 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\AreaSalud;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AreasSalud extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('codigo' => '2101001', 'nombre' => 'Sandino', 'municipio' => '2101'),
            array('codigo' => '2101002', 'nombre' => 'Manuel Lazo-Navarro', 'municipio' => '2101'),
            array('codigo' => '2102003', 'nombre' => 'Mantua', 'municipio' => '2102'),
            array('codigo' => '2103004', 'nombre' => 'Minas', 'municipio' => '2103'),
            array('codigo' => '2103021', 'nombre' => 'Sumidero', 'municipio' => '2103'),
            array('codigo' => '2103022', 'nombre' => 'Santa Lucía', 'municipio' => '2103'),
            array('codigo' => '2104005', 'nombre' => 'Viñales', 'municipio' => '2104'),
            array('codigo' => '2104025', 'nombre' => 'Puerto Esperanza', 'municipio' => '2104'),
            array('codigo' => '2105006', 'nombre' => 'La Palma. C. Del Norte', 'municipio' => '2105'),
            array('codigo' => '2106010', 'nombre' => 'Los Palacios', 'municipio' => '2106'),
            array('codigo' => '2106011', 'nombre' => 'San Diego', 'municipio' => '2106'),
            array('codigo' => '2107012', 'nombre' => '1ro de enero', 'municipio' => '2107'),
            array('codigo' => '2107020', 'nombre' => '5 de Septiembre', 'municipio' => '2107'),
            array('codigo' => '2108013', 'nombre' => 'Pedro Borrás', 'municipio' => '2108'),
            array('codigo' => '2108014', 'nombre' => 'Turcios Lima', 'municipio' => '2108'),
            array('codigo' => '2108015', 'nombre' => 'Raúl Sánchez', 'municipio' => '2108'),
            array('codigo' => '2108016', 'nombre' => 'Hermanos Cruz', 'municipio' => '2108'),
            array('codigo' => '2109017', 'nombre' => 'San Luis', 'municipio' => '2109'),
            array('codigo' => '2110018', 'nombre' => 'San Juan y Martínez', 'municipio' => '2110'),
            array('codigo' => '2111019', 'nombre' => 'Guane', 'municipio' => '2111'),
            array('codigo' => '2201007', 'nombre' => 'Manuel González', 'municipio' => '2201'),
            array('codigo' => '2201024', 'nombre' => 'Pablo de la Torriente Brau', 'municipio' => '2201'),
            array('codigo' => '2202001', 'nombre' => 'Orlando Santana', 'municipio' => '2202'),
            array('codigo' => '2202002', 'nombre' => 'José Trujillo', 'municipio' => '2202'),
            array('codigo' => '2203003', 'nombre' => 'Eduardo Díaz Ortega', 'municipio' => '2203'),
            array('codigo' => '2204004', 'nombre' => 'Flores Betancourt', 'municipio' => '2204'),
            array('codigo' => '2204005', 'nombre' => 'Miguel Pereira', 'municipio' => '2204'),
            array('codigo' => '2205006', 'nombre' => 'Pedro Esperón', 'municipio' => '2205'),
            array('codigo' => '2205038', 'nombre' => 'Baracoa', 'municipio' => '2205'),
            array('codigo' => '2206007', 'nombre' => 'José Hipólito de Pasos y Caballero', 'municipio' => '2206'),
            array('codigo' => '2206037', 'nombre' => 'Felipe Ismael Rodríguez Ramos', 'municipio' => '2206'),
            array('codigo' => '2207026', 'nombre' => 'José Manuel Segui', 'municipio' => '2207'),
            array('codigo' => '2208027', 'nombre' => 'Gabriel Cubria Puig', 'municipio' => '2208'),
            array('codigo' => '2209028', 'nombre' => 'Adrían Sansarig', 'municipio' => '2209'),
            array('codigo' => '2209029', 'nombre' => 'Tomás Romay', 'municipio' => '2209'),
            array('codigo' => '2209035', 'nombre' => 'Flores Betancourt', 'municipio' => '2209'),
            array('codigo' => '2209036', 'nombre' => '27 de noviembre', 'municipio' => '2209'),
            array('codigo' => '2210008', 'nombre' => 'Gilberto Marquetti', 'municipio' => '2210'),
            array('codigo' => '2211009', 'nombre' => 'Camilo Cienfuegos', 'municipio' => '2211'),
            array('codigo' => '2211023', 'nombre' => 'Santa Cruz', 'municipio' => '2211'),
        );

        foreach ($data as $rec) {
            $area = new AreaSalud();
            $area->setCodigo($rec['codigo']);
            $area->setNombre($rec['nombre']);


            $recMun = $manager->getRepository('AppBundle:Municipio')->findOneBy(array('codigo' => $rec['municipio']));
            $area->setMunicipio($recMun);
            $manager->persist($area);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }


}