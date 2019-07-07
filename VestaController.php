<?php
/**
 * Created by PhpStorm.
 * User: berni
 * Date: 8/06/19
 * Time: 20:09
 */

//Aquí se introduce el número de iteraciones que se van a realizar y que coincide
//con el número de píxels de la imagen.

//Ancho (eje x)
$a=944;

//Largo (eje y)
$b=963;

//Distancia de Vesta al Sol en km en el momento de observación.
$dv = [
        346664468.058,
        346664384.989,
        346664453.969,
        346664396.148,
        346664434.414,
        346664406.144,
        346664418.037
];

//Flujo Solar a la distancia de 1AU:
$flujo = [
        1.863,
        1.274,
        0.865,
        0.785,
        1.058,
        1.572,
        1.743
];

//Definimos las variables que se van a emplear en el programa:
//Variables que guardan la composición de cada píxel:
$Euc = 0;
$Dio = 0;
$How = 0;

//Variables que guardan el porcentaje de composición.
$Euc_total = 0;
$Dio_total = 0;
$How_total = 0;

//Variables que guardan el resultado de calcular las diferencias de
//reflectividad

//$dif_euc[][] = [$a][2];
$dif_euc = array(array());

//$dif_dio[][] = [$a][2];
$dif_dio = array(array());

//$dif_how[][] = [$a][2];
$dif_dio = array(array());

//Variables que agrupan y operan los valores de reflectividad de un mismo
//pixel
//$datos[][]      = [$a][7];
$datos = array(array());

//$datos_corr[][] = [$a][7];
$datos_corr = array(array());

//$normaliz[][]   = [$a][7];
$normaliz = array(array());

//Define files to be opened
$file2 = fopen("f2_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");
$file3 = fopen("f3_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");
$file4 = fopen("f4_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");
$file5 = fopen("f5_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");
$file6 = fopen("f6_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");
$file7 = fopen("f7_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");
$file8 = fopen("f8_pruebas.txt", "r", "/home/berni/Documentos/Vesta1");

//fichero que da normalizado para cada píxel el valor de las reflectancias en cada filtro
//(ordenados por F8/F2/F7/F3/F6/F4/F5).
$fw = fopen("Órbita1 7columnsNormalizado.txt", "w");

//aquí escribiríamos otro fichero indicando el resultado si es eucrite/diogenite/howardite
$fx = fopen("ComposicionÓrbita1.txt", "w");

//fichero que indica fila a fila el resultado:
$fy = fopen("DiferenciasÓrbita1.txt", "w");

//fichero que da sin normalizar para cada píxel el valor de las reflectancias
//en cada filtro (ordenados por F8/F2/F7/F3/F6/F4/F5).
$fz = fopen("Órbita1-7columns.txt", "w");

//fichero que nos indica las coordenadas de un píxel cuando sale el
//mensaje "Euc":
$fu = fopen("Órbita1-CoordsEuc.txt", "w");

//fichero que nos indica las coordenadas de un píxel cuando sale el
//mensaje "Dio":
$fv = fopen("Órbita1-CoordsDio.txt", "w");


//PRUEBAS:CONTAR EL NÚMERO DE LINEAS DE CADA FICHERO
/*$files = [$file2, $file3, $file4, $file5, $file6, $file7, $file8];
$i = 2;
foreach($files as $file)
{
    $linecount = 0;
    while(!feof($file))
    {
        $line = fgets($file);
        $linecount++;
    }

    fclose($file);

    print_r('número de líneas fichero'.$i.': '.$linecount.'\r');
    $i++;
    echo '<br/>';
}*/
//PRUEBAS:CONTAR EL NÚMERO DE LINEAS DE CADA FICHERO

//PRUEBAS DE LEER FICHEROS
//$myfile = fopen("textoPrueba.txt", "r", "/home/berni/Documentos/Vesta1");
// Output one character until end-of-file
/*while(!feof($myfile))
{
    echo fgetc($myfile);
}
fclose($myfile);

$file = new SplFileObject("textoPrueba.txt", "r", "/home/berni/Documentos/Vesta1");*/

// Loop until we reach the end of the file.
/*while (!$file->eof())
{
    echo $file->fgets();
}*/

// Unset the file to call __destruct(), closing the file handle.
//$file = null;
//PRUEBAS DE LEER FICHEROS

$arrayElements = file_get_contents("/home/berni/Documentos/Vesta1/f1_pruebas.txt");
$split = explode('      ', $arrayElements);

