<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 03:34 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\GrupoVulnerable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GruposVulnerables extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('numero' => '1', 'grupo' => 'Contactos de casos TB BAAR+'),
            array('numero' => '2', 'grupo' => 'Exreclusos u reclusos penitenciarios'),
            array('numero' => '3', 'grupo' => 'Personas viviendo con el VIH u otras inmunodepresiones'),
            array('numero' => '4', 'grupo' => 'Niños menores de 5 años y adultos mayores o iguales a 60 años'),
            array('numero' => '5', 'grupo' => 'Alcohólicos'),
            array('numero' => '6', 'grupo' => 'Diabéticos'),
            array('numero' => '7', 'grupo' => 'Desnutridos'),
            array('numero' => '8', 'grupo' => 'Personas con otras enfermedades crónicas(asma, EPOC, insuficiencia renal, u otras)'),
            array('numero' => '9', 'grupo' => 'Casos sociales y económicamente vulnerables: vagabundos , drogadictos y residentes en asentamientos críticos'),
            array('numero' => '10', 'grupo' => 'Persona en unidades de salud con internamiento prolongado(hogares de ancianos y centros psicopedagógicos)'),
            array('numero' => '11', 'grupo' => 'Personas con lesiones radiográficas pulmonares antiguas'),
            array('numero' => '12', 'grupo' => 'Colaboradores cubanos que prestan servicios en países de mediana y alta carga de TB'),
            array('numero' => '13', 'grupo' => 'Extranjeros residentes en paíse de madiana y alta carga de TB'),
            array('numero' => '14', 'grupo' => 'Trabajadores del sector de Salud relacionados con la atención a pacientes'),
            array('numero' => '15', 'grupo' => 'Mineros'),
            array('numero' => '16', 'grupo' => 'Fumadores'),
            array('numero' => '17', 'grupo' => 'Ninguno'),
        );

        foreach ($data as $rec) {
            $grupoVulnerable = new GrupoVulnerable();
            $grupoVulnerable->setNumero($rec['numero']);
            $grupoVulnerable->setGrupo($rec['grupo']);
            $manager->persist($grupoVulnerable);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }


}