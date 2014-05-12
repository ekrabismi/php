skin: DEFAULT

1) UCP recommended size: width:550 height:360
/ACP -> LOOK & FEEL -> UCP SETTINGS /

2) ACP -> LOOK & FEEL -> BAR STYLE

font-family:verdana,sans-serif; 
font-size:9px; 
color:#000; 
background-color:#E1EBF2; 
font-weight:bold; 
text-transform:uppercase; 
margin:0px; 
padding:1px; 
width:auto; 
height:auto; 
position:fixed; 
float:left; 
top:auto; 
bottom:8px; 
left:auto; 
right:8px; 
border:1px solid #098DCE; 
border-top-width:2px; 
z-index:1;

3) ACP -> LOOK & FEEL -> BAR ELEMENTS

FIRST TEXTAREA:
---
<div style="background-color:#03557E;color:#fff;padding:5px">Instant Messenger</div>
<div style="padding:5px">{WELCOME} {USER}&nbsp;&nbsp;
{ONLINE_LINK}<input style="color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff" type="button" value="{ONLINE_LANG}: {ONLINE_NUM}" />{CLOSE_LINK}
{SETTINGS_LINK}<input style="color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff" type="button" value="{SETTINGS_LANG}" />{CLOSE_LINK}</div>
---

SECOND TEXTAREA:

---
<div style="background-color:#a00;color:#fff;padding:5px">Instant Messenger</div>
<div style="padding:5px">{WELCOME} {USER}  
{CHATS_LINK}<input style="color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff" type="button" value="{CHATS_LANG}: {CHATS_NUM}" />{CLOSE_LINK}</div>
---