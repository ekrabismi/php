/*

Fader.js

Facilitates fading transition effects

Created by Stephen Morley - http://stephenmorley.org/ - and released under the
terms of the CC0 1.0 Universal legal code:

http://creativecommons.org/publicdomain/zero/1.0/legalcode

*/

function Fader(_1,_2){
if(typeof _1=="string"){
_1=document.getElementById(_1);
}
this.rate=0.05/(_2?_2:0.5);
_1.style.position="relative";
var _3=0;
var _4=0;
this.panels=[];
this.target=0;
var _5=_1.firstChild;
do{
if(_5.nodeType==1){
_3=Math.max(_3,_5.offsetWidth);
_4=Math.max(_4,_5.offsetHeight);
_5.style.position="absolute";
_5.style.top=0;
_5.style.left=0;
this.panels.push({node:_5,opacity:(this.panels.length==0?1:0)});
}
}while(_5=_5.nextSibling);
_1.style.minWidth=_3+"px";
_1.style.minHeight=_4+"px";
this.useOpacity="opacity" in document.documentElement.style;
this.setTarget(0);
var _6=this;
window.setInterval(function(){
_6.setPanelOpacity(_6.target,_6.panels[_6.target].opacity+_6.rate);
},50);
};
Fader.prototype.setTarget=function(_7){
if("timeout" in this){
window.clearTimeout(this.timeout);
}
this.panels[this.target].contribution=this.panels[this.target].opacity;
var _8=1-this.panels[this.target].opacity;
for(var _9=0;_9<this.panels.length;_9++){
if(_9!=this.target){
this.panels[_9].contribution=_8*this.panels[_9].opacity;
_8*=(1-this.panels[_9].opacity);
}
}
this.setPanelOpacity(_7,this.panels[_7].contribution);
this.panels[_7].node.style.zIndex=this.panels.length;
_8=1-this.panels[_7].opacity;
var _a=this.panels.length;
for(var _9=0;_9<this.panels.length;_9++){
if(_9!=_7){
this.setPanelOpacity(_9,this.panels[_9].contribution/_8);
_8-=this.panels[_9].contribution;
_a--;
this.panels[_9].node.style.zIndex=_a;
}
}
this.target=_7;
if("timeout" in this){
if(this.listener){
this.listener();
}
this.setInterval(this.interval,null,this.listener);
}
};
Fader.prototype.setPanelOpacity=function(_b,_c){
if(isNaN(_c)){
_c=0;
}
_c=Math.max(0,Math.min(1,_c));
this.panels[_b].opacity=_c;
if(this.useOpacity){
this.panels[_b].node.style.opacity=_c;
}else{
this.panels[_b].node.style.filter="alpha(opacity="+(100*_c)+")";
}
};
Fader.prototype.setInterval=function(_d,_e,_f){
this.interval=_d;
this.listener=_f;
var _10=this;
this.timeout=window.setTimeout(function(){
_10.setTarget((_10.target+1)%_10.panels.length);
},(_e?_e:_d)*1000);
};
Fader.prototype.clearInterval=function(){
if("timeout" in this){
window.clearTimeout(this.timeout);
delete this.timeout;
}
};

