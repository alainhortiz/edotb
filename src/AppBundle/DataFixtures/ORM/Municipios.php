<?php
/**
 * Created by PhpStorm.
 * User: Yadrian
 * Date: 09/10/2017
 * Time: 01:50 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Municipio;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Municipios extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            array('codigo' => '2101', 'nombre' => 'SANDINO', 'provincia' => '21'),
            array('codigo' => '2102', 'nombre' => 'MANTUA', 'provincia' => '21'),
            array('codigo' => '2103', 'nombre' => 'MINAS DE MATAHAMBRE', 'provincia' => '21'),
            array('codigo' => '2104', 'nombre' => 'VINALES', 'provincia' => '21'),
            array('codigo' => '2105', 'nombre' => 'LA PALMA', 'provincia' => '21'),
            array('codigo' => '2106', 'nombre' => 'LOS PALACIOS', 'provincia' => '21'),
            array('codigo' => '2107', 'nombre' => 'CONSOLACION DEL SUR', 'provincia' => '21'),
            array('codigo' => '2108', 'nombre' => 'PINAR DEL RIO', 'provincia' => '21'),
            array('codigo' => '2109', 'nombre' => 'SAN LUIS', 'provincia' => '21'),
            array('codigo' => '2110', 'nombre' => 'SAN JUAN Y MARTINEZ', 'provincia' => '21'),
            array('codigo' => '2111', 'nombre' => 'GUANE', 'provincia' => '21'),
            array('codigo' => '2201', 'nombre' => 'BAHIA HONDA', 'provincia' => '22'),
            array('codigo' => '2202', 'nombre' => 'MARIEL', 'provincia' => '22'),
            array('codigo' => '2203', 'nombre' => 'GUANAJAY', 'provincia' => '22'),
            array('codigo' => '2204', 'nombre' => 'CAIMITO', 'provincia' => '22'),
            array('codigo' => '2205', 'nombre' => 'BAUTA', 'provincia' => '22'),
            array('codigo' => '2206', 'nombre' => 'SAN ANTONIO DE LOS BANOS', 'provincia' => '22'),
            array('codigo' => '2207', 'nombre' => 'GUIRA DE MELENA', 'provincia' => '22'),
            array('codigo' => '2208', 'nombre' => 'ALQUIZAR', 'provincia' => '22'),
            array('codigo' => '2209', 'nombre' => 'ARTEMISA', 'provincia' => '22'),
            array('codigo' => '2210', 'nombre' => 'CANDELARIA', 'provincia' => '22'),
            array('codigo' => '2211', 'nombre' => 'SAN CRISTOBAL', 'provincia' => '22'),
            array('codigo' => '2301', 'nombre' => 'PLAYA', 'provincia' => '23'),
            array('codigo' => '2302', 'nombre' => 'PLAZA DE LA REVOLUCION', 'provincia' => '23'),
            array('codigo' => '2303', 'nombre' => 'CENTRO HABANA', 'provincia' => '23'),
            array('codigo' => '2304', 'nombre' => 'LA HABANA VIEJA', 'provincia' => '23'),
            array('codigo' => '2305', 'nombre' => 'REGLA', 'provincia' => '23'),
            array('codigo' => '2306', 'nombre' => 'LA HABANA DEL ESTE', 'provincia' => '23'),
            array('codigo' => '2307', 'nombre' => 'GUANABACOA', 'provincia' => '23'),
            array('codigo' => '2308', 'nombre' => 'SAN MIGUEL DEL PADRON', 'provincia' => '23'),
            array('codigo' => '2309', 'nombre' => 'DIEZ DE OCTUBRE', 'provincia' => '23'),
            array('codigo' => '2310', 'nombre' => 'CERRO', 'provincia' => '23'),
            array('codigo' => '2311', 'nombre' => 'MARIANAO', 'provincia' => '23'),
            array('codigo' => '2312', 'nombre' => 'LA LISA', 'provincia' => '23'),
            array('codigo' => '2313', 'nombre' => 'BOYEROS', 'provincia' => '23'),
            array('codigo' => '2314', 'nombre' => 'ARROYO NARANJO', 'provincia' => '23'),
            array('codigo' => '2315', 'nombre' => 'COTORRO', 'provincia' => '23'),
            array('codigo' => '2401', 'nombre' => 'BEJUCAL', 'provincia' => '24'),
            array('codigo' => '2402', 'nombre' => 'SAN JOSE DE LAS LAJAS', 'provincia' => '24'),
            array('codigo' => '2403', 'nombre' => 'JARUCO', 'provincia' => '24'),
            array('codigo' => '2404', 'nombre' => 'SANTA CRUZ DEL NORTE', 'provincia' => '24'),
            array('codigo' => '2405', 'nombre' => 'MADRUGA', 'provincia' => '24'),
            array('codigo' => '2406', 'nombre' => 'NUEVA PAZ', 'provincia' => '24'),
            array('codigo' => '2407', 'nombre' => 'SAN NICOLAS', 'provincia' => '24'),
            array('codigo' => '2408', 'nombre' => 'GUINES', 'provincia' => '24'),
            array('codigo' => '2409', 'nombre' => 'MELENA DEL SUR', 'provincia' => '24'),
            array('codigo' => '2410', 'nombre' => 'BATABANO', 'provincia' => '24'),
            array('codigo' => '2411', 'nombre' => 'QUIVICAN', 'provincia' => '24'),
            array('codigo' => '2501', 'nombre' => 'MATANZAS', 'provincia' => '25'),
            array('codigo' => '2502', 'nombre' => 'CARDENAS', 'provincia' => '25'),
            array('codigo' => '2503', 'nombre' => 'MARTI', 'provincia' => '25'),
            array('codigo' => '2504', 'nombre' => 'COLON', 'provincia' => '25'),
            array('codigo' => '2505', 'nombre' => 'PERICO', 'provincia' => '25'),
            array('codigo' => '2506', 'nombre' => 'JOVELLANOS', 'provincia' => '25'),
            array('codigo' => '2507', 'nombre' => 'PEDRO BETANCOURT', 'provincia' => '25'),
            array('codigo' => '2508', 'nombre' => 'LIMONAR', 'provincia' => '25'),
            array('codigo' => '2509', 'nombre' => 'UNION DE REYES', 'provincia' => '25'),
            array('codigo' => '2510', 'nombre' => 'CIENAGA DE ZAPATA', 'provincia' => '25'),
            array('codigo' => '2511', 'nombre' => 'JAGUEY GRANDE', 'provincia' => '25'),
            array('codigo' => '2512', 'nombre' => 'CALIMETE', 'provincia' => '25'),
            array('codigo' => '2513', 'nombre' => 'LOS ARABOS', 'provincia' => '25'),
            array('codigo' => '2601', 'nombre' => 'CORRALILLO', 'provincia' => '26'),
            array('codigo' => '2602', 'nombre' => 'QUEMADO DE GUINES', 'provincia' => '26'),
            array('codigo' => '2603', 'nombre' => 'SAGUA LA GRANDE', 'provincia' => '26'),
            array('codigo' => '2604', 'nombre' => 'ENCRUCIJADA', 'provincia' => '26'),
            array('codigo' => '2605', 'nombre' => 'CAMAJUANI', 'provincia' => '26'),
            array('codigo' => '2606', 'nombre' => 'CAIBARIEN', 'provincia' => '26'),
            array('codigo' => '2607', 'nombre' => 'REMEDIOS', 'provincia' => '26'),
            array('codigo' => '2608', 'nombre' => 'PLACETAS', 'provincia' => '26'),
            array('codigo' => '2609', 'nombre' => 'SANTA CLARA', 'provincia' => '26'),
            array('codigo' => '2610', 'nombre' => 'CIFUENTES', 'provincia' => '26'),
            array('codigo' => '2611', 'nombre' => 'SANTO DOMINGO', 'provincia' => '26'),
            array('codigo' => '2612', 'nombre' => 'RANCHUELO', 'provincia' => '26'),
            array('codigo' => '2613', 'nombre' => 'MANICARAGUA', 'provincia' => '26'),
            array('codigo' => '2701', 'nombre' => 'AGUADA DE PASAJEROS', 'provincia' => '27'),
            array('codigo' => '2702', 'nombre' => 'RODAS', 'provincia' => '27'),
            array('codigo' => '2703', 'nombre' => 'PALMIRA', 'provincia' => '27'),
            array('codigo' => '2704', 'nombre' => 'LAJAS', 'provincia' => '27'),
            array('codigo' => '2705', 'nombre' => 'CRUCES', 'provincia' => '27'),
            array('codigo' => '2706', 'nombre' => 'CUMANAYAGUA', 'provincia' => '27'),
            array('codigo' => '2707', 'nombre' => 'CIENFUEGOS', 'provincia' => '27'),
            array('codigo' => '2708', 'nombre' => 'ABREUS', 'provincia' => '27'),
            array('codigo' => '2801', 'nombre' => 'YAGUAJAY', 'provincia' => '28'),
            array('codigo' => '2802', 'nombre' => 'JATIBONICO', 'provincia' => '28'),
            array('codigo' => '2803', 'nombre' => 'TAGUASCO', 'provincia' => '28'),
            array('codigo' => '2804', 'nombre' => 'CABAIGUAN', 'provincia' => '28'),
            array('codigo' => '2805', 'nombre' => 'FOMENTO', 'provincia' => '28'),
            array('codigo' => '2806', 'nombre' => 'TRINIDAD', 'provincia' => '28'),
            array('codigo' => '2807', 'nombre' => 'SANCTI SPIRITUS', 'provincia' => '28'),
            array('codigo' => '2808', 'nombre' => 'LA SIERPE', 'provincia' => '28'),
            array('codigo' => '2901', 'nombre' => 'CHAMBAS', 'provincia' => '29'),
            array('codigo' => '2902', 'nombre' => 'MORON', 'provincia' => '29'),
            array('codigo' => '2903', 'nombre' => 'BOLIVIA', 'provincia' => '29'),
            array('codigo' => '2904', 'nombre' => 'PRIMERO DE ENERO', 'provincia' => '29'),
            array('codigo' => '2905', 'nombre' => 'CIRO REDONDO', 'provincia' => '29'),
            array('codigo' => '2906', 'nombre' => 'FLORENCIA', 'provincia' => '29'),
            array('codigo' => '2907', 'nombre' => 'MAJAGUA', 'provincia' => '29'),
            array('codigo' => '2908', 'nombre' => 'CIEGO DE AVILA', 'provincia' => '29'),
            array('codigo' => '2909', 'nombre' => 'VENEZUELA', 'provincia' => '29'),
            array('codigo' => '2910', 'nombre' => 'BARAGUA', 'provincia' => '29'),
            array('codigo' => '3001', 'nombre' => 'CARLOS MANUEL DE CESPEDES', 'provincia' => '30'),
            array('codigo' => '3002', 'nombre' => 'ESMERALDA', 'provincia' => '30'),
            array('codigo' => '3003', 'nombre' => 'SIERRA DE CUBITAS', 'provincia' => '30'),
            array('codigo' => '3004', 'nombre' => 'MINAS', 'provincia' => '30'),
            array('codigo' => '3005', 'nombre' => 'NUEVITAS', 'provincia' => '30'),
            array('codigo' => '3006', 'nombre' => 'GUAIMARO', 'provincia' => '30'),
            array('codigo' => '3007', 'nombre' => 'SIBANICU', 'provincia' => '30'),
            array('codigo' => '3008', 'nombre' => 'CAMAGUEY', 'provincia' => '30'),
            array('codigo' => '3009', 'nombre' => 'FLORIDA', 'provincia' => '30'),
            array('codigo' => '3010', 'nombre' => 'VERTIENTES', 'provincia' => '30'),
            array('codigo' => '3011', 'nombre' => 'JIMAGUAYU', 'provincia' => '30'),
            array('codigo' => '3012', 'nombre' => 'NAJASA', 'provincia' => '30'),
            array('codigo' => '3013', 'nombre' => 'SANTA CRUZ DEL SUR', 'provincia' => '30'),
            array('codigo' => '3101', 'nombre' => 'MANATI', 'provincia' => '31'),
            array('codigo' => '3102', 'nombre' => 'PUERTO PADRE', 'provincia' => '31'),
            array('codigo' => '3103', 'nombre' => 'JESUS MENENDEZ', 'provincia' => '31'),
            array('codigo' => '3104', 'nombre' => 'MAJIBACOA', 'provincia' => '31'),
            array('codigo' => '3105', 'nombre' => 'LAS TUNAS', 'provincia' => '31'),
            array('codigo' => '3106', 'nombre' => 'JOBABO', 'provincia' => '31'),
            array('codigo' => '3107', 'nombre' => 'COLOMBIA', 'provincia' => '31'),
            array('codigo' => '3108', 'nombre' => 'AMANCIO', 'provincia' => '31'),
            array('codigo' => '3201', 'nombre' => 'GIBARA', 'provincia' => '32'),
            array('codigo' => '3202', 'nombre' => 'RAFAEL FREYRE', 'provincia' => '32'),
            array('codigo' => '3203', 'nombre' => 'BANES', 'provincia' => '32'),
            array('codigo' => '3204', 'nombre' => 'ANTILLA', 'provincia' => '32'),
            array('codigo' => '3205', 'nombre' => 'BAGUANOS', 'provincia' => '32'),
            array('codigo' => '3206', 'nombre' => 'HOLGUIN', 'provincia' => '32'),
            array('codigo' => '3207', 'nombre' => 'CALIXTO GARCIA', 'provincia' => '32'),
            array('codigo' => '3208', 'nombre' => 'CACOCUM', 'provincia' => '32'),
            array('codigo' => '3209', 'nombre' => 'URBANO NORIS', 'provincia' => '32'),
            array('codigo' => '3210', 'nombre' => 'CUETO', 'provincia' => '32'),
            array('codigo' => '3211', 'nombre' => 'MAYARI', 'provincia' => '32'),
            array('codigo' => '3212', 'nombre' => 'FRANK PAIS', 'provincia' => '32'),
            array('codigo' => '3213', 'nombre' => 'SAGUA DE TANAMO', 'provincia' => '32'),
            array('codigo' => '3214', 'nombre' => 'MOA', 'provincia' => '32'),
            array('codigo' => '3301', 'nombre' => 'RIO CAUTO', 'provincia' => '33'),
            array('codigo' => '3302', 'nombre' => 'CAUTO CRISTO', 'provincia' => '33'),
            array('codigo' => '3303', 'nombre' => 'JIGUANI', 'provincia' => '33'),
            array('codigo' => '3304', 'nombre' => 'BAYAMO', 'provincia' => '33'),
            array('codigo' => '3305', 'nombre' => 'YARA', 'provincia' => '33'),
            array('codigo' => '3306', 'nombre' => 'MANZANILLO', 'provincia' => '33'),
            array('codigo' => '3307', 'nombre' => 'CAMPECHUELA', 'provincia' => '33'),
            array('codigo' => '3308', 'nombre' => 'MEDIA LUNA', 'provincia' => '33'),
            array('codigo' => '3309', 'nombre' => 'NIQUERO', 'provincia' => '33'),
            array('codigo' => '3310', 'nombre' => 'PILON', 'provincia' => '33'),
            array('codigo' => '3311', 'nombre' => 'BARTOLOME MASO', 'provincia' => '33'),
            array('codigo' => '3312', 'nombre' => 'BUEY ARRIBA', 'provincia' => '33'),
            array('codigo' => '3313', 'nombre' => 'GUISA', 'provincia' => '33'),
            array('codigo' => '3401', 'nombre' => 'CONTRAMAESTRE', 'provincia' => '34'),
            array('codigo' => '3402', 'nombre' => 'MELLA', 'provincia' => '34'),
            array('codigo' => '3403', 'nombre' => 'SAN LUIS', 'provincia' => '34'),
            array('codigo' => '3404', 'nombre' => 'SEGUNDO FRENTE', 'provincia' => '34'),
            array('codigo' => '3405', 'nombre' => 'SONGO - LA MAYA', 'provincia' => '34'),
            array('codigo' => '3406', 'nombre' => 'SANTIAGO DE CUBA', 'provincia' => '34'),
            array('codigo' => '3407', 'nombre' => 'PALMA SORIANO', 'provincia' => '34'),
            array('codigo' => '3408', 'nombre' => 'TERCER FRENTE', 'provincia' => '34'),
            array('codigo' => '3409', 'nombre' => 'GUAMA', 'provincia' => '34'),
            array('codigo' => '3501', 'nombre' => 'EL SALVADOR', 'provincia' => '35'),
            array('codigo' => '3502', 'nombre' => 'MANUEL TAMES', 'provincia' => '35'),
            array('codigo' => '3503', 'nombre' => 'YATERAS', 'provincia' => '35'),
            array('codigo' => '3504', 'nombre' => 'BARACOA', 'provincia' => '35'),
            array('codigo' => '3505', 'nombre' => 'MAISI', 'provincia' => '35'),
            array('codigo' => '3506', 'nombre' => 'IMIAS', 'provincia' => '35'),
            array('codigo' => '3507', 'nombre' => 'SAN ANTONIO DEL SUR', 'provincia' => '35'),
            array('codigo' => '3508', 'nombre' => 'CAIMANERA', 'provincia' => '35'),
            array('codigo' => '3509', 'nombre' => 'GUANTANAMO', 'provincia' => '35'),
            array('codigo' => '3510', 'nombre' => 'NICETO PEREZ', 'provincia' => '35'),
            array('codigo' => '4001', 'nombre' => 'ISLA DE LA JUVENTUD', 'provincia' => '4001'),
        );

        foreach ($data as $rec) {
            $municipio = new Municipio();
            $municipio->setCodigo($rec['codigo']);
            $municipio->setNombre($rec['nombre']);


            $recProv = $manager->getRepository('AppBundle:Provincia')->findOneBy(array('codigo' => $rec['provincia']));
            $municipio->setProvincia($recProv);
            $manager->persist($municipio);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }


}