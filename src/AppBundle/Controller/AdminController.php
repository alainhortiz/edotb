<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/gestionarProvincias", name="gestionarProvincias")
     */
    public function gestionarProvinciasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias  = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Provincias',
            'descripcion' => 'Listado de provincias'
        ));

        return $this->render('Nomencladores/gestionProvincias.html.twig' , array('provincias' => $provincias));
    }

    /**
     * @Route("/addProvincia", name="addProvincia")
     */
    public function addProvinciaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Provincias - Agregar Provincia',
            'descripcion' => 'Formulario para agregar una provincia'
        ));
        return $this->render('Nomencladores/addProvincia.html.twig');
    }

    /**
     * @Route("/insertProvincia", name="insertProvincia")
     */
    public function insertProvinciaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Provincia')->agregarProvincia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Provincia',
                'descripcion' => 'Se insertó una nueva provincia con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editProvincia/{idProvincia}", name="editProvincia")
     */
    public function editProvinciaAction($idProvincia)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia = $em->getRepository('AppBundle:Provincia')->find($idProvincia);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Provincias - Editar Provincia',
            'descripcion' => 'Formulario para editar la provincia: '.$provincia->getNombre()
        ));

        return $this->render('Nomencladores/editProvincia.html.twig' , array('provincia' => $provincia));
    }

    /**
     * @Route("/updateProvincia", name="updateProvincia")
     */
    public function updateProvinciaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idProvincia' => $peticion->request->get('idProvincia'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Provincia')->modificarProvincia($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar provincia',
                'descripcion' => 'Se modificó la provincia:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteProvincia", name="deleteProvincia")
     */
    public function deleteProvinciaAction()
    {
        $peticion = Request::createFromGlobals();
        $idProvincia = $peticion->request->get('idProvincia');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Provincia')->eliminarProvincia($idProvincia);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Provincia',
                'descripcion' => 'Se eliminó la provincia: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarMunicipios", name="gestionarMunicipios")
     */
    public function gestionarMunicipiosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios  = $em->getRepository('AppBundle:Municipio')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Municipios',
            'descripcion' => 'Listado de municipios'
        ));

        return $this->render('Nomencladores/gestionMunicipios.html.twig' , array('municipios' => $municipios));
    }

    /**
     * @Route("/addMunicipio", name="addMunicipio")
     */
    public function addMunicipioAction()
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Municipios - Agregar Municipio',
            'descripcion' => 'Formulario para agregar un municipio'
        ));

        return $this->render('Nomencladores/addMunicipio.html.twig' , array('provincias' => $provincias));
    }

    /**
     * @Route("/insertMunicipio", name="insertMunicipio")
     */
    public function insertMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
            'idProvincia' => $peticion->request->get('provincia'),
        );
        $resp = $em->getRepository('AppBundle:Municipio')->agregarMunicipio($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Municipio',
                'descripcion' => 'Se insertó un nuevo municipio con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editMunicipio/{idMunicipio}", name="editMunicipio")
     */
    public function editMunicipioAction($idMunicipio)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio = $em->getRepository('AppBundle:Municipio')->find($idMunicipio);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Municipios - Editar Municipio',
            'descripcion' => 'Formulario para editar el municipio: '.$municipio->getNombre()
        ));

        return $this->render('Nomencladores/editMunicipio.html.twig' , array('municipio' => $municipio , 'provincias' => $provincias));
    }

    /**
     * @Route("/updateMunicipio", name="updateMunicipio")
     */
    public function updateMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idMunicipio' => $peticion->request->get('idMunicipio'),
            'nombre' => $peticion->request->get('nombre'),
            'idProvincia' => $peticion->request->get('provincia')
        );

        $resp = $em->getRepository('AppBundle:Municipio')->modificarMunicipio($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Municipio',
                'descripcion' => 'Se modificó el municipio:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteMunicipio", name="deleteMunicipio")
     */
    public function deleteMunicipioAction()
    {
        $peticion = Request::createFromGlobals();
        $idMunicipio = $peticion->request->get('idMunicipio');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Municipio')->eliminarMunicipio($idMunicipio);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Municipio',
                'descripcion' => 'Se eliminó el municipio: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarAreasSalud", name="gestionarAreasSalud")
     */
    public function gestionarAreasSaludAction()
    {
        $em = $this->getDoctrine()->getManager();
        $areasSalud  = $em->getRepository('AppBundle:AreaSalud')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Unidades',
            'descripcion' => 'Listado de unidades'
        ));

        return $this->render('Nomencladores/gestionAreasSalud.html.twig' , array('areasSalud' => $areasSalud));
    }

    /**
     * @Route("/addAreaSalud", name="addAreaSalud")
     */
    public function addAreaSaludAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Agregar Unidad',
            'descripcion' => 'Formulario para agregar una unidad'
        ));

        return $this->render('Nomencladores/addAreaSalud.html.twig' , array('municipios' => $municipios, 'provincias' => $provincias));
    }

    /**
     * @Route("/insertAreaSalud", name="insertAreaSalud")
     */
    public function insertAreaSaludAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio'),
            'isArea' => $peticion->request->get('isArea'),
            'tipoArea' => $peticion->request->get('tipoArea'),
        );
        $areaSalud = $em->getRepository('AppBundle:AreaSalud')->agregarAreaSalud($data);

        if(is_string($areaSalud)) return new Response($areaSalud);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Unidad',
                'descripcion' => 'Se insertó una nueva unidad con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editAreaSalud/{idAreaSalud}", name="editAreaSalud")
     */
    public function editAreaSaludAction($idAreaSalud)
    {
        $em = $this->getDoctrine()->getManager();
        $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($idAreaSalud);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Editar Unidad',
            'descripcion' => 'Formulario para editar la unidad: '.$areaSalud->getNombre()
        ));

        return $this->render('Nomencladores/editAreaSalud.html.twig' , array(
            'areaSalud' => $areaSalud,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }

    /**
     * @Route("/updateAreaSalud", name="updateAreaSalud")
     */
    public function updateAreaSaludAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idAreaSalud' => $peticion->request->get('idAreaSalud'),
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio'),
            'isArea' => $peticion->request->get('isArea'),
            'tipoArea' => $peticion->request->get('tipoArea'),
        );

        $areaSalud = $em->getRepository('AppBundle:AreaSalud')->modificarAreaSalud($data);


        if(is_string($areaSalud)) return new Response($areaSalud);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Unidad',
                'descripcion' => 'Se modificó la unidad:  '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteAreaSalud", name="deleteAreaSalud")
     */
    public function deleteAreaSaludAction()
    {
        $peticion = Request::createFromGlobals();
        $idAreaSalud = $peticion->request->get('idAreaSalud');
        $em = $this->getDoctrine()->getManager();

        $areaSalud  = $em->getRepository('AppBundle:AreaSalud')->eliminarAreaSalud($idAreaSalud);

        if(is_string($areaSalud)) return new Response($areaSalud);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Unidad',
                'descripcion' => 'Se eliminó la unidad: '.$areaSalud->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarGruposVulnerable", name="gestionarGruposVulnerable")
     */
    public function gestionarGruposVulnerableAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gruposVulnerable  = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Grupos Vulnerables',
            'descripcion' => 'Listado de grupos vulnerables'
        ));

        return $this->render('Nomencladores/gestionGruposVulnerable.html.twig' , array('gruposVulnerable' => $gruposVulnerable));
    }

    /**
     * @Route("/addGrupoVulnerable", name="addGrupoVulnerable")
     */
    public function addGrupoVulnerableAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Grupos Vulnerables - Agregar Grupo Vulnerable',
            'descripcion' => 'Formulario para agregar un grupo vulnerable'
        ));
        return $this->render('Nomencladores/addGrupoVulnerable.html.twig');
    }
    /**
     * @Route("/insertGrupoVulnerable", name="insertGrupoVulnerable")
     */
    public function insertGrupoVulnerableAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'numero' => $peticion->request->get('numero'),
            'grupo' => $peticion->request->get('grupo'),
        );
        $resp = $em->getRepository('AppBundle:GrupoVulnerable')->agregarGrupoVulnerable($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Grrupo Vulnerable',
                'descripcion' => 'Se insertó el grupo vulnerable: '.$data['grupo']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editGrupoVulnerable/{idGrupoVulnerable}", name="editGrupoVulnerable")
     */
    public function editGrupoVulnerableAction($idGrupoVulnerable)
    {
        $em = $this->getDoctrine()->getManager();
        $grupoVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->find($idGrupoVulnerable);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Grupos Vulnerables - Editar Grupo Vulnerable',
            'descripcion' => 'Formulario para editar el grupo vulnerable: '.$grupoVulnerable->getGrupo()
        ));

        return $this->render('Nomencladores/editGrupoVulnerable.html.twig' , array('grupoVulnerable' => $grupoVulnerable));
    }

    /**
     * @Route("/updateGrupoVulnerable", name="updateGrupoVulnerable")
     */
    public function updateGrupoVulnerableAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idGrupoVulnerable' => $peticion->request->get('idGrupoVulnerable'),
            'grupo' => $peticion->request->get('grupo'),
        );

        $resp = $em->getRepository('AppBundle:GrupoVulnerable')->modificarGrupoVulnerable($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Grupo Vulnerable',
                'descripcion' => 'Se modificó el grupo vulnerable:  '.$data['grupo']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteGrupoVulnerable", name="deleteGrupoVulnerable")
     */
    public function deleteGrupoVulnerableAction()
    {
        $peticion = Request::createFromGlobals();
        $idGrupoVulnerable = $peticion->request->get('idGrupoVulnerable');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:GrupoVulnerable')->eliminarGrupoVulnerable($idGrupoVulnerable);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Grupo Vulnerable',
                'descripcion' => 'Se eliminó el grupo vulnerable con el numero: '.$resp->getNumero()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarTiposEnfermo", name="gestionarTiposEnfermo")
     */
    public function gestionarTiposEnfermoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tiposEnfermo  = $em->getRepository('AppBundle:TipoEnfermo')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Tipos de Enfermo',
            'descripcion' => 'Listado de tipos de enfermo'
        ));

        return $this->render('Nomencladores/gestionTiposEnfermo.html.twig' , array('tiposEnfermo' => $tiposEnfermo));
    }

    /**
     * @Route("/addTipoEnfermo", name="addTipoEnfermo")
     */
    public function addTipoEnfermoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Tipo de Enfermo - Agregar Tipo de Enfermo',
            'descripcion' => 'Formulario para agregar un tipo de enfermo'
        ));
        return $this->render('Nomencladores/addTipoEnfermo.html.twig');
    }
    /**
     * @Route("/insertTipoEnfermo", name="insertTipoEnfermo")
     */
    public function insertTipoEnfermoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'tipo' => $peticion->request->get('tipo'),
        );
        $resp = $em->getRepository('AppBundle:TipoEnfermo')->agregarTipoEnfermo($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Tipo de Enfermo',
                'descripcion' => 'Se insertó el tipo de enfermo: '.$data['tipo']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editTipoEnfermo/{idTipoEnfermo}", name="editTipoEnfermo")
     */
    public function editTipoEnfermoAction($idTipoEnfermo)
    {
        $em = $this->getDoctrine()->getManager();
        $tipoEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->find($idTipoEnfermo);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Tipos de Enfermo - Editar Tipo de Enfermo',
            'descripcion' => 'Formulario para el tipo de enfermo : '.$tipoEnfermo->getTipo()
        ));

        return $this->render('Nomencladores/editTipoEnfermo.html.twig' , array('tipoEnfermo' => $tipoEnfermo));
    }

    /**
     * @Route("/updateTipoEnfermo", name="updateTipoEnfermo")
     */
    public function updateTipoEnfermoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idTipoEnfermo' => $peticion->request->get('idTipoEnfermo'),
            'tipo' => $peticion->request->get('tipo'),
        );

        $resp = $em->getRepository('AppBundle:TipoEnfermo')->modificarTipoEnfermo($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Tipo de Enfermo',
                'descripcion' => 'Se modificó el tipo de enfermo:  '.$data['tipo']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteTipoEnfermo", name="deleteTipoEnfermo")
     */
    public function deleteTipoEnfermoAction()
    {
        $peticion = Request::createFromGlobals();
        $idTipoEnfermo = $peticion->request->get('idTipoEnfermo');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:TipoEnfermo')->eliminarTipoEnfermo($idTipoEnfermo);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Tipo de Enfermo',
                'descripcion' => 'Se eliminó el tipo de enfermo: '.$resp->getTipo()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarBaciloscopias", name="gestionarBaciloscopias")
     */
    public function gestionarBaciloscopiasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $baciloscopias  = $em->getRepository('AppBundle:Baciloscopia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Resultados de  Baciloscopía',
            'descripcion' => 'Listado de resultados de baciloscopía'
        ));

        return $this->render('Nomencladores/gestionBaciloscopias.html.twig' , array('baciloscopias' => $baciloscopias));
    }

    /**
     * @Route("/addBaciloscopia", name="addBaciloscopia")
     */
    public function addBaciloscopiaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Resultados de  Baciloscopía - Agregar Baciloscopía',
            'descripcion' => 'Formulario para agregar un resultado de  baciloscopía'
        ));
        return $this->render('Nomencladores/addBaciloscopia.html.twig');
    }
    /**
     * @Route("/insertBaciloscopia", name="insertBaciloscopia")
     */
    public function insertBaciloscopiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'clasificacion' => $peticion->request->get('clasificacion'),
            'descripcion' => $peticion->request->get('descripcion'),
        );
        $baciloscopia = $em->getRepository('AppBundle:Baciloscopia')->agregarBaciloscopia($data);

        if(is_string($baciloscopia)) return new Response($baciloscopia);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Resultado de Baciloscopía',
                'descripcion' => 'Se insertó el resultado de baciloscopía: '.$data['descripcion']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editBaciloscopia/{idBaciloscopia}", name="editBaciloscopia")
     */
    public function editBaciloscopiaAction($idBaciloscopia)
    {
        $em = $this->getDoctrine()->getManager();
        $baciloscopia = $em->getRepository('AppBundle:Baciloscopia')->find($idBaciloscopia);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resultados de Baciloscopía  - Editar Resultado de Baciloscopía',
            'descripcion' => 'Formulario para editar el resultado de baciloscopía: '.$baciloscopia->getDescripcion()
        ));

        return $this->render('Nomencladores/editBaciloscopia.html.twig' , array('baciloscopia' => $baciloscopia));
    }

    /**
     * @Route("/updateBaciloscopia", name="updateBaciloscopia")
     */
    public function updateBaciloscopiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idBaciloscopia' => $peticion->request->get('idBaciloscopia'),
            'descripcion' => $peticion->request->get('descripcion'),
        );

        $baciloscopia = $em->getRepository('AppBundle:Baciloscopia')->modificarBaciloscopia($data);

        if(is_string($baciloscopia)) return new Response($baciloscopia);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Resultado de Baciloscopía',
                'descripcion' => 'Se modificó el resultado de baciloscopía:  '.$data['descripcion']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteBaciloscopia", name="deleteBaciloscopia")
     */
    public function deleteBaciloscopiaAction()
    {
        $peticion = Request::createFromGlobals();
        $idBaciloscopia = $peticion->request->get('idBaciloscopia');
        $em = $this->getDoctrine()->getManager();

        $baciloscopia  = $em->getRepository('AppBundle:Baciloscopia')->eliminarBaciloscopia($idBaciloscopia);

        if(is_string($baciloscopia)) return new Response($baciloscopia);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Baciloscopía',
                'descripcion' => 'Se eliminó el resultado de baciloscopía: '.$baciloscopia->getDescripcion()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarCultivos", name="gestionarCultivos")
     */
    public function gestionarCultivosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cultivos  = $em->getRepository('AppBundle:Cultivo')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Resultados de  Cultivo',
            'descripcion' => 'Listado de resultados de  cultivo'
        ));

        return $this->render('Nomencladores/gestionCultivos.html.twig' , array('cultivos' => $cultivos));
    }

    /**
     * @Route("/addCultivo", name="addCultivo")
     */
    public function addCultivoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Resultados de Cultivos - Agregar Cultivo',
            'descripcion' => 'Formulario para agregar un resultado de cultivo'
        ));
        return $this->render('Nomencladores/addCultivo.html.twig');
    }
    /**
     * @Route("/insertCultivo", name="insertCultivo")
     */
    public function insertCultivoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'clasificacion' => $peticion->request->get('clasificacion'),
            'descripcion' => $peticion->request->get('descripcion'),
        );
        $cultivo = $em->getRepository('AppBundle:Cultivo')->agregarCultivo($data);

        if(is_string($cultivo)) return new Response($cultivo);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Resultado de Cultivo',
                'descripcion' => 'Se insertó el resultado de cultivo: '.$data['descripcion']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editCultivo/{idCultivo}", name="editCultivo")
     */
    public function editCultivoAction($idCultivo)
    {
        $em = $this->getDoctrine()->getManager();
        $cultivo = $em->getRepository('AppBundle:Cultivo')->find($idCultivo);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resultados de Cultivo  - Editar Resultado de Cultivo',
            'descripcion' => 'Formulario para editar el resultado de cultivo: '.$cultivo->getDescripcion()
        ));

        return $this->render('Nomencladores/editCultivo.html.twig' , array('cultivo' => $cultivo));
    }

    /**
     * @Route("/updateCultivo", name="updateCultivo")
     */
    public function updateCultivoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idCultivo' => $peticion->request->get('idCultivo'),
            'descripcion' => $peticion->request->get('descripcion'),
        );

        $cultivo = $em->getRepository('AppBundle:Cultivo')->modificarCultivo($data);

        if(is_string($cultivo)) return new Response($cultivo);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Resultado de Cultivo',
                'descripcion' => 'Se modificó el resultado de cultivo:  '.$data['descripcion']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteCultivo", name="deleteCultivo")
     */
    public function deleteCultivoAction()
    {
        $peticion = Request::createFromGlobals();
        $idCultivo = $peticion->request->get('idCultivo');
        $em = $this->getDoctrine()->getManager();

        $cultivo  = $em->getRepository('AppBundle:Cultivo')->eliminarCultivo($idCultivo);

        if(is_string($cultivo)) return new Response($cultivo);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Cultivo',
                'descripcion' => 'Se eliminó el resultado de  cultivo: '.$cultivo->getDescripcion()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarXperts", name="gestionarXperts")
     */
    public function gestionarXpertsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $xpert  = $em->getRepository('AppBundle:Xpert')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Resultados de  Xperts',
            'descripcion' => 'Listado de resultados de xpert'
        ));

        return $this->render('Nomencladores/gestionXperts.html.twig' , array('xperts' => $xpert));
    }

    /**
     * @Route("/addXpert", name="addXpert")
     */
    public function addXpertAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Resultados de Xpert - Agregar Xpert',
            'descripcion' => 'Formulario para agregar un resultado de xpert'
        ));
        return $this->render('Nomencladores/addXpert.html.twig');
    }

    /**
     * @Route("/insertXpert", name="insertXpert")
     */
    public function insertXpertAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'clasificacion' => $peticion->request->get('clasificacion'),
            'descripcion' => $peticion->request->get('descripcion'),
        );
        $resp = $em->getRepository('AppBundle:Xpert')->agregarXpert($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Resultado de xpert',
                'descripcion' => 'Se insertó el resultado de xpert: '.$data['descripcion']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editXpert/{idXpert}", name="editXpert")
     */
    public function editXpertAction($idXpert)
    {
        $em = $this->getDoctrine()->getManager();
        $xpert = $em->getRepository('AppBundle:Xpert')->find($idXpert);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resultados de Xpert  - Editar Resultado de Xpert',
            'descripcion' => 'Formulario para editar el resultado de xpert: '.$xpert->getDescripcion()
        ));

        return $this->render('Nomencladores/editXpert.html.twig' , array('xpert' => $xpert));
    }

    /**
     * @Route("/updateXpert", name="updateXpert")
     */
    public function updateXpertAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idXpert' => $peticion->request->get('idXpert'),
            'descripcion' => $peticion->request->get('descripcion'),
        );

        $resp = $em->getRepository('AppBundle:Xpert')->modificarXpert($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Resultado de Xpert',
                'descripcion' => 'Se modificó el resultado de xpert:  '.$data['descripcion']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteXpert", name="deleteXpert")
     */
    public function deleteXpertAction()
    {
        $peticion = Request::createFromGlobals();
        $idXpert = $peticion->request->get('idXpert');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Xpert')->eliminarXpert($idXpert);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Xpert',
                'descripcion' => 'Se eliminó el resultado de xpert: '.$resp->getDescripcion()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarMedicamentos", name="gestionarMedicamentos")
     */
    public function gestionarMedicamentosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $medicamentos  = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Medicamentos',
            'descripcion' => 'Listado de Medicamentos'
        ));

        return $this->render('Nomencladores/gestionMedicamentos.html.twig' , array('medicamentos' => $medicamentos));
    }

    /**
     * @Route("/addMedicamento", name="addMedicamento")
     */
    public function addMedicamentoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Medicamento - Agregar Medicamento',
            'descripcion' => 'Formulario para agregar un medicamento'
        ));
        return $this->render('Nomencladores/addMedicamento.html.twig');
    }
    /**
     * @Route("/insertMedicamento", name="insertMedicamento")
     */
    public function insertMedicamentoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
            'modulo' => $peticion->request->get('modulo')
        );
        $resp = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->agregarMedicamento($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Medicamento',
                'descripcion' => 'Se insertó el medicamento: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editMedicamento/{idMedicamento}", name="editMedicamento")
     */
    public function editMedicamentoAction($idMedicamento)
    {
        $em = $this->getDoctrine()->getManager();
        $medicamento = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->find($idMedicamento);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Medicamentos  - Editar Medicamento',
            'descripcion' => 'Formulario para editar el medicamento: '.$medicamento->getNombre()
        ));

        return $this->render('Nomencladores/editMedicamento.html.twig' , array('medicamento' => $medicamento));
    }

    /**
     * @Route("/updateMedicamento", name="updateMedicamento")
     */
    public function updateMedicamentoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idMedicamento' => $peticion->request->get('idMedicamento'),
            'nombre' => $peticion->request->get('nombre'),
            'modulo' => $peticion->request->get('modulo')
        );

        $resp = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->modificarMedicamento($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Medicamento',
                'descripcion' => 'Se modificó el medicamento:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteMedicamento", name="deleteMedicamento")
     */
    public function deleteMedicamentoAction()
    {
        $peticion = Request::createFromGlobals();
        $idMedicamento = $peticion->request->get('idMedicamento');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->eliminarMedicamento($idMedicamento);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Medicamento',
                'descripcion' => 'Se eliminó el medicamento: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarUsuarios", name="gestionarUsuarios")
     */
    public function gestionarUsuariosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $usuarios = $em->getRepository('AppBundle:Usuario')->listarUsuarios($user);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Usuarios',
            'descripcion' => 'Listado de usuarios'
        ));

        return $this->render('Nomencladores/gestionUsuarios.html.twig' , array('usuarios' => $usuarios));
    }

    /**
     * @Route("/addUsuario", name="addUsuario")
     */
    public function addUsuarioAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $niveles = $em->getRepository('AppBundle:NivelAcceso')->listarNivelesAcceso($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $roles = $em->getRepository('AppBundle:Role')->findAll();
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Usuarios - Agregar Usuario',
            'descripcion' => 'Formulario para agregar un usuario'
        ));


        return $this->render('Nomencladores/addUsuario.html.twig' , array(
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'roles' => $roles,
                'nivelesAcceso' => $niveles)
        );
    }
    /**
     * @Route("/insertUsuario", name="insertUsuario")
     */
    public function insertUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'username' => $peticion->request->get('username'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'nivelAcceso' => $peticion->request->get('nivelAcceso'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
            'roles' => $peticion->request->get('roles')
        );
        $resp = $em->getRepository('AppBundle:Usuario')->agregarUsuario($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Usuario',
                'descripcion' => 'Se insertó el usuario: '.$data['nombre']. ' '. $data['primerApellido']. ' '.$data['segundoApellido']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editUsuario/{idUsuario}", name="editUsuario")
     */
    public function editUsuarioAction($idUsuario)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($idUsuario);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $niveles = $em->getRepository('AppBundle:NivelAcceso')->listarNivelesAcceso($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $roles = $em->getRepository('AppBundle:Role')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Usuarios  - Editar Usuario',
            'descripcion' => 'Formulario para editar el usuario: '.$usuario->getNombre(). ' '. $usuario->getPrimerApellido().' '.$usuario->getSegundoApellido()
        ));

        return $this->render('Nomencladores/editUsuario.html.twig' , array(
                'usuario' => $usuario,
                'areasSalud' => $areasSalud,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'hospitales' => $hospitales,
                'roles' => $roles,
                'nivelesAcceso' => $niveles)
        );
    }

    /**
     * @Route("/updateUsuario", name="updateUsuario")
     */
    public function updateUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idUsuario' => $peticion->request->get('idUsuario'),
            'username' => $peticion->request->get('username'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'nivelAcceso' => $peticion->request->get('nivelAcceso'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
            'roles' => $peticion->request->get('roles')
        );

        $resp = $em->getRepository('AppBundle:Usuario')->modificarUsuario($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Usuario',
                'descripcion' => 'Se modificó el usuario:  '.$data['nombre']. ' '. $data['primerApellido'].' '.$data['segundoApellido']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteUsuario", name="deleteUsuario")
     */
    public function deleteUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $idUsuario = $peticion->request->get('idUsuario');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Usuario')->eliminarUsuario($idUsuario);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Usuario',
                'descripcion' => 'Se eliminó el usuario: '.$resp->getNombre(). ' ' .$resp->getPrimerApellido(). ' '.$resp->getSegundoApellido()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarResistencias", name="gestionarResistencias")
     */
    public function gestionarResistenciasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $resistencias  = $em->getRepository('AppBundle:Resistencia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Resistencias',
            'descripcion' => 'Listado de resistencias'
        ));

        return $this->render('Nomencladores/gestionResistencias.html.twig' , array('resistencias' => $resistencias));
    }

    /**
     * @Route("/addResistencia", name="addResistencia")
     */
    public function addResistenciaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resistencias - Agregar Resistencia',
            'descripcion' => 'Formulario para agregar una resistencia'
        ));
        return $this->render('Nomencladores/addResistencia.html.twig');
    }
    /**
     * @Route("/insertResistencia", name="insertResistencia")
     */
    public function insertResistenciaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'clasificacion' => $peticion->request->get('clasificacion'),
            'descripcion' => $peticion->request->get('descripcion'),
        );
        $resp = $em->getRepository('AppBundle:Resistencia')->agregarResistencia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Resistencia',
                'descripcion' => 'Se insertó la resistencia: '.$data['descripcion']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editResistencia/{idResistencia}", name="editResistencia")
     */
    public function editResistenciaAction($idResistencia)
    {
        $em = $this->getDoctrine()->getManager();
        $resistencia = $em->getRepository('AppBundle:Resistencia')->find($idResistencia);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Resistencias  - Editar Resistencia',
            'descripcion' => 'Formulario para editar la resistencia: '.$resistencia->getDescripcion()
        ));

        return $this->render('Nomencladores/editResistencia.html.twig' , array('resistencia' => $resistencia));
    }

    /**
     * @Route("/updateResistencia", name="updateResistencia")
     */
    public function updateResistenciaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idResistencia' => $peticion->request->get('idResistencia'),
            'descripcion' => $peticion->request->get('descripcion'),
        );

        $resp = $em->getRepository('AppBundle:Resistencia')->modificarResistencia($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Resistencia',
                'descripcion' => 'Se modificó la resistencia:  '.$data['descripcion']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteResistencia", name="deleteResistencia")
     */
    public function deleteResistenciaAction()
    {
        $peticion = Request::createFromGlobals();
        $idResistencia = $peticion->request->get('idResistencia');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Resistencia')->eliminarResistencia($idResistencia);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Resistencia',
                'descripcion' => 'Se eliminó la resistencia: '.$resp->getDescripcion()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarResultadosTratamiento", name="gestionarResultadosTratamiento")
     */
    public function gestionarResultadosTratamientoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $resultadosTratamiento = $em->getRepository('AppBundle:ResultadoTratamiento')->findAll();

        return $this->render('Nomencladores/gestionResultadosTratamiento.html.twig' , array('resultadosTratamiento' => $resultadosTratamiento));
    }

    /**
     * @Route("/addResultadoTratamiento", name="addResultadoTratamiento")
     */
    public function addResultadoTratamientoAction()
    {
        return $this->render('Nomencladores/addResultadoTratamiento.html.twig');
    }

    /**
     * @Route("/insertResultadoTratamiento", name="insertResultadoTratamiento")
     */
    public function insertResultadoTratamientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'resultado' => $peticion->request->get('resultado'),
            'modulo' => $peticion->request->get('modulo')
        );
        $resp = $em->getRepository('AppBundle:ResultadoTratamiento')->agregarResultadoTratamiento($data);

        if(is_string($resp)) return new Response($resp);
        else return new Response('ok');
    }

    /**
     * @Route("/editResultadoTratamiento/{idResultadoTratamiento}", name="editResultadoTratamiento")
     */
    public function editResultadoTratamientoAction($idResultadoTratamiento)
    {
        $em = $this->getDoctrine()->getManager();
        $resultadoTratamiento = $em->getRepository('AppBundle:ResultadoTratamiento')->find($idResultadoTratamiento);

        return $this->render('Nomencladores/editResultadoTratamiento.html.twig' , array('resultadoTratamiento' => $resultadoTratamiento));
    }

    /**
     * @Route("/updateResultadoTratamiento", name="updateResultadoTratamiento")
     */
    public function updateResultadoTratamientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idResultadoTratamiento' => $peticion->request->get('idResultadoTratamiento'),
            'resultado' => $peticion->request->get('resultado'),
            'modulo' => $peticion->request->get('modulo')
        );

        $resp = $em->getRepository('AppBundle:ResultadoTratamiento')->modificarResultadoTratamiento($data);

        if(is_string($resp)) return new Response($resp);
        else return new Response('ok');
    }

    /**
     * @Route("/deleteResultadoTratamiento", name="deleteResultadoTratamiento")
     */
    public function deleteResultadoTratamientoAction()
    {
        $peticion = Request::createFromGlobals();
        $idResultadoTratamiento = $peticion->request->get('idResultadoTratamiento');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:ResultadoTratamiento')->eliminarResultadoTratamiento($idResultadoTratamiento);

        if(is_string($resp)) return new Response($resp);
        else return new Response('ok');

    }

    /**
     * @Route("/gestionarSemanasEstadisticas", name="gestionarSemanasEstadisticas")
     */
    public function gestionarSemanasEstadisticasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $semanasEstadisticas = $em->getRepository('AppBundle:SemanaEstadistica')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Semanas Estadísticas',
            'descripcion' => 'Listado de Semanas Estadísticas'
        ));

        return $this->render('Nomencladores/gestionSemanasEstadisticas.html.twig' , array('semanasEstadisticas' => $semanasEstadisticas));
    }
    /**
     * @Route("/addSemanaEstadistica", name="addSemanaEstadistica")
     */
    public function addSemanaEstadisticaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Semanas Estadísticas - Agregar Semana Estadítica',
            'descripcion' => 'Formulario para agregar una semana estadística'
        ));
        return $this->render('Nomencladores/addSemanaEstadistica.html.twig');
    }
    /**
     * @Route("/insertSemanaEstadistica", name="insertSemanaEstadistica")
     */
    public function insertSemanaEstadisticaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'semana' => $peticion->request->get('semana'),
            'fechaInicio' => $peticion->request->get('fechaInicio'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
        );
        $resp = $em->getRepository('AppBundle:SemanaEstadistica')->agregarSemanaEstadistica($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Semana Estadística',
                'descripcion' => 'Se insertó la semana estadística: '.$data['semana']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editSemanaEstadistica/{idSemanaEstadistica}", name="editSemanaEstadistica")
     */
    public function editSemanaEstadisticaAction($idSemanaEstadistica)
    {
        $em = $this->getDoctrine()->getManager();
        $semanaEstadistica = $em->getRepository('AppBundle:SemanaEstadistica')->find($idSemanaEstadistica);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Semanas Estadísticas  - Editar Semana Estadística',
            'descripcion' => 'Formulario para editar la semana estadística: '.$semanaEstadistica->getSemana()
        ));

        return $this->render('Nomencladores/editSemanaEstadistica.html.twig' , array('semanaEstadistica' => $semanaEstadistica));
    }
    /**
     * @Route("/updateSemanaEstadistica", name="updateSemanaEstadistica")
     */
    public function updateSemanaEstadisticaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idSemanaEstadistica' => $peticion->request->get('idSemanaEstadistica'),
            'fechaInicio' => $peticion->request->get('fechaInicio'),
            'fechaFinal' => $peticion->request->get('fechaFinal'),
        );

        $resp = $em->getRepository('AppBundle:SemanaEstadistica')->modificarSemanaEstadistica($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Semana Estadística',
                'descripcion' => 'Se modificó la semana estadística:  '.$resp->getSemana()
            ));
            return new Response('ok');
        }
    }
    /**
     * @Route("/deleteSemanaEstadistica", name="deleteSemanaEstadistica")
     */
    public function deleteSemanaEstadisticaAction()
    {
        $peticion = Request::createFromGlobals();
        $idSemanaEstadistica = $peticion->request->get('idSemanaEstadistica');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:SemanaEstadistica')->eliminarSemanaEstadistica($idSemanaEstadistica);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Semana Estadística',
                'descripcion' => 'Se eliminó la semana estadística: '.$resp->getSemana()
            ));
            return new Response('ok');
        }
    }
    /**
     * @Route("/gestionarPaises", name="gestionarPaises")
     */
    public function gestionarPaisesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paises  = $em->getRepository('AppBundle:Pais')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Paises',
            'descripcion' => 'Listado de paises'
        ));

        return $this->render('Nomencladores/gestionPaises.html.twig' , array('paises' => $paises));
    }
    /**
     * @Route("/addPais", name="addPais")
     */
    public function addPaisAction()
    {

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Paises - Agregar País',
            'descripcion' => 'Formulario para agregar un país'
        ));
        return $this->render('Nomencladores/addPais.html.twig');
    }
    /**
     * @Route("/insertPais", name="insertPais")
     */
    public function insertPaisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:Pais')->agregarPais($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar País',
                'descripcion' => 'Se insertó el país: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editPais/{idPais}", name="editPais")
     */
    public function editPaisAction($idPais)
    {
        $em = $this->getDoctrine()->getManager();
        $pais = $em->getRepository('AppBundle:Pais')->find($idPais);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Paises  - Editar País',
            'descripcion' => 'Formulario para editar el país: '.$pais->getNombre()
        ));

        return $this->render('Nomencladores/editPais.html.twig' , array('pais' => $pais));
    }

    /**
     * @Route("/updatePais", name="updatePais")
     */
    public function updatePaisAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPais' => $peticion->request->get('idPais'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Pais')->modificarPais($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar País',
                'descripcion' => 'Se modificó el país:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deletePais", name="deletePais")
     */
    public function deletePaisAction()
    {
        $peticion = Request::createFromGlobals();
        $idPais = $peticion->request->get('idPais');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Pais')->eliminarPais($idPais);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar País',
                'descripcion' => 'Se eliminó el país: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarPruebasSensibilidad", name="gestionarPruebasSensibilidad")
     */
    public function gestionarPruebasSensibilidadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pruebasSensibilidad  = $em->getRepository('AppBundle:PruebaSensibilidad')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Pruebas de Sensibilidad',
            'descripcion' => 'Listado de de pruebas de sensibilidad'
        ));

        return $this->render('Nomencladores/gestionPruebasSensibilidad.html.twig' , array('pruebasSensibilidad' => $pruebasSensibilidad));
    }

    /**
     * @Route("/addPruebaSensibilidad", name="addPruebaSensibilidad")
     */
    public function addPruebaSensibilidadAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Pruebas de Sensibilidad - Agregar Prueba de Sensibilidad',
            'descripcion' => 'Formulario para agregar una prueba de sensibilidad'
        ));
        return $this->render('Nomencladores/addPruebaSensibilidad.html.twig');
    }

    /**
     * @Route("/insertPruebaSensibilidad", name="insertPruebaSensibilidad")
     */
    public function insertPruebaSensibilidadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:PruebaSensibilidad')->agregarPruebaSensibilidad($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Prueba de Sensibilidad',
                'descripcion' => 'Se insertó la prueba de sensibilidad: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editPruebaSensibilidad/{idPruebaSensibilidad}", name="editPruebaSensibilidad")
     */
    public function editPruebaSensibilidadAction($idPruebaSensibilidad)
    {
        $em = $this->getDoctrine()->getManager();
        $pruebaSensibilidad = $em->getRepository('AppBundle:PruebaSensibilidad')->find($idPruebaSensibilidad);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Pruebas de Sensibilidad  - Editar Prueba de Sensibilidad',
            'descripcion' => 'Formulario para editar la prueba de sensibilidad: '.$pruebaSensibilidad->getNombre()
        ));

        return $this->render('Nomencladores/editPruebaSensibilidad.html.twig' , array('pruebaSensibilidad' => $pruebaSensibilidad ));
    }

    /**
     * @Route("/updatePruebaSensibilidad", name="updatePruebaSensibilidad")
     */
    public function updatePruebaSensibilidadAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPruebaSensibilidad' => $peticion->request->get('idPruebaSensibilidad'),
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio')
        );

        $resp = $em->getRepository('AppBundle:PruebaSensibilidad')->modificarPruebaSensibilidad($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Prueba de Sensibilidad',
                'descripcion' => 'Se modificó la prueba de sensibilidad:  '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deletePruebaSensibilidad", name="deletePruebaSensibilidad")
     */
    public function deletePruebaSensibilidadAction()
    {
        $peticion = Request::createFromGlobals();
        $idPruebaSensibilidad = $peticion->request->get('idPruebaSensibilidad');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:PruebaSensibilidad')->eliminarPruebaSensibilidad($idPruebaSensibilidad);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Prueba de Sensibilidad',
                'descripcion' => 'Se eliminó la prueba de sensibilidad: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }
    //----------------------------------------------------------------------------------------
    //-------------------- CRUD LABORATORIO CULTIVO-------------------------------------------
    //----------------------------------------------------------------------------------------
    /**
     * @Route("/listarCalidadCultivo", name="listarCalidadCultivo")
     */
    public function listarCalidadCultivoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $laboratorios = $em->getRepository('AppBundle:ControlCalidadCultivo')->listadoControlCalidadCultivoMesActual();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Laboratorio - Gestionar control de calidad del cultivo',
            'descripcion' => 'Listado de calidad de cultivos'
        ));

        return $this->render('Nomencladores/gestionLabControlCultivo.html.twig' , array('laboratorios' => $laboratorios));
    }

    /**
     * @Route("/buscarLabCalidadCultivo/{id}", name="buscarLabCalidadCultivo")
     */
    public function buscarLabCalidadCultivoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $controlCalidad = $em->getRepository('AppBundle:ControlCalidadCultivo')->find($id);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Laboratorio - Buscar control de calidad del cultivo',
            'descripcion' => 'Control de calidad de cultivo -'.$id
        ));

        return $this->render('Nomencladores/editLabControlCultivo.html.twig' , array('controlCalidad' => $controlCalidad));
    }

    //----------------------------------------------------------------------------------------
    //-------------------- FIN CRUD LABORATORIO CULTIVO---------------------------------------
    //----------------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------------
    //-------------------- CRUD LABORATORIO BACILOSCOPIA--------------------------------------
    //----------------------------------------------------------------------------------------
    /**
     * @Route("/listarCalidadBaciloscopia", name="listarCalidadBaciloscopia")
     */
    public function listarCalidadBaciloscopiaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $laboratorios = $em->getRepository('AppBundle:ControlCalidadBaciloscopia')->listadoControlCalidadBaciloscopiaMesActual();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Laboratorio - Gestionar control de calidad de la baciloscopía',
            'descripcion' => 'Listado de calidad de baciloscopía'
        ));

        return $this->render('Nomencladores/gestionLabControlBaciloscopia.html.twig' , array('laboratorios' => $laboratorios));
    }

    /**
     * @Route("/buscarLabCalidadBaciloscopia/{id}", name="buscarLabCalidadBaciloscopia")
     */
    public function buscarLabCalidadBaciloscopiaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $controlBaciloscopia = $em->getRepository('AppBundle:ControlCalidadBaciloscopia')->find($id);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Laboratorio - Buscar control de calidad de la baciloscopía',
            'descripcion' => 'Control de calidad de baciloscopía -'.$id
        ));

        return $this->render('Nomencladores/editLabControlBaciloscopia.html.twig' , array('controlCalidad' => $controlBaciloscopia));
    }

    //----------------------------------------------------------------------------------------
    //-------------------- FIN CRUD LABORATORIO BACILOSCOPIA----------------------------------
    //----------------------------------------------------------------------------------------

    /**
     * @Route("/descargarAyuda", name="descargarAyuda")
     **/
    public function descargarAyudaAction(){

        $path = $this->get('kernel')->getRootDir(). "/../web/public/ayuda/";
        $content = file_get_contents($path.'ayuda.docx');

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.'ayuda.docx');

        $response->setContent($content);
        return $response;
    }

    //----------------------------------------------------------------------------------------
    //-------------------- CODIFICADORES DE 2020----------------------------------
    //----------------------------------------------------------------------------------------

    /**
     * @Route("/gestionarTipoHospital", name="gestionarTipoHospital")
     */
    public function gestionarTipoHospitalAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoHospitales  = $em->getRepository('AppBundle:TipoHospital')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Tipo de Hospitales',
            'descripcion' => 'Listado de tipos de hospitales'
        ));

        return $this->render('Nomencladores/gestionTipoHospital.html.twig' , array('tipoHospitales' => $tipoHospitales));
    }

    /**
     * @Route("/addTipoHospital", name="addTipoHospital")
     */
    public function addTipoHospitalAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar tipo de hospital - Agregar tipo de hospital',
            'descripcion' => 'Formulario para agregar un tipo de hospital'
        ));
        return $this->render('Nomencladores/addTipoHospital.html.twig');
    }

    /**
     * @Route("/insertTipoHospital", name="insertTipoHospital")
     */
    public function insertTipoHospitalAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'codigo' => $peticion->request->get('codigo'),
            'nombre' => $peticion->request->get('nombre'),
        );
        $resp = $em->getRepository('AppBundle:TipoHospital')->agregarTipoHospital($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar tipo de hospital',
                'descripcion' => 'Se insertó un nuevo tipo de hospital con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editTipoHospital/{idTipoHospital}", name="editTipoHospital")
     */
    public function editTipoHospitalAction($idTipoHospital)
    {
        $em = $this->getDoctrine()->getManager();
        $tipoHospital = $em->getRepository('AppBundle:TipoHospital')->find($idTipoHospital);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar tipo de hospital - Editar tipo de hospital',
            'descripcion' => 'Formulario para editar el tipo de hospital: '.$tipoHospital->getNombre()
        ));

        return $this->render('Nomencladores/editTipoHospital.html.twig' , array('tipoHospital' => $tipoHospital));
    }

    /**
     * @Route("/updateTipoHospital", name="updateTipoHospital")
     */
    public function updateTipoHospitalAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idTipoHospital' => $peticion->request->get('idTipoHospital'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:TipoHospital')->modificarTipoHospital($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar tipo de hospital',
                'descripcion' => 'Se modificó el tipo de hospital:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteTipoHospital", name="deleteTipoHospital")
     */
    public function deleteTipoHospitalAction()
    {
        $peticion = Request::createFromGlobals();
        $idTipoHospital = $peticion->request->get('idTipoHospital');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:TipoHospital')->eliminarTipoHospital($idTipoHospital);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar tipo de hospital',
                'descripcion' => 'Se eliminó el tipo de hospital: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/gestionarHospitales", name="gestionarHospitales")
     */
    public function gestionarHospitalesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $hospitales  = $em->getRepository('AppBundle:Hospital')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Hospitales',
            'descripcion' => 'Listado de hospitales'
        ));

        return $this->render('Nomencladores/gestionHospitales.html.twig' ,
            array('hospitales' => $hospitales));
    }

    /**
     * @Route("/gestionarHospitalesTipo/{idTipoHospital}", name="gestionarHospitalesTipo")
     */
    public function gestionarHospitalesTipoAction($idTipoHospital)
    {
        $em = $this->getDoctrine()->getManager();
        $tipoHospital = $em->getRepository('AppBundle:TipoHospital')->find($idTipoHospital);
        $hospitales  = $em->getRepository('AppBundle:Hospital')->listarHospitalTipo($idTipoHospital);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Hospitales',
            'descripcion' => 'Listado de hospitales'
        ));

        return $this->render('Nomencladores/gestionHospitalesTipo.html.twig' ,
            array('hospitales' => $hospitales,
                  'tipoHospital' => $tipoHospital
                ));
    }

    /**
     * @Route("/addHospital", name="addHospital")
     */
    public function addHospitalAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $tipoHospitales = $em->getRepository('AppBundle:TipoHospital')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Hospital - Agregar Hospital',
            'descripcion' => 'Formulario para agregar un hospital'
        ));

        return $this->render('Nomencladores/addHospital.html.twig' ,
            array('municipios' => $municipios,
                  'provincias' => $provincias,
                  'tipoHospitales' => $tipoHospitales,
                ));
    }

    /**
     * @Route("/addHospitalTipo/{idTipoHospital}", name="addHospitalTipo")
     */
    public function addHospitalTipoAction($idTipoHospital)
    {
        $em = $this->getDoctrine()->getManager();
        $tipoHospital = $em->getRepository('AppBundle:TipoHospital')->find($idTipoHospital);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $tipoHospitales = $em->getRepository('AppBundle:TipoHospital')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Hospital - Agregar Hospital',
            'descripcion' => 'Formulario para agregar un hospital'
        ));

        return $this->render('Nomencladores/addHospitalTipo.html.twig' ,
            array('tipoHospital' => $tipoHospital,
                'municipios' => $municipios,
                'provincias' => $provincias,
                'tipoHospitales' => $tipoHospitales,
            ));
    }

    /**
     * @Route("/insertHospital", name="insertHospital")
     */
    public function insertHospitalAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio'),
            'idTipoHospital' => $peticion->request->get('tipoHospital')
        );

        $hospital = $em->getRepository('AppBundle:Hospital')->agregarHospital($data);

        if(is_string($hospital)) return new Response($hospital);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Hospital',
                'descripcion' => 'Se insertó un nuevo hospital con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editHospital/{idHospital}", name="editHospital")
     */
    public function editHospitalAction($idHospital)
    {
        $em = $this->getDoctrine()->getManager();
        $hospital = $em->getRepository('AppBundle:Hospital')->find($idHospital);
        $tipoHospitales = $em->getRepository('AppBundle:TipoHospital')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Hopsitales - Editar Hospital',
            'descripcion' => 'Formulario para editar el hospital: '.$hospital->getNombre()
        ));

        return $this->render('Nomencladores/editHospital.html.twig' , array(
            'hospital' => $hospital,
            'tipoHospitales' => $tipoHospitales,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }

    /**
     * @Route("/editHospitalTipo/{idHospital}", name="editHospitalTipo")
     */
    public function editHospitalTipoAction($idHospital)
    {
        $em = $this->getDoctrine()->getManager();
        $hospital = $em->getRepository('AppBundle:Hospital')->find($idHospital);
        $idTipoHospital = $hospital ->getTipoHospistal()->getId();
        $tipoHospital = $em->getRepository('AppBundle:TipoHospital')->find($idTipoHospital);
        $tipoHospitales = $em->getRepository('AppBundle:TipoHospital')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Hopsitales - Editar Hospital',
            'descripcion' => 'Formulario para editar el hospital: '.$hospital->getNombre()
        ));

        return $this->render('Nomencladores/editHospitalTipo.html.twig' , array(
            'tipoHospital' => $tipoHospital,
            'hospital' => $hospital,
            'tipoHospitales' => $tipoHospitales,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }

    /**
     * @Route("/updateHospital", name="updateHospital")
     */
    public function updateHospitalAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idHospital' => $peticion->request->get('idHospital'),
            'idTipoHospital' => $peticion->request->get('idTipoHospital'),
            'nombre' => $peticion->request->get('nombre'),
            'idMunicipio' => $peticion->request->get('municipio')
        );

        $hospital = $em->getRepository('AppBundle:Hospital')->modificarHospital($data);

        if(is_string($hospital)) return new Response($hospital);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Hospital',
                'descripcion' => 'Se modificó el hospital:  '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteHospital", name="deleteHospital")
     */
    public function deleteHospitalAction()
    {
        $peticion = Request::createFromGlobals();
        $idHospital = $peticion->request->get('idHospital');
        $em = $this->getDoctrine()->getManager();

        $hospital  = $em->getRepository('AppBundle:Hospital')->eliminarHospital($idHospital);

        if(is_string($hospital)) return new Response($hospital);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Hospital',
                'descripcion' => 'Se eliminó el hospital: '.$hospital->getNombre()
            ));
            return new Response('ok');
        }
    }


