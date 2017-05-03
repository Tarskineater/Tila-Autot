
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
     background-color:#f7edd8;
 }    
#left {
    width:624px;
    height:412px;
    margin-left:170px
}
#leftbox {
    width:300px;
    height:400px;
    padding:5px;
    border:1px solid #720b0c;
    float:left;
    margin:0;
 }
#leftbox li {
    margin:10px 0;
 }
#leftbox li a {
    color:#000;
 }
#rightbox {
    width:300px;
    height:400px;
    padding:5px;
    border:1px solid #720b0c;
    float:left;
    background-image:url(../images/cars/Car_00001.jpg); 
 }
</style>

<script type="text/javascript">

   var obj;
   var preloads=[];

function preload(){

for(c=0;c<arguments.length;c++) {
   preloads[preloads.length]=new Image();
   preloads[preloads.length-1].src=arguments[c];
  }
 }
preload('../images/cars/Car_00002.jpg','../images/cars/Car_00003.jpg','../images/cars/Car_00004.jpg');

window.onload=function() {
   obj=document.getElementById('rightbox');
   lst=document.getElementById('leftbox').getElementsByTagName('li');
for(c=0;c<lst.length;c++) {
   lst[c].id=c;
lst[c].onmouseover=function() {
   swapColor(this,this.id);
   }
  }
 }
function swapColor(el,num) {
   obj.style.backgroundImage='url('+preloads[num].src+')';
el.onmouseout=function() {
   obj.style.backgroundImage='url(../images/cars/Car_00001.jpg)';
  }
 }

</script>

</head>
<body>
  
<div id="left">
 
<div id="leftbox">
<ol>
 <li><a href="http://www.yahoo.com/">ABC</a></li>
 <li><a href="http://www.yahoo.com/">123</a></li>
 <li><a href="http://www.yahoo.com/">XYZ</a></li>
</ol>
</div>

<div id="rightbox">
<p>right</p>
</div>

</div>

</body>
</html>