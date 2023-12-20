<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CategoriaPregunta;

/**
 * CategoriaPreguntaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriaPreguntaRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarCategoriaPregunta($data)
    {
        try{
            $em = $this->getEntityManager();
            $categoriaPregunta = new CategoriaPregunta();
            $categoriaPregunta->setNombre($data['nombre']);

            $em->persist($categoriaPregunta);
            $em->flush();
            $msg = $categoriaPregunta;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'La categoría de pregunta ya existe, no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar la categoría de pregunta';
            }
        }

        return $msg;
    }

    public function modificarCategoriaPregunta($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $categoriaPregunta = $em->getRepository('AppBundle:CategoriaPregunta')->find($data['idCategoriaPregunta']);
            $categoriaPregunta->setNombre($data['nombre']);

            $em->persist($categoriaPregunta);
            $em->flush();
            $msg = $categoriaPregunta;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la categoría de pregunta';
        }

        return $msg;
    }

    public function eliminarCategoriaPregunta($id)
    {
        try {
            $em = $this->getEntityManager();
            $categoriaPregunta = $em->getRepository('AppBundle:CategoriaPregunta')->find($id);

            $em->remove($categoriaPregunta);
            $em->flush();
            $msg = $categoriaPregunta;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen preguntas asociadas a esta categoría, no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar la categoría de pregunta';
            }
        }
        return $msg;
    }

}