# -------------------------------------------------------- #
# ------------------ GESTIÓN DE PRISIONES ---------------- #
# -------------------------------------------------------- #

    /**
     * @Route("/gestionarPrisiones", name="gestionarPrisiones")
     */
    public function gestionarPrisionesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $areasSalud  = $em->getRepository('AppBundle:AreaSalud')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Prisiones',
            'descripcion' => 'Listado de prisiones'
        ));

        return $this->render('Nomencladores/gestionPrisiones.html.twig' , array('areasSalud' => $areasSalud));
    }

    /**
     * @Route("/addPrision", name="addPrision")
     */
    public function addPrisionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Agregar Prisión',
            'descripcion' => 'Formulario para agregar una prisión'
        ));

        return $this->render('Nomencladores/addPrision.html.twig' , array('municipios' => $municipios, 'provincias' => $provincias));
    }

    /**
     * @Route("/editPrision/{idAreaSalud}", name="editPrision")
     */
    public function editPrisionAction($idAreaSalud)
    {
        $em = $this->getDoctrine()->getManager();
        $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($idAreaSalud);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Editar Prisión',
            'descripcion' => 'Formulario para editar la prisión: '.$areaSalud->getNombre()
        ));

        return $this->render('Nomencladores/editPrision.html.twig' , array(
            'areaSalud' => $areaSalud,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }



# -------------------------------------------------------- #
# ------------- GESTIÓN DE HOGARES DE ANCIANOS ----------- #
# -------------------------------------------------------- #

    /**
     * @Route("/gestionarHogaresAncianos", name="gestionarHogaresAncianos")
     */
    public function gestionarHogaresAncianosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $areasSalud  = $em->getRepository('AppBundle:AreaSalud')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Hogar de Ancianos',
            'descripcion' => 'Listado de Hogares de Ancianos'
        ));

        return $this->render('Nomencladores/gestionHogaresAncianos.html.twig' , array('areasSalud' => $areasSalud));
    }

    /**
     * @Route("/addHogarAnciano", name="addHogarAnciano")
     */
    public function addHogarAncianoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Agregar Hogar Anciano',
            'descripcion' => 'Formulario para agregar una hogar anciano'
        ));

        return $this->render('Nomencladores/addHogarAnciano.html.twig' , array('municipios' => $municipios, 'provincias' => $provincias));
    }

    /**
     * @Route("/editHogarAnciano/{idAreaSalud}", name="editHogarAnciano")
     */
    public function editHogarAncianoAction($idAreaSalud)
    {
        $em = $this->getDoctrine()->getManager();
        $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($idAreaSalud);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Editar Hogar Anciano',
            'descripcion' => 'Formulario para editar el hogar de anciano: '.$areaSalud->getNombre()
        ));

        return $this->render('Nomencladores/editHogarAnciano.html.twig' , array(
            'areaSalud' => $areaSalud,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }



# -------------------------------------------------------- #
# ---------------- GESTIÓN DE HOGARES MATERNOS ----------- #
# -------------------------------------------------------- #

    /**
     * @Route("/gestionarHogaresMaternos", name="gestionarHogaresMaternos")
     */
    public function gestionarHogaresMaternosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $areasSalud  = $em->getRepository('AppBundle:AreaSalud')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Hogares Maternos',
            'descripcion' => 'Listado de Hogares Maternos'
        ));

        return $this->render('Nomencladores/gestionHogaresMaternos.html.twig' , array('areasSalud' => $areasSalud));
    }

    /**
     * @Route("/addHogarMaterno", name="addHogarMaterno")
     */
    public function addHogarMaternoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Agregar Hogar Materno',
            'descripcion' => 'Formulario para agregar una hogar materno'
        ));

        return $this->render('Nomencladores/addHogarMaterno.html.twig' , array('municipios' => $municipios, 'provincias' => $provincias));
    }

    /**
     * @Route("/editHogarMaterno/{idAreaSalud}", name="editHogarMaterno")
     */
    public function editHogarMaternoAction($idAreaSalud)
    {
        $em = $this->getDoctrine()->getManager();
        $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($idAreaSalud);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Unidades - Editar Hogar Materno',
            'descripcion' => 'Formulario para editar el hogar materno: '.$areaSalud->getNombre()
        ));

        return $this->render('Nomencladores/editHogarMaterno.html.twig' , array(
            'areaSalud' => $areaSalud,
            'municipios' => $municipios,
            'provincias' => $provincias
        ));
    }


