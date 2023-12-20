<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PreguntasController extends Controller
{
    /**
     * @Route("/listarPreguntas", name="listarPreguntas")
     */
    public function listarPreguntasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $preguntas  = $em->getRepository('AppBundle:PreguntaRespuesta')->findAll();

        return $this->render('Preguntas/listarPreguntas.html.twig' , array('preguntas' => $preguntas));
    }

    # -------------------------------------------------------- #
    # -------- GESTIÓN DE CATEGORÍAS DE PREGUNTAS ------------ #
    # -------------------------------------------------------- #

    /**
     * @Route("/gestionarCategoriaPregunta", name="gestionarCategoriaPregunta")
     */
    public function gestionarCategoriaPreguntaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categoriasPreguntas  = $em->getRepository('AppBundle:CategoriaPregunta')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Nomencladores - Gestionar Categoría de Pregunta',
            'descripcion' => 'Listado de categorías de preguntas'
        ));

        return $this->render('Preguntas/gestionCategoriaPregunta.html.twig' , array('categoriasPreguntas' => $categoriasPreguntas));
    }

    /**
     * @Route("/addCategoriaPregunta", name="addCategoriaPregunta")
     */
    public function addCategoriaPreguntaAction()
    {
        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar categoría de pregunta - Agregar categoría de pregunta',
            'descripcion' => 'Formulario para agregar una categoría de pregunta'
        ));
        return $this->render('Preguntas/addCategoriaPregunta.html.twig');
    }

    /**
     * @Route("/insertCategoriaPregunta", name="insertCategoriaPregunta")
     */
    public function insertCategoriaPreguntaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:CategoriaPregunta')->agregarCategoriaPregunta($data);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar categoría de pregunta',
                'descripcion' => 'Se insertó un nueva categoría de pregunta con el nombre: '.$data['nombre']
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/editCategoriaPregunta/{idCategoriaPregunta}", name="editCategoriaPregunta")
     */
    public function editCategoriaPreguntaAction($idCategoriaPregunta)
    {
        $em = $this->getDoctrine()->getManager();
        $categoriaPregunta = $em->getRepository('AppBundle:CategoriaPregunta')->find($idCategoriaPregunta);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar categoría de pregunta - Editar la categoría',
            'descripcion' => 'Formulario para editar la categoría: '.$categoriaPregunta->getNombre()
        ));

        return $this->render('Preguntas/editCategoriaPregunta.html.twig' , array('categoriaPregunta' => $categoriaPregunta));
    }

    /**
     * @Route("/updateCategoriaPregunta", name="updateCategoriaPregunta")
     */
    public function updateCategoriaPreguntaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idCategoriaPregunta' => $peticion->request->get('idCategoriaPregunta'),
            'nombre' => $peticion->request->get('nombre'),
        );

        $resp = $em->getRepository('AppBundle:CategoriaPregunta')->modificarCategoriaPregunta($data);


        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar categoría de pregunta',
                'descripcion' => 'Se modificó la categoría:  '.$data['nombre']
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteCategoriaPregunta", name="deleteCategoriaPregunta")
     */
    public function deleteCategoriaPreguntaAction()
    {
        $peticion = Request::createFromGlobals();
        $idCategoriaPregunta = $peticion->request->get('idCategoriaPregunta');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:CategoriaPregunta')->eliminarCategoriaPregunta($idCategoriaPregunta);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar categoría de pregunta',
                'descripcion' => 'Se eliminó la categoría: '.$resp->getNombre()
            ));
            return new Response('ok');
        }
    }

    # -------------------------------------------------------- #
    # -------- GESTIÓN DE PREGUNTAS Y RESPUESTAS ------------- #
    # -------------------------------------------------------- #


    /**
     * @Route("/gestionarPreguntas", name="gestionarPreguntas")
     */
    public function gestionarPreguntasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $preguntas  = $em->getRepository('AppBundle:PreguntaRespuesta')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Preguntas - Gestionar Preguntas',
            'descripcion' => 'Listado de Preguntas'
        ));

        return $this->render('Preguntas/gestionPreguntas.html.twig' ,
            array('preguntas' => $preguntas));
    }

    /**
     * @Route("/gestionarPreguntasCategoria/{idCategoriaPregunta}", name="gestionarPreguntasCategoria")
     */
    public function gestionarPreguntasCategoriaAction($idCategoriaPregunta)
    {
        $em = $this->getDoctrine()->getManager();
        $categoriaPregunta = $em->getRepository('AppBundle:CategoriaPregunta')->find($idCategoriaPregunta);
        $preguntas  = $em->getRepository('AppBundle:PreguntaRespuesta')->findBy(array('categoriaPregunta' => $idCategoriaPregunta));

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Preguntas - Gestionar Preguntas',
            'descripcion' => 'Listado de preguntas'
        ));

        return $this->render('Preguntas/gestionPreguntasCategorias.html.twig' ,
            array('preguntas' => $preguntas,
                'categoriaPregunta' => $categoriaPregunta
            ));
    }

    /**
     * @Route("/addPregunta", name="addPregunta")
     */
    public function addPreguntaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categoriaPreguntas = $em->getRepository('AppBundle:CategoriaPregunta')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Preguntas - Agregar Pregunta',
            'descripcion' => 'Formulario para agregar una pregunta'
        ));

        return $this->render('Preguntas/addPregunta.html.twig' ,
            array('categoriaPreguntas' => $categoriaPreguntas,
            ));
    }

    /**
     * @Route("/addPreguntaCategoria/{idCategoriaPregunta}", name="addPreguntaCategoria")
     */
    public function addPreguntaCategoriaAction($idCategoriaPregunta)
    {
        $em = $this->getDoctrine()->getManager();
        $categoriaPregunta = $em->getRepository('AppBundle:CategoriaPregunta')->find($idCategoriaPregunta);
        $categoriaPreguntas = $em->getRepository('AppBundle:CategoriaPregunta')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Pregunta - Agregar Pregunta',
            'descripcion' => 'Formulario para agregar una pregunta'
        ));

        return $this->render('Preguntas/addPreguntaCategoria.html.twig' ,
            array('categoriaPregunta' => $categoriaPregunta,
                'categoriaPreguntas' => $categoriaPreguntas,
            ));
    }

    /**
     * @Route("/insertPregunta", name="insertPregunta")
     */
    public function insertPreguntaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'pregunta' => $peticion->request->get('pregunta'),
            'respuesta' => $peticion->request->get('respuesta'),
            'idCategoriaPregunta' => $peticion->request->get('categoriaPregunta')
        );

        $pregunta = $em->getRepository('AppBundle:PreguntaRespuesta')->agregarPregunta($data);

        if(is_string($pregunta)) return new Response($pregunta);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Pregunta',
                'descripcion' => 'Se insertó una nueva pregunta '
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editPregunta/{idPregunta}", name="editPregunta")
     */
    public function editPreguntaAction($idPregunta)
    {
        $em = $this->getDoctrine()->getManager();
        $pregunta = $em->getRepository('AppBundle:PreguntaRespuesta')->find($idPregunta);
        $categoriaPreguntas = $em->getRepository('AppBundle:CategoriaPregunta')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Preguntas - Editar Pregunta',
            'descripcion' => 'Formulario para editar una pregunta'
        ));

        return $this->render('Preguntas/editPregunta.html.twig' , array(
            'pregunta' => $pregunta,
            'categoriaPreguntas' => $categoriaPreguntas
        ));
    }

    /**
     * @Route("/editPreguntaCategoria/{idPregunta}", name="editPreguntaCategoria")
     */
    public function editPreguntaCategoriaAction($idPregunta)
    {
        $em = $this->getDoctrine()->getManager();
        $pregunta = $em->getRepository('AppBundle:PreguntaRespuesta')->find($idPregunta);
        $idCategoriaPregunta = $pregunta ->getCategoriaPregunta()->getId();
        $categoriaPregunta = $em->getRepository('AppBundle:CategoriaPregunta')->find($idCategoriaPregunta);
        $categoriaPreguntas = $em->getRepository('AppBundle:CategoriaPregunta')->findAll();

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Gestionar Preguntas - Editar Pregunta',
            'descripcion' => 'Formulario para editar la pregunta '
        ));

        return $this->render('Preguntas/editPreguntaCategoria.html.twig' , array(
            'categoriaPregunta' => $categoriaPregunta,
            'pregunta' => $pregunta,
            'categoriaPreguntas' => $categoriaPreguntas
        ));
    }

    /**
     * @Route("/updatePregunta", name="updatePregunta")
     */
    public function updatePreguntaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idPregunta' => $peticion->request->get('idPregunta'),
            'idCategoriaPregunta' => $peticion->request->get('idCategoriaPregunta'),
            'pregunta' => $peticion->request->get('pregunta'),
            'respuesta' => $peticion->request->get('respuesta')
        );

        $pregunta = $em->getRepository('AppBundle:PreguntaRespuesta')->modificarPregunta($data);

        if(is_string($pregunta)) return new Response($pregunta);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Pregunta',
                'descripcion' => 'Se modificó la pregunta'
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deletePregunta", name="deletePregunta")
     */
    public function deletePreguntaAction()
    {
        $peticion = Request::createFromGlobals();
        $idPregunta = $peticion->request->get('idPregunta');
        $em = $this->getDoctrine()->getManager();

        $pregunta  = $em->getRepository('AppBundle:PreguntaRespuesta')->eliminarPregunta($idPregunta);

        if(is_string($pregunta)) return new Response($pregunta);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Pregunta',
                'descripcion' => 'Se eliminó la pregunta'
            ));
            return new Response('ok');
        }
    }

}
