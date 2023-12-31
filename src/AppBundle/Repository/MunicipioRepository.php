<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Municipio;

/**
 * MunicipioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MunicipioRepository extends \Doctrine\ORM\EntityRepository
{
    public function listarMunicipios($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();

        if($nivelAcceso == 'nacional')
        {
            $dql = 'SELECT m FROM AppBundle:Municipio m ';
            $query = $em->createQuery($dql);
            $municipios = $query->getResult();
        }
        elseif($nivelAcceso == 'provincial')
        {
            $provincia = $user->getAreaSalud()->getMunicipio()->getProvincia()->getCodigo();
            $dql = 'SELECT m FROM AppBundle:Municipio m JOIN m.provincia p
                    WHERE p.codigo = :codigo';
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $provincia);
            $municipios = $query->getResult();
        }
        else
        {
            $municipios = 'mi municipio';
        }
        return $municipios;
    }

    public function  agregarMunicipio($data)
    {
        try{
            $em = $this->getEntityManager();
            $municipio = new Municipio();
            $municipio->setNombre($data['nombre']);
            $municipio->setCodigo($data['codigo']);

            $provincia  = $em->getRepository('AppBundle:Provincia')->find($data['idProvincia']);
            $municipio->setProvincia($provincia);

            $em->persist($municipio);
            $em->flush();
            $msg = $municipio;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El municipio ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el municipio';
            }
        }

        return $msg;
    }

    public function modificarMunicipio($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($data['idMunicipio']);
            $municipio->setNombre($data['nombre']);

            $provincia  = $em->getRepository('AppBundle:Provincia')->find($data['idProvincia']);
            $municipio->setProvincia($provincia);

            $em->persist($municipio);
            $em->flush();
            $msg = $municipio;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el municipio';
        }

        return $msg;
    }

    public function eliminarMunicipio($id)
    {
        try
        {
            $em = $this->getEntityManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($id);

            $em->remove($municipio);
            $em->flush();
            $msg = $municipio;

        }catch (\Exception $e){

            if(strpos($e->getMessage() , 'foreign key') > 0)
            {
                $msg = 'Existen datos asociados a este municipio , no se puede eliminar';
            }
            else
            {
                $msg = 'Se produjo un error al eliminar el municipio';
            }
        }
        return $msg;
    }
}