# -------------------------------------------------------- #
# ------------- GESTIÓN DE ESTADO DE GRÁFICOS ----------- #
# -------------------------------------------------------- #

    /**
     * @Route("/gestionarEstadosGraficos", name="gestionarEstadosGraficos")
     */
    public function gestionarEstadosGraficosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $estadosGraficos  = $em->getRepository('AppBundle:EstadoGrafico')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Estados Gráficos',
            'descripcion' => 'Listado de Estados Gráficos'
        ));

        return $this->render('Nomencladores/gestionEstadosGraficos.html.twig' , array('estadosGraficos' => $estadosGraficos));
    }

    /**
     * @Route("/addEstadoGrafico", name="addEstadoGrafico")
     */
    public function addEstadoGraficoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Estado de Gráfico - Agregar Estado de Gráfico',
            'descripcion' => 'Formulario para agregar un Estado de Gráfico'
        ));
        return $this->render('Nomencladores/addEstadoGrafico.html.twig');
    }

    /**
     * @Route("/insertEstadoGrafico", name="insertEstadoGrafico")
     */
    public function insertEstadoGraficoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'year' => $peticion->request->get('year'),
            'valorInicial' => $peticion->request->get('valorInicial'),
            'valorFinal' => $peticion->request->get('valorFinal'),
        );

        $resp = $em->getRepository('AppBundle:EstadoGrafico')->agregarEstadoGrafico($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Estado de Gráfico',
                'descripcion' => 'Se insertó un nuevo Estado de Gráfico con el año: '.$data['year']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editEstadoGrafico/{idEstado}", name="editEstadoGrafico")
     */
    public function editEstadoGraficoAction($idEstado)
    {
        $em = $this->getDoctrine()->getManager();
        $estadoGrafico = $em->getRepository('AppBundle:EstadoGrafico')->find($idEstado);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Estado de Gráfico - Editar Estado de Gráfico',
            'descripcion' => 'Formulario para editar el estado de los gráficos.'
        ));

        return $this->render('Nomencladores/editEstadoGrafico.html.twig' , array(
            'estadoGrafico' => $estadoGrafico
        ));
    }

    /**
     * @Route("/updateEstadoGrafico", name="updateEstadoGrafico")
     */
    public function updateEstadoGraficoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idEstadoGrafico' => $peticion->request->get('idEstadoGrafico'),
            'year' => $peticion->request->get('year'),
            'valorInicial' => $peticion->request->get('valorInicial'),
            'valorFinal' => $peticion->request->get('valorFinal'),
        );

        $resp = $em->getRepository('AppBundle:EstadoGrafico')->modificarEstadoGrafico($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar estado de gráfico',
                'descripcion' => 'Se modificó el estado del gráfico del año: '.$resp->getYear()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteEstadoGrafico", name="deleteEstadoGrafico")
     */
    public function deleteEstadoGraficoAction()
    {
        $peticion = Request::createFromGlobals();
        $idEstadoGrafico = $peticion->request->get('idEstadoGrafico');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:EstadoGrafico')->eliminarEstadoGrafico($idEstadoGrafico);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar estado de gráfico',
                'descripcion' => 'Se eliminó el estado de gráfico del año: '.$resp->getYear()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # ------------- GESTIÓN DE OCUPACIÓN ----------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/gestionarOcupaciones", name="gestionarOcupaciones")
     */
    public function gestionarOcupacionesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ocupaciones  = $em->getRepository('AppBundle:Ocupacion')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Ocupaciones',
            'descripcion' => 'Listado de Ocupaciones'
        ));

        return $this->render('Nomencladores/gestionOcupaciones.html.twig' , array('ocupaciones' => $ocupaciones));
    }

    /**
     * @Route("/addOcupacion", name="addOcupacion")
     */
    public function addOcupacionAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Ocupación - Agregar Ocupación',
            'descripcion' => 'Formulario para agregar un ocupación'
        ));
        return $this->render('Nomencladores/addOcupacion.html.twig');
    }

    /**
     * @Route("/insertOcupacion", name="insertOcupacion")
     */
    public function insertOcupacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre')
        );
        $resp = $em->getRepository('AppBundle:Ocupacion')->agregarOcupacion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Ocupación',
                'descripcion' => 'Se insertó el ocupación: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editOcupacion/{idOcupacion}", name="editOcupacion")
     */
    public function editOcupacionAction($idOcupacion)
    {
        $em = $this->getDoctrine()->getManager();
        $ocupacion = $em->getRepository('AppBundle:Ocupacion')->find($idOcupacion);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Ocupaciones  - Editar Ocupación',
            'descripcion' => 'Formulario para editar la ocupación: '.$ocupacion->getNombre()
        ));

        return $this->render('Nomencladores/editOcupacion.html.twig' , array('ocupacion' => $ocupacion));
    }

    /**
     * @Route("/updateOcupacion", name="updateOcupacion")
     */
    public function updateOcupacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idOcupacion' => $peticion->request->get('idOcupacion'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Ocupacion')->modificarOcupacion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Ocupación',
                'descripcion' => 'Se modificó la ocupación:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteOcupacion", name="deleteOcupacion")
     */
    public function deleteOcupacionAction()
    {
        $peticion = Request::createFromGlobals();
        $idOcupacion = $peticion->request->get('idOcupacion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Ocupacion')->eliminarOcupacion($idOcupacion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Ocupación',
                'descripcion' => 'Se eliminó la ocupación: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # ------------- GESTIÓN DE NIVEL EDUCACIONAL ------------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/gestionarNivelesEducacionales", name="gestionarNivelesEducacionales")
     */
    public function gestionarNivelesEducacionalesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nivelesEducacionales  = $em->getRepository('AppBundle:NivelEducacional')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Niveles Educacionales',
            'descripcion' => 'Listado de Niveles Educacionales'
        ));

        return $this->render('Nomencladores/gestionNivelesEducacionales.html.twig' , array('nivelesEducacionales' => $nivelesEducacionales));
    }

    /**
     * @Route("/addNivelEducacional", name="addNivelEducacional")
     */
    public function addNivelEducacionalAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Nivel de Educación - Agregar Nivel de Educación',
            'descripcion' => 'Formulario para agregar un nivel de educación'
        ));
        return $this->render('Nomencladores/addNivelEducacional.html.twig');
    }

    /**
     * @Route("/insertNivelEducacional", name="insertNivelEducacional")
     */
    public function insertNivelEducacionalAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre')
        );
        $resp = $em->getRepository('AppBundle:NivelEducacional')->agregarNivelEducacional($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Nivel de Educación',
                'descripcion' => 'Se insertó el nivel de educación: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editNivelEducacional/{idNivelEducacional}", name="editNivelEducacional")
     */
    public function editNivelEducacionalAction($idNivelEducacional)
    {
        $em = $this->getDoctrine()->getManager();
        $nivelEducacional = $em->getRepository('AppBundle:NivelEducacional')->find($idNivelEducacional);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Niveles Educacionales  - Editar nivel de educación',
            'descripcion' => 'Formulario para editar el nivel de educación: '.$nivelEducacional->getNombre()
        ));

        return $this->render('Nomencladores/editNivelEducacional.html.twig' , array('nivelEducacional' => $nivelEducacional));
    }

    /**
     * @Route("/updateNivelEducacional", name="updateNivelEducacional")
     */
    public function updateNivelEducacionalAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idNivelEducacional' => $peticion->request->get('idNivelEducacional'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:NivelEducacional')->modificarNivelEducacional($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Nivel Educacional',
                'descripcion' => 'Se modificó el nivel de educación:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteNivelEducacional", name="deleteNivelEducacional")
     */
    public function deleteNivelEducacionalAction()
    {
        $peticion = Request::createFromGlobals();
        $idNivelEducacional = $peticion->request->get('idNivelEducacional');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:NivelEducacional')->eliminarNivelEducacional($idNivelEducacional);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Nivel de Educación',
                'descripcion' => 'Se eliminó el nivel de educación: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # ------------- GESTIÓN DE PARENTESCO ----------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/gestionarParentescos", name="gestionarParentescos")
     */
    public function gestionarParentescosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $parentescos  = $em->getRepository('AppBundle:Parentesco')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Parentescos',
            'descripcion' => 'Listado de Parentescos'
        ));

        return $this->render('Nomencladores/gestionParentescos.html.twig' , array('parentescos' => $parentescos));
    }

    /**
     * @Route("/addParentesco", name="addParentesco")
     */
    public function addParentescoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Parentesco - Agregar Parentesco',
            'descripcion' => 'Formulario para agregar un parentesco'
        ));
        return $this->render('Nomencladores/addParentesco.html.twig');
    }

    /**
     * @Route("/insertParentesco", name="insertParentesco")
     */
    public function insertParentescoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre')
        );
        $resp = $em->getRepository('AppBundle:Parentesco')->agregarParentesco($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Parentesco',
                'descripcion' => 'Se insertó el parentesco: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editParentesco/{idParentesco}", name="editParentesco")
     */
    public function editParentescoAction($idParentesco)
    {
        $em = $this->getDoctrine()->getManager();
        $parentesco = $em->getRepository('AppBundle:Parentesco')->find($idParentesco);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Parentescos  - Editar Parentesco',
            'descripcion' => 'Formulario para editar el parentesco: '.$parentesco->getNombre()
        ));

        return $this->render('Nomencladores/editParentesco.html.twig' , array('parentesco' => $parentesco));
    }

    /**
     * @Route("/updateParentesco", name="updateParentesco")
     */
    public function updateParentescoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idParentesco' => $peticion->request->get('idParentesco'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:Parentesco')->modificarParentesco($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Parentesco',
                'descripcion' => 'Se modificó el parentesco:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteParentesco", name="deleteParentesco")
     */
    public function deleteParentescoAction()
    {
        $peticion = Request::createFromGlobals();
        $idParentesco = $peticion->request->get('idParentesco');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Parentesco')->eliminarParentesco($idParentesco);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Parentesco',
                'descripcion' => 'Se eliminó el parentesco: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # ------------- GESTIÓN DE FACTOR DE RIESGO -------------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/gestionarFactoresRiesgos", name="gestionarFactoresRiesgos")
     */
    public function gestionarFactoresRiesgosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factoresRiesgos  = $em->getRepository('AppBundle:FactorRiesgo')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Factor de Riesgo',
            'descripcion' => 'Listado de Factores de Riesgos'
        ));

        return $this->render('Nomencladores/gestionFactoresRiesgos.html.twig' , array('factoresRiesgos' => $factoresRiesgos));
    }

    /**
     * @Route("/addFactorRiesgo", name="addFactorRiesgo")
     */
    public function addFactorRiesgoAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Factores de Riesgos - Agregar Factor de Riesgo',
            'descripcion' => 'Formulario para agregar un factor de riesgo'
        ));
        return $this->render('Nomencladores/addFactorRiesgo.html.twig');
    }

    /**
     * @Route("/insertFactorRiesgo", name="insertFactorRiesgo")
     */
    public function insertFactorRiesgoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre')
        );
        $resp = $em->getRepository('AppBundle:FactorRiesgo')->agregarFactorRiesgo($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Factor de Riesgo',
                'descripcion' => 'Se insertó el factor de riesgo: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editFactorRiesgo/{idFactorRiesgo}", name="editFactorRiesgo")
     */
    public function editFactorRiesgoAction($idFactorRiesgo)
    {
        $em = $this->getDoctrine()->getManager();
        $factorRiesgo = $em->getRepository('AppBundle:FactorRiesgo')->find($idFactorRiesgo);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Factores de Riesgos  - Editar Factor de Riesgo',
            'descripcion' => 'Formulario para editar el factor de riesgo: '.$factorRiesgo->getNombre()
        ));

        return $this->render('Nomencladores/editFactorRiesgo.html.twig' , array('factorRiesgo' => $factorRiesgo));
    }

    /**
     * @Route("/updateFactorRiesgo", name="updateFactorRiesgo")
     */
    public function updateFactorRiesgoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idFactorRiesgo' => $peticion->request->get('idFactorRiesgo'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:FactorRiesgo')->modificarFactorRiesgo($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Factor de Riesgo',
                'descripcion' => 'Se modificó el factor de riesgo:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteFactorRiesgo", name="deleteFactorRiesgo")
     */
    public function deleteFactorRiesgoAction()
    {
        $peticion = Request::createFromGlobals();
        $idFactorRiesgo = $peticion->request->get('idFactorRiesgo');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:FactorRiesgo')->eliminarFactorRiesgo($idFactorRiesgo);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Factor de Riesgo',
                'descripcion' => 'Se eliminó el factor de riesgo: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # ----- GESTIÓN DE CAUSA DE NO PRESCRIPCION DE TPT ------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/gestionarCausasNoPrescripciones", name="gestionarCausasNoPrescripciones")
     */
    public function gestionarCausasNoPrescripcionesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $causasNoPrescripciones  = $em->getRepository('AppBundle:CausaNoPrescripcionTPT')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Causas de no prescripciones TPT',
            'descripcion' => 'Listado de Causas de no prescripcion TPT'
        ));

        return $this->render('Nomencladores/gestionCausasNoPrescripciones.html.twig' , array('causasNoPrescripciones' => $causasNoPrescripciones));
    }

    /**
     * @Route("/addCausaNoPrescripcion", name="addCausaNoPrescripcion")
     */
    public function addCausaNoPrescripcionAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Causas de No prescripciones TPT - Agregar Causa de no prescripcion TPT',
            'descripcion' => 'Formulario para agregar una Causa de no prescripcion TPT'
        ));
        return $this->render('Nomencladores/addCausaNoPrescripcion.html.twig');
    }

    /**
     * @Route("/insertCausaNoPrescripcion", name="insertCausaNoPrescripcion")
     */
    public function insertCausaNoPrescripcionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre')
        );
        $resp = $em->getRepository('AppBundle:CausaNoPrescripcionTPT')->agregarCausaNoPrescripcion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Causa de no prescripcion TPT',
                'descripcion' => 'Se insertó la Causa de no prescripcion TPT: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editCausaNoPrescripcion/{idCausaNoPrescripcion}", name="editCausaNoPrescripcion")
     */
    public function editCausaNoPrescripcionAction($idCausaNoPrescripcion)
    {
        $em = $this->getDoctrine()->getManager();
        $causaNoPrescripcion = $em->getRepository('AppBundle:CausaNoPrescripcionTPT')->find($idCausaNoPrescripcion);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Causas de no prescripciones TPT  - Editar Causa de no prescripcion TPT',
            'descripcion' => 'Formulario para la Causa de no prescripcion TPT: '.$causaNoPrescripcion->getNombre()
        ));

        return $this->render('Nomencladores/editCausaNoPrescripcion.html.twig' , array('causaNoPrescripcion' => $causaNoPrescripcion));
    }

    /**
     * @Route("/updateCausaNoPrescripcion", name="updateCausaNoPrescripcion")
     */
    public function updateCausaNoPrescripcionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idCausaNoPrescripcion' => $peticion->request->get('idCausaNoPrescripcion'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:CausaNoPrescripcionTPT')->modificarCausaNoPrescripcion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Causa de No Prescripción TPT',
                'descripcion' => 'Se modificó la Causa de No Prescripción TPT:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteCausaNoPrescripcion", name="deleteCausaNoPrescripcion")
     */
    public function deleteCausaNoPrescripcionAction()
    {
        $peticion = Request::createFromGlobals();
        $idCausaNoPrescripcion = $peticion->request->get('idCausaNoPrescripcion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:CausaNoPrescripcionTPT')->eliminarCausaNoPrescripcion($idCausaNoPrescripcion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Causas de No Prescripciones TPT',
                'descripcion' => 'Se eliminó la Causa de No Prescripción TPT: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # --------------- GESTIÓN DE POBLACIÓN ------------------- #
    # -------------------------------------------------------- #


    /**
     * @Route("/gestionarPoblaciones", name="gestionarPoblaciones")
     */
    public function gestionarPoblacionesAction()
    {
        return $this->render('Nomencladores/gestionPoblacion.html.twig' , array(
                'titulo' => 'Población')
        );
    }

    /**
     * @Route("/addPoblacion", name="addPoblacion")
     */
    public function addPoblacionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $niveles = $em->getRepository('AppBundle:NivelAcceso')->listarNivelesAcceso($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Poblaciones - Agregar Población',
            'descripcion' => 'Formulario para agregar una población'
        ));


        return $this->render('Nomencladores/addPoblacion.html.twig' , array(
                'provincias' => $provincias,
                'municipios' => $municipios,
                'nivelesAcceso' => $niveles)
        );
    }
    /**
     * @Route("/insertPoblacion", name="insertPoblacion")
     */
    public function insertPoblacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'anno' => $peticion->request->get('anno'),
            'municipio' => $peticion->request->get('municipio'),
            'edad' => $peticion->request->get('edad'),
            'sexo' => $peticion->request->get('sexo'),
            'total' => $peticion->request->get('total')
        );
        $resp = $em->getRepository('AppBundle:Poblacion')->agregarPoblacion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Población',
                'descripcion' => 'Se insertó la población del año: '.$data['anno']. ' del sexo '. $data['sexo']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editPoblacion/{idPoblacion}", name="editPoblacion")
     */
    public function editPoblacionAction($idPoblacion)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $niveles = $em->getRepository('AppBundle:NivelAcceso')->listarNivelesAcceso($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $poblacion = $em->getRepository('AppBundle:Poblacion')->find($idPoblacion);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Usuarios  - Editar Población',
            'descripcion' => 'Formulario para editar la población '
        ));

        return $this->render('Nomencladores/editPoblacion.html.twig' , array(
                'idPoblacion' => $idPoblacion,
                'poblacion' => $poblacion,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'nivelesAcceso' => $niveles)
        );
    }

    /**
     * @Route("/updatePoblacion", name="updatePoblacion")
     */
    public function updatePoblacionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPoblacion' => $peticion->request->get('idPoblacion'),
            'anno' => $peticion->request->get('anno'),
            'municipio' => $peticion->request->get('municipio'),
            'edad' => $peticion->request->get('edad'),
            'sexo' => $peticion->request->get('sexo'),
            'total' => $peticion->request->get('total')
        );


        $resp = $em->getRepository('AppBundle:Poblacion')->modificarPoblacion($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Población',
                'descripcion' => 'Se modificó ela población del año: '.$data['anno']. ' del sexo '. $data['sexo']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deletePoblacion", name="deletePoblacion")
     */
    public function deletePoblacionAction()
    {
        $peticion = Request::createFromGlobals();
        $idPoblacion = $peticion->request->get('idPoblacion');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:Poblacion')->eliminarPoblacion($idPoblacion);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar total de Población',
                'descripcion' => 'Se eliminó el total de Población del año: '. $resp->getYear(). ' del sexo '. $resp->getSexo()
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/poblacionAjax", name="cpoblacionAjax")
     */
    public function poblacionAjaxAction()
    {
        $consulta = "SELECT e.id, e.year, p.nombre AS provincia, m.nombre AS municipio, e.edad, e.sexo, e.total
                    FROM AppBundle:Poblacion e JOIN e.municipio m JOIN m.provincia p";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:Poblacion e";

        $output = $this->dataTablePoblacionAjax($consulta ,$totalRecords , 'poblacion');

        return new Response(json_encode($output));
    }

    private function dataTablePoblacionAjax($consulta ,$totalRecords , $origen)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dql = $consulta;
        $dqlTotalRecords = $totalRecords;
        $dqlCountFiltered = $totalRecords;

        //Esto es para armar el filtro que viene del front
        $sqlFilter = "";

        if (!empty($_GET['search']['value'])) {
            $strMainSearch = $_GET['search']['value'];

            $sqlFilter .= " (e.year LIKE '%".$strMainSearch."%' OR "
                ."p.nombre  LIKE '%".$strMainSearch."%' OR "
                ."m.nombre  LIKE '%".$strMainSearch."%' OR "
                ."e.edad  LIKE '%".$strMainSearch."%' OR "
                ."e.sexo  LIKE '%".$strMainSearch."%' OR "
                ."e.total  LIKE '%".$strMainSearch."%') ";
        }

        //Armar el buscador de los footer
        // Filter columns with AND restriction
        $strColSearch = "";
        foreach ($_GET['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if (!empty($strColSearch)) {
                    $strColSearch .= ' AND ';
                }
                if (!empty($column['search']['value']))
                {
                    switch ($column['name'])
                    {
                        case 'year': $strColSearch .= " e.year LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'provincia':  $strColSearch .= " p.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'municipio':  $strColSearch .= " m.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'edad':  $strColSearch .= " e.edad LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'sexo':  $strColSearch .= " e.sexo LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'total':  $strColSearch .= " e.total LIKE '%".$column['search']['value']."%' ";
                            break;
                    }
                }
            }
        }
        if (!empty($sqlFilter) and !empty($strColSearch)) {
            $sqlFilter .= ' AND ('.$strColSearch.')';
        } else {
            $sqlFilter .= $strColSearch;
        }

        if (!empty($sqlFilter)) {
            if(strpos($dql , 'WHERE'))
            {
                $dql .= ' AND'.$sqlFilter;
                $dqlCountFiltered .= ' AND'.$sqlFilter;
            }else{
                $dql .= ' WHERE'.$sqlFilter;
                $dqlCountFiltered .= ' WHERE'.$sqlFilter;
            }
        }

        //order
        $camposOrden = $this->orderPorNivelesAcccesoPoblacion($_GET['order']);
        if(substr($camposOrden , -1) === ',') $camposOrden = substr($camposOrden, 0, -1);
        $dql .=' ORDER BY'.$camposOrden;

        $items = $entityManager
            ->createQuery($dql)
            ->setFirstResult($_GET['start'])
            ->setMaxResults($_GET['length'])
            ->getResult();

        $data = array();
        foreach ($items as $key => $value) {
            if(in_array("ROLE_EDITOR_ESTADISTICA" , $user->getRoles()) or in_array("ROLE_SUPERUSUARIO" , $user->getRoles())) {
                $vinculoActualizar = $this->generateUrl('editPoblacion', array('idPoblacion' => $value['id']));
                $acciones = "<div class=\"btn-opt\" id=\"actualizar\" style=\"background: #3a81b8; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Actualizar\">
                                            <a href=\"$vinculoActualizar\" style=\"text-decoration: none; color: #ffffff\">
                                                <i class=\"glyphicon glyphicon-pencil\" style=\"font-size: 20px\"></i>
                                            </a>
                                        </div>";
                $id = $value['id'];
                $acciones .= "<div class=\"btn-opt delete\" name=\"$id\"   id=\"$id\" style=\"background: #e42d26; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Borrar\">
                                            <i class=\"glyphicon glyphicon-erase\" style=\"font-size: 20px\"></i>
                                        </div>";
            }

            $data[] = array(
                $value['year'],
                $value['provincia'],
                $value['municipio'],
                $value['edad'],
                $value['sexo'],
                $value['total'],
                $acciones,
            );

        }

        $recordsTotal = $entityManager
            ->createQuery($dqlTotalRecords)
            ->getSingleScalarResult();

        $recordsFiltered = $entityManager
            ->createQuery($dqlCountFiltered)
            ->getSingleScalarResult();

        $output = array(
            'draw' => 0,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'dql' => $dql,
            'dqlCountFiltered' => $dqlCountFiltered,
        );

        return $output;
    }

    //genera la cadena de ordenamiento pare devolver los valores en el datatable
    private function orderPorNivelesAcccesoPoblacion($orders)
    {
        $camposOrden = '';

        foreach ($orders as $order)
        {
            if($order['column'] != "")
            {
                switch ($order['column'])
                {
                    case '0':
                        $camposOrden .= ' TRIM(e.year) '.$order['dir'].',';
                        break;
                    case '1':
                        $camposOrden .= ' TRIM(p.nombre) '.$order['dir'].',';
                        break;
                    case '2':
                        $camposOrden .= ' TRIM(m.nombre) '.$order['dir'].',';
                        break;
                    case '3':
                        $camposOrden .= ' TRIM(e.edad) '.$order['dir'].',';
                        break;
                    case '4':
                        $camposOrden .= ' TRIM(e.sexo) '.$order['dir'].',';
                        break;
                    case '5':
                        $camposOrden .= ' TRIM(e.total) '.$order['dir'].',';
                        break;
                }
            }
        }
        return $camposOrden;
    }

}
