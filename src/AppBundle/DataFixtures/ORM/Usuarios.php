<?php
/**
 * Created by PhpStorm.
 * User: yayi
 * Date: 10/07/2017
 * Time: 17:55
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class Usuarios extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rec = new Usuario();
        $rec->setUsername('system');
        $rec->setNombre('Yadrian');
        $rec->setPrimerApellido('Esteris');
        $rec->setSegundoApellido('Guevara');

        $areaSalud = $manager->getRepository('AppBundle:AreaSalud')->findOneBy(array('codigo' => '2101001'));
        $rec->setAreaSalud($areaSalud);

        $recrol = $manager->getRepository('AppBundle:Role')->findOneBy(array('nombre' => 'ROLE_SUPERUSUARIO'));
        $rec->addUsuarioRole($recrol);

        $nivel = $manager->getRepository('AppBundle:NivelAcceso')->findOneBy(array('nivel' => 'nacional'));
        $rec->setNivelAcceso($nivel);

        $encoder = new BCryptPasswordEncoder(12);
        $encoded = $encoder->encodePassword('123456', null);
        $rec->setPassword($encoded);

        $manager->persist($rec);
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }


}