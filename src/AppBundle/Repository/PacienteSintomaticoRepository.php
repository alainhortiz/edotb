<?php

namespace AppBundle\Repository;
use AppBundle\Entity\PacienteSintomatico;

/**
 * PacienteSintomaticoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PacienteSintomaticoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarPacienteSintomatico($data , $direccion)
    {
        try{
            $em = $this->getEntityManager();
            $paciente = new PacienteSintomatico();
            $paciente->setCarnetIdentidad($data['carnetIdentidad']);
            $paciente->setNombre($data['nombre']);
            $paciente->setPrimerApellido($data['primerApellido']);
            $paciente->setSegundoApellido($data['segundoApellido']);
            $paciente->setSexo($data['sexo']);
            $paciente->setEdad((int)$data['edad']);
            $paciente->setDireccionPaciente($direccion);

            $grupoVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->find($data['grupoVulnerable']);
            $paciente->setGrupoVulnerable($grupoVulnerable);

            $pais = $em->getRepository('AppBundle:Pais')->find($data['pais']);
            $paciente->setPais($pais);

            $paciente->setFechaEntrada(new \DateTime($data['fechaEntrada']));

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $paciente->setAreaSalud($areaSalud);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $paciente->setHospital($hospital);
            }

            $pacienteRegistrado = $em->getRepository('AppBundle:Paciente')->findOneBy(array('carnetIdentidad' => $data['carnetIdentidad']));
            $pacienteRegistrado == null ? $paciente->setProceso('analisis') : $paciente->setProceso('registrado');

            $em->persist($paciente);
            $em->flush();
            $msg = $paciente;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El Paciente ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el Paciente';
            }
        }
        return $msg;
    }

    public function modificarPacienteSintomatico($data)
    {
        try{
            $em = $this->getEntityManager();
            $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->find($data['idPaciente']);
            /*$paciente->setCarnetIdentidad($data['carnetIdentidad']);*/
            $paciente->setNombre($data['nombre']);
            $paciente->setPrimerApellido($data['primerApellido']);
            $paciente->setSegundoApellido($data['segundoApellido']);
            $paciente->setSexo($data['sexo']);
            $paciente->setEdad((int)$data['edad']);

            $grupoVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->find($data['grupoVulnerable']);
            $paciente->setGrupoVulnerable($grupoVulnerable);

            $pais = $em->getRepository('AppBundle:Pais')->find($data['pais']);
            $paciente->setPais($pais);

            $paciente->setFechaEntrada(new \DateTime($data['fechaEntrada']));

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $paciente->setAreaSalud($areaSalud);
                $paciente->setHospital(null);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $paciente->setHospital($hospital);
                $paciente->setAreaSalud(null);
            }

            $em->persist($paciente);
            $em->flush();
            $msg = $paciente;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el paciente sintomático';
        }
        return $msg;
    }

    public function eliminarPacienteSintomatico($id)
    {
        try
        {
            $em = $this->getEntityManager();
            $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->find($id);

            $em->remove($paciente);
            $em->flush();
            $msg = $paciente;

        }catch (\Exception $e){

            if(strpos($e->getMessage() , 'foreign key') > 0)
            {
                $msg = 'Existen análisis asociados a este paciente sintomático , no se puede eliminar';
            }
            else
            {
                $msg = 'Se produjo un error al eliminar el paciente sintomático';
            }
        }
        return $msg;
    }

    public function listarBaciloscopiasPacienteSintomatico($ci)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT b FROM AppBundle:ResultBaciloscopia b JOIN b.pacienteSintomatico p
                WHERE p.carnetIdentidad = :ci ORDER BY b.fecha DESC';
        $query = $em->createQuery($dql);
        $query->setParameter('ci' , $ci);
        $baciloscopias = $query->getResult();

        return $baciloscopias;
    }

    public function listarCultivosPacienteSintomatico($ci)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT cu FROM AppBundle:ResultCultivo cu JOIN cu.pacienteSintomatico p
                WHERE p.carnetIdentidad = :ci ORDER BY cu.fecha DESC';
        $query = $em->createQuery($dql);
        $query->setParameter('ci' , $ci);
        $cultivos = $query->getResult();

        return $cultivos;
    }

    public function listarXpertsPacienteSintomatico($ci)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT x FROM AppBundle:ResultXpert x JOIN x.pacienteSintomatico p
                WHERE p.carnetIdentidad = :ci ORDER BY x.fecha DESC';
        $query = $em->createQuery($dql);
        $query->setParameter('ci' , $ci);
        $xperts = $query->getResult();

        return $xperts;
    }

    public function listarMuestrasNoUtilesPacienteSintomatico($ci)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT m FROM AppBundle:MuestraNoUtil m JOIN m.pacienteSintomatico p
                WHERE p.carnetIdentidad = :ci ORDER BY m.fecha DESC';
        $query = $em->createQuery($dql);
        $query->setParameter('ci' , $ci);
        $muestras = $query->getResult();

        return $muestras;
    }

    public function totalMuestrasNoUtilesPacienteSintomatico($ci)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT SUM(m.cantidad) AS total FROM AppBundle:MuestraNoUtil m JOIN m.pacienteSintomatico p
                WHERE p.carnetIdentidad = :ci';
        $query = $em->createQuery($dql);
        $query->setParameter('ci' , $ci);
        $total = $query->getResult();

        return $total[0]['total'];
    }

    public function listarPacientesSintomaticos($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();

        if($nivelAcceso == 'nacional')
        {
            $dql = 'SELECT p FROM AppBundle:PacienteSintomatico p';
            $query = $em->createQuery($dql);
        }
        elseif($nivelAcceso == 'provincial')
        {
            if(!empty($user->getAreaSalud()))
            {
                $provincia = $user->getAreaSalud()->getMunicipio()->getProvincia()->getCodigo();
            }else{
                $provincia = $user->getHospital()->getMunicipio()->getProvincia()->getCodigo();
            }
            $dql = 'SELECT p FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a LEFT JOIN a.municipio am LEFT JOIN am.provincia ap
                    LEFT JOIN p.hospital h LEFT JOIN h.municipio hm LEFT JOIN hm.provincia hp
                    WHERE (ap.codigo = :codigo OR hp.codigo = :codigo) 
                    OR EXISTS(SELECT rb FROM AppBundle:ResultBaciloscopia rb 
                       LEFT JOIN rb.areaSalud abaci LEFT JOIN abaci.municipio ambaci LEFT JOIN ambaci.provincia apbaci 
                       LEFT JOIN rb.hospital hbaci LEFT JOIN hbaci.municipio hmbaci LEFT JOIN hmbaci.provincia hpbaci 
                       WHERE (apbaci.codigo = :codigo OR hpbaci.codigo = :codigo) AND rb.pacienteSintomatico = p.id) 
                    OR EXISTS(SELECT rc FROM AppBundle:ResultCultivo rc 
                       LEFT JOIN rc.areaSalud acult LEFT JOIN acult.municipio amcult LEFT JOIN amcult.provincia apcult
                       LEFT JOIN rc.hospital hcult LEFT JOIN hcult.municipio hmcult LEFT JOIN hmcult.provincia hpcult
                       WHERE (apcult.codigo = :codigo OR hpcult.codigo = :codigo) AND rc.pacienteSintomatico = p.id) 
                    OR EXISTS(SELECT rx FROM AppBundle:ResultXpert rx 
                       LEFT JOIN rx.areaSalud axpert LEFT JOIN axpert.municipio amxpert LEFT JOIN amxpert.provincia apxpert
                       LEFT JOIN rx.hospital hxpert LEFT JOIN hxpert.municipio hmxpert LEFT JOIN hmxpert.provincia hpxpert
                       WHERE(apxpert.codigo = :codigo OR hpxpert.codigo = :codigo) AND rx.pacienteSintomatico = p.id)';
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $provincia);
        }
        elseif($nivelAcceso == 'municipal')
        {
            if(!empty($user->getAreaSalud()))
            {
                $municipio = $user->getAreaSalud()->getMunicipio()->getCodigo();
            }else{
                $municipio = $user->getHospital()->getMunicipio()->getCodigo();
            }
            $dql = 'SELECT p FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a LEFT JOIN a.municipio am 
                    LEFT JOIN p.hospital h LEFT JOIN h.municipio hm  
                    WHERE (am.codigo = :codigo OR hm.codigo = :codigo) 
                    OR EXISTS(SELECT rb FROM AppBundle:ResultBaciloscopia rb 
                       LEFT JOIN rb.areaSalud abaci LEFT JOIN abaci.municipio ambaci 
                       LEFT JOIN rb.hospital hbaci LEFT JOIN hbaci.municipio hmbaci 
                       WHERE (ambaci.codigo = :codigo OR hmbaci.codigo = :codigo) AND rb.pacienteSintomatico = p.id) 
                    OR EXISTS(SELECT rc FROM AppBundle:ResultCultivo rc 
                       LEFT JOIN rc.areaSalud acult LEFT JOIN acult.municipio amcult 
                       LEFT JOIN rc.hospital hcult LEFT JOIN hcult.municipio hmcult 
                       WHERE (amcult.codigo = :codigo OR hmcult.codigo = :codigo) AND rc.pacienteSintomatico = p.id) 
                    OR EXISTS(SELECT rx FROM AppBundle:ResultXpert rx 
                       LEFT JOIN rx.areaSalud axpert LEFT JOIN axpert.municipio amxpert 
                       LEFT JOIN rx.hospital hxpert LEFT JOIN hxpert.municipio hmxpert 
                       WHERE(amxpert.codigo = :codigo OR hmxpert.codigo = :codigo) AND rx.pacienteSintomatico = p.id)';
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $municipio);
        }
        else
        {
            if(!empty($user->getAreaSalud()))
            {
                $areaSalud = $user->getAreaSalud()->getCodigo();
            }else{
                $areaSalud = $user->getHospital()->getCodigo();
            }
            $dql = 'SELECT p FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a 
                    LEFT JOIN p.hospital h 
                    WHERE (a.codigo = :codigo OR h.codigo = :codigo) 
                    OR EXISTS(SELECT rb FROM AppBundle:ResultBaciloscopia rb 
                       LEFT JOIN rb.areaSalud abaci 
                       LEFT JOIN rb.hospital hbaci  
                       WHERE (abaci.codigo = :codigo OR hbaci.codigo = :codigo) AND rb.pacienteSintomatico = p.id) 
                    OR EXISTS(SELECT rc FROM AppBundle:ResultCultivo rc 
                       LEFT JOIN rc.areaSalud acult  
                       LEFT JOIN rc.hospital hcult 
                       WHERE (acult.codigo = :codigo OR hcult.codigo = :codigo) AND rc.pacienteSintomatico = p.id) 
                    OR EXISTS(SELECT rx FROM AppBundle:ResultXpert rx 
                       LEFT JOIN rx.areaSalud axpert 
                       LEFT JOIN rx.hospital hxpert  
                       WHERE(axpert.codigo = :codigo OR hxpert.codigo = :codigo) AND rx.pacienteSintomatico = p.id)';
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $areaSalud);
        }
        $pacientes = $query->getResult();

        return $pacientes;
    }

    public function listarPacientesSintomaticosPendientes($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();

        if($nivelAcceso == 'nacional')
        {
            $dql =  "SELECT p FROM AppBundle:PacienteSintomatico p WHERE p.proceso = 'pendiente' ";
            $query = $em->createQuery($dql);
        }
        elseif($nivelAcceso == 'provincial')
        {
            if(!empty($user->getAreaSalud()))
            {
                $provincia = $user->getAreaSalud()->getMunicipio()->getProvincia()->getCodigo();
            }else{
                $provincia = $user->getHospital()->getMunicipio()->getProvincia()->getCodigo();
            }
            $dql = "SELECT p FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a LEFT JOIN a.municipio am LEFT JOIN am.provincia ap
                    LEFT JOIN p.hospital h LEFT JOIN h.municipio hm LEFT JOIN hm.provincia hp
                    WHERE (ap.codigo = :codigo OR hp.codigo = :codigo) AND p.proceso = 'pendiente'";
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $provincia);
        }
        elseif($nivelAcceso == 'municipal')
        {
            if(!empty($user->getAreaSalud()))
            {
                $municipio = $user->getAreaSalud()->getMunicipio()->getCodigo();
            }else{
                $municipio = $user->getHospital()->getMunicipio()->getCodigo();
            }
            $dql = "SELECT p FROM AppBundle:PacienteSintomatico p
                    LEFT JOIN p.areaSalud a LEFT JOIN a.municipio am
                    LEFT JOIN p.hospital h LEFT JOIN h.municipio hm
                    WHERE (am.codigo = :codigo OR hm.codigo = :codigo) AND p.proceso = 'pendiente'";
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $municipio);
        }
        else
        {
            if(!empty($user->getAreaSalud()))
            {
                $codigo = $user->getAreaSalud()->getCodigo();
            }else{
                $codigo = $user->getHospital()->getCodigo();
            }
            $dql = "SELECT p FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a  LEFT JOIN p.hospital h
                    WHERE (a.codigo = :codigo OR h.codigo = :codigo) AND p.proceso = 'pendiente'";
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $codigo);
        }
        $pacientes = $query->getResult();

        return $pacientes;
    }

    public function cantPendientesRegistro($user)
    {
        $em = $this->getEntityManager();
        $nivelAcceso = $user->getNivelAcceso()->getNivel();

        if($nivelAcceso == 'nacional')
        {
            $dql =  "SELECT COUNT(p.id) FROM AppBundle:PacienteSintomatico p WHERE p.proceso = 'pendiente' ";
            $query = $em->createQuery($dql);
        }
        elseif($nivelAcceso == 'provincial')
        {
            if(!empty($user->getAreaSalud()))
            {
                $provincia = $user->getAreaSalud()->getMunicipio()->getProvincia()->getCodigo();
            }else{
                $provincia = $user->getHospital()->getMunicipio()->getProvincia()->getCodigo();
            }
            $dql = "SELECT COUNT(p.id) FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a LEFT JOIN a.municipio am LEFT JOIN am.provincia ap
                    LEFT JOIN p.hospital h LEFT JOIN h.municipio hm LEFT JOIN hm.provincia hp
                    WHERE (ap.codigo = :codigo OR hp.codigo = :codigo) AND p.proceso = 'pendiente'";
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $provincia);
        }
        elseif($nivelAcceso == 'municipal')
        {
            if(!empty($user->getAreaSalud()))
            {
                $municipio = $user->getAreaSalud()->getMunicipio()->getCodigo();
            }else{
                $municipio = $user->getHospital()->getMunicipio()->getCodigo();
            }
            $dql = "SELECT COUNT(p.id) FROM AppBundle:PacienteSintomatico p
                    LEFT JOIN p.areaSalud a LEFT JOIN a.municipio am
                    LEFT JOIN p.hospital h LEFT JOIN h.municipio hm
                    WHERE (am.codigo = :codigo OR hm.codigo = :codigo) AND p.proceso = 'pendiente'";
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $municipio);
        }
        else
        {
            if(!empty($user->getAreaSalud()))
            {
                $codigo = $user->getAreaSalud()->getCodigo();
            }else{
                $codigo = $user->getHospital()->getCodigo();
            }
            $dql = "SELECT COUNT(p.id) FROM AppBundle:PacienteSintomatico p 
                    LEFT JOIN p.areaSalud a  LEFT JOIN p.hospital h
                    WHERE (a.codigo = :codigo OR h.codigo = :codigo) AND p.proceso = 'pendiente'";
            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $codigo);
        }
        $cantidad = $query->getResult();

        return !empty($cantidad) ? $cantidad[0][1] : 0;
    }

    public function buscarPacientesintomaticoPendienteRegistro($ci)
    {
        $em = $this->getEntityManager();
        $dql = 'SELECT p FROM AppBundle:PacienteSintomatico p 
                WHERE p.carnetIdentidad = :ci AND p.proceso = :p1';
        $query = $em->createQuery($dql);
        $query->setParameter('ci' , $ci);
        $query->setParameter('p1' , 'pendiente');
        $paciente = $query->getResult();

        return $paciente;
    }

    public function cambiarProceso($proceso , $carnet)
    {
        try{
            $em = $this->getEntityManager();
            $pacienteSintomatico = $em->getRepository('AppBundle:PacienteSintomatico')->findOneBy(array('carnetIdentidad' => $carnet ));
            $pacienteSintomatico->setProceso($proceso);
            $em->persist($pacienteSintomatico);
            $em->flush();

        }catch (\Exception $e)
        {
            $msg = $e->getMessage();
        }
        return $msg;
    }
}