$re = '([0-9.,]+)m';
preg_match_all($re, $arrayElements, $matches, PREG_SET_ORDER, 0);

$arrayElements1 = file_get_contents("/home/berni/Documentos/Vesta1/f2_pruebas.txt");
preg_match_all($re, $arrayElements1, $matches1, PREG_SET_ORDER, 0);

$arrayElements2 = file_get_contents("/home/berni/Documentos/Vesta1/f2_pruebas.txt");
preg_match_all($re, $arrayElements2, $matches2, PREG_SET_ORDER, 0);

$arrayElements3 = file_get_contents("/home/berni/Documentos/Vesta1/f3_pruebas.txt");
preg_match_all($re, $arrayElements3, $matches3, PREG_SET_ORDER, 0);

$arrayElements4 = file_get_contents("/home/berni/Documentos/Vesta1/f4_pruebas.txt");
preg_match_all($re, $arrayElements4, $matches4, PREG_SET_ORDER, 0);

$arrayElements5 = file_get_contents("/home/berni/Documentos/Vesta1/f5_pruebas.txt");
preg_match_all($re, $arrayElements5, $matches5, PREG_SET_ORDER, 0);

$arrayElements6 = file_get_contents("/home/berni/Documentos/Vesta1/f6_pruebas.txt");
preg_match_all($re, $arrayElements6, $matches6, PREG_SET_ORDER, 0);

$arrayElements7 = file_get_contents("/home/berni/Documentos/Vesta1/f7_pruebas.txt");
preg_match_all($re, $arrayElements7, $matches7, PREG_SET_ORDER, 0);

$arrayElements8 = file_get_contents("/home/berni/Documentos/Vesta1/f8_pruebas.txt");
preg_match_all($re, $arrayElements8, $matches8, PREG_SET_ORDER, 0);

