<?
include_once("include/init.php");
$act=$_GET['Result'];
$id=$_GET['id'];
if($act=='modify'){
  $rs=$db->get_one("select * from ".$db_prefix."message where id='$id'");
}elseif ($act=="delete") {
  $db->query("delete from ".$db_prefix."message where id='$id'");
  showmessage("删除成功!","massage.php?page=".$page);
}
?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<!-- 技术支持：http://www.eidea.net.cn -->
<title></title>
<link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" />
<link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="dwz/js/dwz.min.js" type="text/javascript"></script>
<script type="text/javascript">
//重载验证码
function fleshVerify(){
  $('#verifyImg').attr("src", '__APP__/Public/verify/'+new Date().getTime());
}
$(function(){
  DWZ.init("dwz/dwz.frag.xml", {
    //loginUrl:"__APP__/webAdmin/Index/login",  //跳到登录页面
    statusCode:{ok:1,error:0},
    pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, 
    debug:true,
    callback:function(){
      initEnv();
      $("#themeList").theme({themeBase:"dwz/themes"});
    }
  });
})
</script>
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="javascript" src="../js/DatePicker/WdatePicker.js"></script>
<script type="text/javascript" charset="utf-8" src="../include/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script language="javascript">
function chkForm(){
  with(document.form1){
  if(ad_name.value==""){
    alert("请输入标题.");
    ad_name.focus();
    return false;
    }
  
   }
}
var editor;
KindEditor.ready(function(K){
  editor = K.create('#content',{allowFileManager : true,filterMode:false});
});
</script>
</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
    <div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
             <li tabid="list" class="list"><a><span>查看留言</span></a></li>
          </ul>
        </div>
    </div>  
    <div class="navTab-panel tabsPageContent layoutBox" >
      <form action="?act=delete&id=<?=$id?>" method="post" name="form" enctype="multipart/form-data" onSubmit="return chkForm();">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td class="EAEAF3 right td1"><span class="red">* </span>姓名：</td>
              <td class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['name'];?>" disabled="disabled">
            </td>
          </tr>
          <tr>
            <td width="12%" class="EAEAF3 right td1">联系方式：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['phone'];?>" disabled="disabled"></td>
          </tr>
          <tr>
            <td width="12%" class="EAEAF3 right td1">行业：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['mindustry'];?>" disabled="disabled"></td>
          </tr>
          <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>问题：</td>
            <td class="EAEAF3 left td2" style="padding:5px">
        <textarea name="content" style="width:100%; height:300px;" disabled="disabled"><?PHP echo $rs['content']?></textarea>
           </td>
          </tr>
      
          <tr>
            <td width="120" class="EAEAF3 right td1">留言时间：</td>
            <td class="EAEAF3 left td2"><input name="adv_url" type="text" style="width:150px" value="<?=date("Y-m-d H:i:s", $rs['addtime']);?>" disabled="disabled">
            </td>
          </tr>
          <tr>
            <td class="EAEAF3 right td1">状态：</td>
            <td class="EAEAF3 left td2">&nbsp;&nbsp;<input name="isnew" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked'; ?> class="checkbox"/>&nbsp;审核状态&nbsp;&nbsp;
          </tr> 
          <tr>
            <td class="EAEAF3 td1">&nbsp;</td>
            <td class="EAEAF3 left td2"  height="30"><!-- <input name="Submit" type="submit" class="button" value=" 删除 "> -->&nbsp;&nbsp;&nbsp;<input name="back" type="button" class="button"  value="返回" onClick="javascript:history.back();"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
var MediaList = new Array('0', '1', '2', '3');
function showMedia(AdMediaType)
{
 for (I = 0; I < MediaList.length; I ++)
{
 if (MediaList[I] == AdMediaType)
 document.getElementById(AdMediaType).style.display = "";
 else
 document.getElementById(MediaList[I]).style.display = "none";
 }
}
</script>
</html>