if(document.getElementById('blabimbar')){

function oncnt_recev(){
if(typeof window.external=='object' && typeof document.all=='object'){
htto=new ActiveXObject('Microsoft.XMLHTTP')}else{htto=new XMLHttpRequest()}
htto.open('post',bim_path+'bar_aj.php');
htto.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
htto.onreadystatechange=oncnt_print;htto.send('a=1');}


function oncnt_print(){
if(htto.readyState==4){
response=htto.responseText.toString();
response=response.split('|:|');ps='';
if(typeof response[1]=='string' && response[1]!='0'){ps=flsh_snd;}
document.getElementById('blabimbar').innerHTML=response[0]+ps;
}}


function rsz(s){
if(ww<ucpwidth){ww+=8;document.getElementById('blabimbar').style.width=ww+'px';}
if(hh<ucpheight){hh+=5;document.getElementById('blabimbar').style.height=hh+'px';}
if(ww>=ucpwidth && hh>=ucpheight){
document.getElementById('blabimbar').innerHTML='<iframe src="'+bim_path+ss+'" border="0" frameborder="0" style="width:100%;height:100%;border-width:0px"></iframe>';
clearInterval(rszd);}}


function set_snd(x){
flcs=new Image();flcs.src=x;
flsh='<object data="'+flcs.src+'" type="application/x-shockwave-flash" width="1" height="1" style="position:absolute;left:0px;top:0px;visibility:hidden"><param name="movie" value="'+flcs.src+'" /><param name="menu" value="false" /><param name="quality" value="high" /></object>';
return flsh;}


function go_main(s){
if(ucppopup<1){clearInterval(trvl);
aa=document.getElementById('blabimbar');
if(ucpeffect==1){
aa.innerHTML='';ww=180;hh=120;ss=s;rszd=setInterval('rsz()',1);}
else{aa.style.width=ucpwidth+'px'; aa.style.height=ucpheight+'px';
aa.innerHTML='<iframe src="'+bim_path+s+'" border="0" frameborder="0" style="width:100%;height:100%;border-width:0px"></iframe>';
}}
else{popupsize='width='+ucpwidth+',height='+ucpheight+',resizable=1,status=1'
bucp=window.open(bim_path+s,'bimucp',popupsize);bucp.focus();}return false}


function oncnt_intv(){trvl=setInterval('oncnt_recev()',ajx_updt*1000);}

flsh_snd=set_snd(opt_fsnd);
oncnt_recev(); oncnt_intv();}
