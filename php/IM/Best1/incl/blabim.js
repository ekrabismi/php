chat_post=''; chat_count=0; chat_lid=-1; chat_onl=0; d_opa=0; d_obj=false; lockscr=0; msie=0;

if(typeof window.external=='object' && typeof document.all=='object'){
msie=1; iev=navigator.userAgent;iev=iev.split('MSIE');iev=parseInt(iev[1]);if(iev<7){
document.write('<link rel="stylesheet" type="text/css" href="'+skin_dir+'/msie.css" />');}}


function opa_go(a){
d_obj.style.filter='alpha(opacity='+d_opa+')';
j=d_opa/100;d_obj.style.opacity=j;
if(a>0){d_opa+=5;
if(d_opa>100){clearInterval(d_int);d_opa=100}}
else{d_opa-=5;
if(d_opa<1){clearInterval(d_int);d_obj.style.display='none';d_opa=0}
}}


function opa_st(a,b){
if((d_opa==100 || d_opa==0) && veffects==1){
d_obj=a; if(b>0){
a.style.opacity=0;
a.style.filter='alpha(opacity=0)';
a.style.display='block'; 
d_opa=0;d_int=setInterval('opa_go(1)',10);}
else{d_opa=100;d_int=setInterval('opa_go(0)',10);}
}else{
if(b>0){a.style.display='block';}else{a.style.display='none';}
}}


function set_ie6size(){
z=document.body.clientHeight;
if(msie>0 && iev<7){
h=z-msie_factor;document.getElementById('mda').style.height=h+'px'}}


function http_obj(){
if(msie>0){
r=new ActiveXObject("Microsoft.XMLHTTP")}
else{r=new XMLHttpRequest()}return r}


function onlist_recev(){
htto=http_obj();s='ajx_sett='+ajx_sett;
if(chat_post.length>0){
amp=/&/g;chat_post=chat_post.replace(amp,'%26');
pl=/\+/g;chat_post=chat_post.replace(pl,'%2B');
s=s+'&p='+chat_post;chat_post='';}
htto.open('post','ucp_aj.php');
htto.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
htto.onreadystatechange=onlist_print;htto.send(s);}


function onlist_print(){
if(htto.readyState==4){
document.getElementById('mda').style.backgroundImage='none';
response=htto.responseText.toString();
response=response.split('|:|');
if(response.length>0){
response[1]=parseInt(response[1]);
if(document.getElementById('chats')){
rch=parseInt(document.getElementById('chats').innerHTML);
document.getElementById('chats').innerHTML=response[1];
if(response[1]>rch){document.getElementById('chats').style.color=ch_color;
document.getElementById('fpls').innerHTML=flsh_cht;}}
if(tbl_print==1 &&  tbl_add==0){document.getElementById('onltable').innerHTML=response[0];}
}}}


function chat_recev(){
chat_count+=1;
htto=http_obj();s='u='+u+'&l='+chat_lid+'&c='+chat_count;
if(chat_post.length>0){
amp=/&/g;chat_post=chat_post.replace(amp,'%26');
pl=/\+/g;chat_post=chat_post.replace(pl,'%2B');
s=s+'&p='+chat_post;chat_post='';}
htto.open('post','chat_aj.php');
htto.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
htto.onreadystatechange=chat_print;htto.send(s);}


function chat_print(){
if(htto.readyState==4){
if(chat_count>0){document.getElementById('mda').style.backgroundImage='none';}
response=htto.responseText.toString();
response=response.split('|:|');
response[1]=parseInt(response[1]);
response[2]=parseInt(response[2]);
if(response.length>3){
if(response[2]==chat_count){
if(response[1]>0){chat_lid=response[1];}
if(response[3].length>5){
document.getElementById('mda').innerHTML+=response[3];
if(lockscr==0){lockscr=1;
document.getElementById('mda').scrollTop=9999999;
document.getElementById('mda').scrollTop=9999999;setTimeout('lockscr=0',200);}
}}
cs=chat_status(response[0],response[3].length);
if(cs && response[2]==chat_count){document.getElementById('rec_onl').innerHTML+=flsh_cht;}
}}}


