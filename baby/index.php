<?php
$x=42;
for($i=9; $i<31; $i++)
{
//    $x=$x+6;
//    echo ".cb-slideshow li:nth-child(".$i.") div{ </br>
//    -webkit-animation-delay: ".$x."s;</br>
//    -moz-animation-delay: ".$x."s;</br>
//    -o-animation-delay: ".$x."s;</br>
//    -ms-animation-delay: ".$x."s;</br>
//    animation-delay: ".$x."s; </br>
//}</br>
//";
    echo " <li><span>Image ".$i."</span><div><h3>ads.".rand(3, 100)."</h3></div></li>";
}
?>