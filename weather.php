<?php

function havadurumu($il,$kacgun = 1){

    $il = mb_strtolower($il);

    $veri = str_replace(array("\n","\t","\r"),null,trim(file_get_contents('http://www.mynet.com/havadurumu/asya/turkiye/'.$il)));
    preg_match_all('#<span class="hvDeg1">(.*?)</span>#',$veri,$enYuksek);
    preg_match_all('#<span class="hvDeg2">(.*?)</span>#',$veri,$enDusuk);
    preg_match_all('#<span class="hvMood">(.*?)</span>#',$veri,$hvMood);
    preg_match_all('#<span class="hvDay">(.*?)</span>#',$veri,$hvGun); 
    preg_match_all('#<img src="http://img3.mynet.com/havadurumu/durumlar/(.*?)" alt="(.*?)" />#',$veri,$icon); 
    
    if($kacgun!=1 AND $kacgun > 1){
        $enY=array();
        $enD=array();
        $hvM=array();
        $hvG=array();
        $icn=array();
        $icnAlt=array();
    
        for($i=0;$i<$kacgun;$i++){
            array_push($enY,$enYuksek[1][$i]);
            array_push($enD,$enDusuk[1][$i]);
            array_push($hvM,$hvMood[1][$i]);
            array_push($hvG,$hvGun[1][$i]);
            array_push($icn,$icon[1][$i]);
            array_push($icnAlt,$icon[2][$i]);
        }
        $data =array(
            "enYuksek" => $enY,
            "enDusuk" => $enD,
            "durum" => $hvM,
            "gun" => $hvG,
            "icon" => $icn,
            "icon_url" => "http://img3.mynet.com/havadurumu/durumlar/",
            "iconAlt" => $icnAlt
        );
        
    }else{
        $data = array(
            "enYuksek" => $enYuksek[1][0],
            "enDusuk" => $enDusuk[1][0],
            "durum" => $hvMood[1][0],
            "gun" => $hvGun[1][0],
            "icon" => $icon[1][0],
            "icon_url" => "http://img3.mynet.com/havadurumu/durumlar/",
            "iconAlt" => $icon[2][0]
        );
    }

    return $data;

}

$havaDurumu = havadurumu("Bursa",3);

echo json_encode($havaDurumu);
