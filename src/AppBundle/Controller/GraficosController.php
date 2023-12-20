<?php

namespace AppBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GraficosController extends Controller
{

    # -------------------------------------------------------- #
    # ----------------------- MAPAS -------------------------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/mapaCasos", name="mapaCasos")
     */
    public function mapaCasosAction()
    {
        $fechaActual = new DateTime('Now');
        $inicial = $fechaActual->format('Y-01-01');
        $final = $fechaActual->format('Y-m-d');

        $em = $this->getDoctrine()->getManager();
        $years = $em->getRepository('AppBundle:PacienteEvolucion')->yearExistentes();
        $datos = $em->getRepository('AppBundle:PacienteEvolucion')->yearCasos($inicial,$final);

        return $this->render('Graficos/mapaCasos.html.twig', array(
            'years' => $years,
            'datos' => $datos));

    }

    /**
     * @Route("/buscarYearMapasCasos", name="buscarYearMapasCasos")
     * @throws \Exception
     */
    public function buscarYearMapasCasosAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $year = $peticion->request->get('year');
        $fechaActual = new DateTime('now');
        $yearActual = $fechaActual->format('Y');
        $fechaInicio = $year . '-01-01';
        $inicial = new DateTime($fechaInicio);

        if ($yearActual === $year) {
            $final = $fechaActual->format('Y-m-d');
        }else {
            $fechaFinal =  $year . '-12-31';
            $final = new DateTime($fechaFinal);
        }

        $datos = $em->getRepository('AppBundle:PacienteEvolucion')->yearCasos($inicial,$final);

        if (is_string($datos)) {
            return new Response($datos);
        }

        $result = json_encode($datos);