function force_cr(){
if(chat_post.length>0){
document.getElementById('ln').disabled=true;
clearInterval(brc);chat_recev();
brc=setInterval('chat_recev()',chat_updt*1000);
setTimeout('txt_esc()',chat_intv);}}


function txt_esc(){
a=document.getElementById('ln');
a.disabled=false; a.value=' '; a.blur(); a.value=''; a.focus();}


function chat_status(a,b){
tmp=curr_status; dta=''; if(a!='00'){
if(a!=lang_user){lang_user=a;chat_started=1}
document.title=lang_user+' '+' ('+lang_chatsess+')';
document.getElementById('rec_onl').innerHTML='<img src="'+img_onl+'" alt="" />&nbsp;'+lang_chatsess+': <b><a href="info.php?why=link" onclick="return false">'+lang_user+'</a></b>';
curr_status=1} else{
if(chat_started<1){chatnor=lang_chatnor1;chatreq='';}
else{chatnor=lang_chatnor2;chatreq=' (<a href="info.php?why=link" onclick="window.location=\'ch_rd.php?r=1&u=\'+u+\'&z=\'+lang_user;return false">'+lang_chatreq+'</a>)';}
document.title=lang_user+' '+chatnor;
document.getElementById('rec_onl').innerHTML='<img src="'+img_off+'" alt="" />&nbsp;'+lang_user+' '+chatnor+chatreq;
curr_status=0}
if(b>5){dta='(abc) ';}if(tmp!=curr_status){dta='(***) ';}
document.title=dta+document.title; 
if(dta!=''){return true}else{return false}}


function set_status(q){
r=window.location.toString();
window.location='status.php?q='+q+'&r='+r;}


function show_usr(u){
m=document.getElementById('s_usr');
m.innerHTML='';opa_st(m,1);
if(msie>0){m.style.position='absolute'}
httu=http_obj();s='q='+u;
httu.open('post','user_aj.php');
httu.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
httu.onreadystatechange=disp_usr;httu.send(s);}


function disp_usr(){
if(httu.readyState==4){
response=httu.responseText.toString();
document.getElementById('s_usr').innerHTML=response;}}


function process_chat(x,r,z){
if(r<4){
if(navigator.userAgent.indexOf('Gecko/')!=-1){loc=',location=1';}else{loc='';}
ss=window.open('ch_rd.php?u='+x+'&r='+r+'&z='+z,'blabimchat'+x,'width=550,height=380,resizable=1'+loc);
ss.focus();setTimeout('ucp_close(0)',200);} else{window.location='ch_rd.php?u='+x+'&r='+r}}


function ucp_close(x){
if(close_ucp>0 || x==1){
if(parent.document.getElementById('blabimbar')){
parent.document.getElementById('blabimbar').style.width='auto';
parent.document.getElementById('blabimbar').style.height='auto';
parent.oncnt_recev(); parent.oncnt_intv();}
else{self.close();}
}}


function set_snd(x){
flsh='<object data="'+x+'" type="application/x-shockwave-flash" width="1" height="1" style="position:absolute;left:0px;top:0px;visibility:hidden"><param name="movie" value="'+x+'" /><param name="menu" value="false" /><param name="quality" value="high" /></object>';
return flsh;}


function remv_astr(){
str=document.title;
str=str.replace('(***) ','')
str=str.replace('(abc) ','')
document.title=str;}


function smilie_box(){
for(i=0;i<smiles.length;i++){
document.writeln(' <a href="info.php?why=link" onclick="add_smilie(\''+smiles[i]+'\');return false"><img class="box_simg" src="'+skin_dir+'/smilies/'+sfiles[i]+'" alt="'+smiles[i]+'" title="'+smiles[i]+'" /></a> ')}}


function add_smilie(x){
a=document.getElementById('ln');
if(a.disabled==false){
a.value=a.value+ ' '+x+' ';
a.focus();}}


function count_txt(a,b){
c=a.value.length; if(c>b){a.value=a.value.substr(0,b)}}