$arrayResume = array();
for($i = 0; $i< sizeof($matches1); $i++)
{
    //coordenadas del píxel:
    /*$x_coord = 0.5+$i;
    $y_coord = '';*/

    //sklkflkdfl


        //(F8/F2/F7/F3/F6/F4/F5
    /*$arrayResume[] = [
                        str_replace(',', '.', $matches8[$i][0]),
                        str_replace(',', '.', $matches2[$i][0]),
                        str_replace(',', '.', $matches7[$i][0]),
                        str_replace(',', '.', $matches3[$i][0]),
                        str_replace(',', '.', $matches6[$i][0]),
                        str_replace(',', '.', $matches4[$i][0]),
                        str_replace(',', '.', $matches5[$i][0])
                    ];*/

    $f8 = str_replace(',', '.', $matches8[$i][0]);
    $f2 = str_replace(',', '.', $matches2[$i][0]);
    $f7 = str_replace(',', '.', $matches7[$i][0]);
    $f3 = str_replace(',', '.', $matches3[$i][0]);
    $f6 = str_replace(',', '.', $matches6[$i][0]);
    $f4 = str_replace(',', '.', $matches4[$i][0]);
    $f5 = str_replace(',', '.', $matches5[$i][0]);

    //$arrayResume[] = [$f8, $f2, $f7, $f3, $f6, $f4, $f5];

    //corregimos cada valor: suponemos $dv y $flujo ordenados según orden de filtros
    $f8_fixed = $f8*M_PI*pow($dv[0], 2)*pow($flujo[0], -1);
    $f2_fixed = $f2*M_PI*pow($dv[1], 2)*pow($flujo[1], -1);
    $f7_fixed = $f7*M_PI*pow($dv[2], 2)*pow($flujo[2], -1);
    $f3_fixed = $f3*M_PI*pow($dv[3], 2)*pow($flujo[3], -1);
    $f6_fixed = $f6*M_PI*pow($dv[4], 2)*pow($flujo[4], -1);
    $f4_fixed = $f4*M_PI*pow($dv[5], 2)*pow($flujo[5], -1);
    $f5_fixed = $f5*M_PI*pow($dv[6], 2)*pow($flujo[6], -1);

    //$arrayResume[] = [$f8_fixed, $f2_fixed, $f7_fixed, $f3_fixed, $f6_fixed, $f4_fixed, $f5_fixed];

    //normalizamos con respecto a F2:
    $f8_normalized = $f8_fixed/$f2_fixed;
    $f2_normalized = $f2_fixed/$f2_fixed;
    $f7_normalized = $f7_fixed/$f2_fixed;
    $f3_normalized = $f3_fixed/$f2_fixed;
    $f6_normalized = $f6_fixed/$f2_fixed;
    $f4_normalized = $f4_fixed/$f2_fixed;
    $f5_normalized = $f5_fixed/$f2_fixed;

    //$arrayResume[] = [$f8_normalized, $f2_normalized, $f7_normalized, $f3_normalized, $f6_normalized, $f4_normalized, $f5_normalized];

    //Determinamos el tipo de material:
    //1.-Eucrite:
    $f8_euc_compared = pow($f8_normalized-0.870934895, 2);
    $f2_euc_compared = pow($f2_normalized-1, 2);
    $f7_euc_compared = pow($f7_normalized-1.085860881, 2);
    $f3_euc_compared = pow($f3_normalized-1.178224997, 2);
    $f6_euc_compared = pow($f6_normalized-1.03832738, 2);
    $f4_euc_compared = pow($f4_normalized-0.769017478, 2);
    $f5_euc_compared = pow($f5_normalized-0.793369077, 2);

    $euc_compared_resumed = [$f8_euc_compared, $f2_euc_compared, $f7_euc_compared, $f3_euc_compared, $f6_euc_compared, $f4_euc_compared, $f5_euc_compared ];

    $dif_euc = sqrt(array_sum($euc_compared_resumed));

    //2.-Diogenite:
    $f8_dio_compared = pow($f8_normalized-0.70610281, 2);
    $f2_dio_compared = pow($f2_normalized-1, 2);
    $f7_dio_compared = pow($f7_normalized-1.075217256, 2);
    $f3_dio_compared = pow($f3_normalized-1.035497439, 2);
    $f6_dio_compared = pow($f6_normalized-0.676677086, 2);
    $f4_dio_compared = pow($f4_normalized-0.420781304, 2);
    $f5_dio_compared = pow($f5_normalized-0.47940363, 2);

    $dio_compared_resumed = [$f8_dio_compared, $f2_dio_compared, $f7_dio_compared, $f3_dio_compared, $f6_dio_compared, $f4_dio_compared, $f5_dio_compared ];

    $dif_dio = sqrt(array_sum($dio_compared_resumed));

    //3.-Howardite:
    $f8_how_compared = pow($f8_normalized-0.829196281, 2);
    $f2_how_compared = pow($f2_normalized-1, 2);
    $f7_how_compared = pow($f7_normalized-1.074897103, 2);
    $f3_how_compared = pow($f3_normalized-1.078338401, 2);
    $f6_how_compared = pow($f6_normalized-0.673516674, 2);
    $f4_how_compared = pow($f4_normalized-0.401810592, 2);
    $f5_how_compared = pow($f5_normalized-0.439768495, 2);

    $how_compared_resumed = [$f8_how_compared, $f2_how_compared, $f7_how_compared, $f3_how_compared, $f6_how_compared, $f4_how_compared, $f5_how_compared ];

    $dif_how = sqrt(array_sum($how_compared_resumed));

    $materialComparative = [$dif_euc, $dif_dio, $dif_how];
    $result = array_search(min($materialComparative), $materialComparative);

    if($result === 0){
        $result = 'euc';
    }

    if($result === 1){
        $result = 'dio';
    }

    if($result === 2){
        $result = 'how';
    }

    $arrayResume[] = $result;
    //$arrayResume[] = $materialComparative;

    /*$result = null;
    if($dif_euc < $dif_dio && $dif_euc < $dif_how){
        $result = 'euc';
    }

    if($dif_dio < $dif_euc && $dif_dio < $dif_how){
        $result = 'dio';
    }

    if($dif_how < $dif_euc && $dif_how < $dif_dio){
        $result = 'how';
    }

    $arrayResume[] = $materialComparative;*/
}

print_r($arrayResume);

//CORREGIMOS LOS VALORES CON LAS DISTANCIAS AL SOL:
//$arrayResume = str_replace(',', '.', $arrayResume);
//$arrayResumeFixed = array();

//accedemos a cada pixel y lo convertimos tdo en un solo array
/*foreach ($arrayResume as $value)
{
    foreach ($value as $dato)
    {
        $piNumber = M_PI;
        $elementPosition = array_search($dato, $arrayResume);
        $arrayResumeFixed[] = $dato
            *M_PI
            *pow($dv[$elementPosition], 2)
            *pow($flujo($elementPosition), -1)
        ;
    }
}

print_r($arrayResumeFixed);*/