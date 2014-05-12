skin: TOWER

1) UCP recommended size: width:260 height:480
/ACP -> LOOK & FEEL -> UCP SETTINGS /

2) ACP -> LOOK & FEEL -> BAR STYLE

color:#000; 
background-color:#E5E5E5; 
margin:0px; 
padding:0px; 
width:auto; 
height:auto; 
position:fixed; 
float:left; 
top:auto; 
bottom:2px; 
left:auto; 
right:2px; 
border:1px solid #B5B5B5; 
z-index:1;

3) ACP -> LOOK & FEEL -> BAR ELEMENTS

FIRST TEXTAREA:
---
<div style="border:1px solid #fff">
{ONLINE_LINK}<input style="text-transform:uppercase;font-family:tahoma;font-size:10px;color:#000;background-color:transparent;margin:2px;font-weight:bold;border:1px solid #bbb" type="button" value="{ONLINE_LANG}: {ONLINE_NUM}" />{CLOSE_LINK}
{SETTINGS_LINK}<input style="text-transform:uppercase;font-family:tahoma;font-size:10px;color:#000;background-color:transparent;margin:2px;font-weight:bold;border:1px solid #bbb" type="button" value="{SETTINGS_LANG}" />{CLOSE_LINK}
{HELP_LINK}<input style="text-transform:uppercase;font-family:tahoma;font-size:10px;color:#000;background-color:transparent;margin:2px;font-weight:bold;border:1px solid #bbb" type="button" value="{HELP_LANG}" />{CLOSE_LINK}
</div>
---

SECOND TEXTAREA:

---
<div style="border:1px solid #fff">
{CHATS_LINK}<input style="text-transform:uppercase;font-family:tahoma;font-size:10px;color:#fff;background-color:#a00;margin:2px;font-weight:bold;border:1px solid #bbb" type="button" value="{CHATS_LANG}: {CHATS_NUM}" />{CLOSE_LINK}
</div>
---