        return new JsonResponse($result);

    }

    # -------------------------------------------------------- #
    # ----------------------- GRÁFICOS ----------------------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/graficoCasos", name="graficoCasos")
     */
    public function graficoCasosAction()
    {

        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:PacienteEvolucion')->categorias($fechaInicio,$fechaFinal);
        $notificadosYears = $em->getRepository('AppBundle:PacienteEvolucion')->notificadosYears();
        $gruposVulnerables = $em->getRepository('AppBundle:PacienteEvolucion')->gruposVulnerables($fechaInicio,$fechaFinal);
        $resultadosTratamientos = $em->getRepository('AppBundle:PacienteEvolucion')->resultadosTratamientos($fechaInicio,$fechaFinal);

        return $this->render('Graficos/graficoCasos.html.twig', array(
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal,
            'categorias' => $categorias,
            'notificadosYears' => $notificadosYears,
            'gruposVulnerables' => $gruposVulnerables,
            'resultadosTratamientos' => $resultadosTratamientos
            ));

    }

    /**
     * @Route("/graficoCasosBuscar", name="graficoCasosBuscar")
     */
    public function graficoCasosBuscarAction()
    {

        $peticion = Request::createFromGlobals();
        $fechaInicio = new DateTime($peticion->request->get('fechaInicio'));
        $fechaFinal = new DateTime($peticion->request->get('fechaFinal'));

        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:PacienteEvolucion')->categorias($fechaInicio,$fechaFinal);
        $gruposVulnerables = $em->getRepository('AppBundle:PacienteEvolucion')->gruposVulnerables($fechaInicio,$fechaFinal);
        $resultadosTratamientos = $em->getRepository('AppBundle:PacienteEvolucion')->resultadosTratamientos($fechaInicio,$fechaFinal);

        $graficos = array(
            'categorias' => $categorias,
            'gruposVulnerables' => $gruposVulnerables,
            'resultados' => $resultadosTratamientos,
        );

        if (is_string($categorias)) {
            return new Response($categorias);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoCategoriaEntradaProvincias", name="graficoCategoriaEntradaProvincias")
     */
    public function graficoCategoriaEntradaProvinciasAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $inicial = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $codigo = $peticion->request->get('codigo');

        $categoriasProvincias = $em->getRepository('AppBundle:PacienteEvolucion')->categoriasProvincias($inicial,$final,$codigo);
        $notificadosYearsCategoria = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaNotificadosYears($codigo);
        $gruposVulnerablesCategoria = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaGruposVulnerables($inicial,$final,$codigo);
        $resultadosTratamientosCategoria = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaResultadosTratamiento($inicial,$final,$codigo);

        $graficos = array(
            'categoriasProvincias' => $categoriasProvincias,
            'notificadosYearsCategoria' => $notificadosYearsCategoria,
            'gruposVulnerablesCategoria' => $gruposVulnerablesCategoria,
            'resultadosTratamientosCategoria' => $resultadosTratamientosCategoria,
        );

        if (is_string($categoriasProvincias)) {
            return new Response($categoriasProvincias);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoCategoriaEntradaMunicipios", name="graficoCategoriaEntradaMunicipios")
     */
    public function graficoCategoriaEntradaMunicipiosAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $inicial = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $codigo = $peticion->request->get('codigo');
        $provincia = $peticion->request->get('provincia');

        $categoriasMunicipios = $em->getRepository('AppBundle:PacienteEvolucion')->categoriasMunicipios($inicial,$final,$codigo,$provincia);
        $categoriaProvinciaNotificadosYears = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaProvinciaNotificadosYears($codigo,$provincia);
        $categoriaProvinciaGruposVulnerables = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaProvinciaGruposVulnerables($inicial,$final,$codigo,$provincia);
        $categoriaProvinciaResultadosTratamientos = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaProvinciaResultadosTratamiento($inicial,$final,$codigo,$provincia);

        $graficos = array(
            'categoriasMunicipios' => $categoriasMunicipios,
            'categoriaProvinciaNotificadosYears' => $categoriaProvinciaNotificadosYears,
            'categoriaProvinciaGruposVulnerables' => $categoriaProvinciaGruposVulnerables,
            'categoriaProvinciaResultadosTratamientos' => $categoriaProvinciaResultadosTratamientos,
        );

        if (is_string($categoriasMunicipios)) {
            return new Response($categoriasMunicipios);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoCategoriaEntradaRepartos", name="graficoCategoriaEntradaRepartos")
     */
    public function graficoCategoriaEntradaRepartosAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $inicial = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $codigo = $peticion->request->get('codigo');
        $municipio = $peticion->request->get('municipio');

        $categoriaMunicipioNotificadosYears = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaMunicipioNotificadosYears($codigo,$municipio);
        $categoriaMunicipioGruposVulnerables = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaMunicipioGruposVulnerables($inicial,$final,$codigo,$municipio);
        $categoriaMunicipioResultadosTratamientos = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaMunicipioResultadosTratamiento($inicial,$final,$codigo,$municipio);

        $graficos = array(
            'categoriaMunicipioNotificadosYears' => $categoriaMunicipioNotificadosYears,
            'categoriaMunicipioGruposVulnerables' => $categoriaMunicipioGruposVulnerables,
            'categoriaMunicipioResultadosTratamientos' => $categoriaMunicipioResultadosTratamientos,
        );

        if (is_string($categoriaMunicipioNotificadosYears)) {
            return new Response($categoriaMunicipioNotificadosYears);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoGrupoVulnerableCategoria", name="graficoGrupoVulnerableCategoria")
     */
    public function graficoGrupoVulnerableCategoriaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $inicial = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $codigo = $peticion->request->get('codigo');

        $gruposVulnerablesCategorias = $em->getRepository('AppBundle:PacienteEvolucion')->categoriaGruposVulnerables($inicial,$final,$codigo);

        if (is_string($gruposVulnerablesCategorias)) {
            return new Response($gruposVulnerablesCategorias);
        }

        $result = json_encode($gruposVulnerablesCategorias);
        return new JsonResponse($result);

    }

    /**
     * @Route("/graficoCasosYears", name="graficoCasosYears")
     */
    public function graficoCasosYearsAction()
    {

        $peticion = Request::createFromGlobals();
        $year = $peticion->request->get('year');
        $fechaActual = new DateTime('now');
        $yearActual = $fechaActual->format('Y');
        $inicial = $year . '-01-01';

        if ($yearActual === $year) {
            $final = $fechaActual->format('Y-m-d');
        }else {
            $final = $year . '-12-31';
        }

        $fechaInicio = new DateTime($inicial);
        $fechaFinal = new DateTime($final);

        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository('AppBundle:PacienteEvolucion')->categorias($fechaInicio,$fechaFinal);
        $gruposVulnerables = $em->getRepository('AppBundle:PacienteEvolucion')->gruposVulnerables($fechaInicio,$fechaFinal);
        $resultadosTratamientos = $em->getRepository('AppBundle:PacienteEvolucion')->resultadosTratamientos($fechaInicio,$fechaFinal);

        $graficos = array(
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal,
            'categorias' => $categorias,
            'gruposVulnerables' => $gruposVulnerables,
            'resultados' => $resultadosTratamientos,
        );

        if (is_string($categorias)) {
            return new Response($categorias);
        }

        $result = json_encode($graficos);
        return new JsonResponse($result);

    }

}
