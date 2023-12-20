<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 10/10/2017
 * Time: 12:02 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Roles extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $roles = array(
            array('nombre' => 'ROLE_SUPERUSUARIO'),
            array('nombre' => 'ROLE_ADMINISTRADOR'),
            array('nombre' => 'ROLE_EDITOR_ESTADISTICA'),
            array('nombre' => 'ROLE_EDITOR_LABORATORIO'),
            array('nombre' => 'ROLE_VISUALIZADOR'),
        );

        foreach ($roles as $role) {
            $rol = new Role();
            $rol->setNombre($role['nombre']);
            $manager->persist($rol);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}