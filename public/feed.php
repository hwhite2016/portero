<?php

$fechaInicio = strtotime($_POST['start']);
$fechaFin=strtotime($_POST['end']);
//$fechaFin=strtotime($fechaInicio."+ 2 days");

$zonaHorario = $_POST['param1'];
//return response()->json(['eventos' => $zonaHorario], 200);
// foreach ($zonaHorario as $zona){
//     $p = '0';
// }

echo '[
    {
      "title": "Evento 1",
      "start": "2021-08-18T10:00:00",
      "end": "2021-08-18T11:00:00"
    }
  ]';

//echo '[{ "title": "Event 1", "start": "2021-06-23T10:00:00", "end": "2021-06-23T11:30:00" }]';
//echo '[{ "title": "Event 1", "start": "'.date('Y-m-d H:i:s', strtotime('2021-08-18 15:00:00')).'", "end": "2021-08-18 16:00:00" }]';
//echo '[{ "title": "Event 1", "start": "1629298800000", "end": "1629302400000" } ]';

// echo '[{ "title": "Event 1", "start": "1629298800", "end": "1629302400" }
//             ,{ "title": "Event 1", "start": "1624424400", "end": "1624424400" }
//             ,{ "title": "Event 1", "start": "1624510800", "end": "1624510800" }
//             ,{ "title": "Event 1", "start": "1624597200", "end": "1624597200" }
//             ,{ "title": "Event 1", "start": "1624683600", "end": "1624683600" }
//             ,{ "title": "Event 1", "start": "1624770000", "end": "1624770000" }
//             ,{ "title": "Event 1", "start": "1624856400", "end": "1624856400" }
//       ]';


  $h = '[{ "title": "Event 1", "start": "2021-08-22T10:00:00", "end": "2021-08-22T11:00:00" }';
  for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
        $fi = date('Y-m-d')."T10:00:00";
        $fe = date('Y-m-dTH:i:s', $i);
        $ff= date('Y-m-dTH:i:s', strtotime($fe."+ 1 days"));
        //$h .= '{ "title": "Event 1", "start": '.$fi.', "end": '.$ff.' },';

        $h .= ',{ "title": "Event 1", "start": "2021-08-22T12:00:00", "end": "2021-08-23T13:00:00" }';
  }
  $h .= ']';

  //echo $h;



?>
