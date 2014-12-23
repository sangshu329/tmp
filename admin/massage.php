<?
include_once("include/init.php");
$keywords=htmlspecialchars(trim($_REQUEST['keyword']), ENT_QUOTES);
$BigID = $_REQUEST['Category'];
$act = $_REQUEST['act'];
if ($act == 'show') {
    $issue = intval($_REQUEST['issue']);
    $id    = intval($_REQUEST['id']);
    $issue = $issue ? 0 : 1;
    $db->query("update " . $db_prefix . "message set issue='$issue' where id='$id'");
}
elseif($act=='del')
{
  $fid=implode(',',$_POST['fid']);
  $db->query("delete from ".$db_prefix."message where id in($fid)");
}
?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
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
<script language="javascript" src="js/function.js"></script>

</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
    <div class="tabsPageHeader">
      <div class="tabsPageHeaderContent">
        <ul class="navTab-tab1">
          <li tabid="list" class="list"><a><span>留言列表</span></a></li>
        </ul>
      </div>
    </div>
    <div class="navTab-panel tabsPageContent layoutBox" >
      <div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）</div>

    <form name="form1" method="post" action="massage.php">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
        <tr>
          <td width="32" class="left EAEAF3"> <img src="images/search.gif" width="26" height="22" border="0" /></td>
          <input type="hidden" name="act" value="search"/>
          <td width="" height="25" class="EAEAF3 left">
            关键词：
            <input name="keyword" type="text" id="keyword"  value="<?=$keywords?>" size="25" maxlength="30" />&nbsp;&nbsp;
            <input type="submit" name="Submit3" class="button" value="搜索" />
          </td>
        </tr>
      </table>
    </form>   
        <form action="?act=del" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
        <table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr class="bgc1">
            <td width="5%" class="td1" height="25"><b>编号</b></td>
            <td width="5%" class="td1" height="25"><b>姓名</b></td>
            <!-- <td width="12%" class="td1"><b>缩略图</b></td> -->
            <td width="8%" class="td1"><b>联系方式</b></td>
            <td width="10%" class="td1"><b>行业</b></td>
            <td width="12%" class="td1"><b>留言日期</b></td>
            <td width="10%" class="td1"><b>审核状态</b></td>
            <td width="30%" class="td1"><b>问题</b></td>
            <td width="15%" class="td2"><b>操 作</b></td>
          </tr>
          <?
      $where=" where 1=1";
      if(!empty($keywords)){
      $where.=" and (name like '%".$keywords."%')";
      }
       $totals = $db->counter($db_prefix."message",$where,'id');
       if($totals>0)
       {
         $page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
        $startpage=($page-1)*$pagesize;
        $pagetotal=ceil($totals/$pagesize);
        $result=$db->query("select * from ".$db_prefix."message ".$where." order by id desc limit ".$startpage.','.$pagesize);
        if($db->num_rows($result)){
          while($rs = $db->fetch_array($result)){
      ?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td height="25" class="td1"><input type="checkbox" name="fid[]" value="<?=$rs['id'];?>" class="checkbox" /> </td>
            <td height="23" class="td1" style="padding-left:12px;text-align:left;">
              <a href="messageEdit.php?Result=modify&id=<?=$rs['id'];?>" class="showimg_a" style="text-decoration:none;" title="查看留言" >
              <?=$rs['name'];?></a>
            </td>
            <td class="td1"><?= $rs['phone']; ?></td>
            <td class="td1"><?= sub_str2($rs['mindustry'],10); ?></td>
            <td class="td1"><?= date("Y-m-d H:i:s", $rs['addtime']); ?></td>
            <td class="td1"><a href="?act=show&issue=<?= $rs['issue']; ?>&id=<?= $rs['id']; ?>&page=<?=$page?>"><?= editimg($rs['issue']); ?></a></td>
            <td class="td1"><?= sub_str2($rs['content'],10);?></td>
            <td class="td2">
              <a href="tidbitsEdit.php?Result=modify&id=<?=$rs['id'];?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;
              <a href="javascript:deldata('message',<?=$rs['id'];?>,<?=$page?>)"title="删除"><img src="images/icon_drop.gif" border=0></a></td>
            </tr>
          <?PHP
            $i++;
        }
      ?>
      </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="left2">
            &nbsp;&nbsp;<input type="checkbox" name="selectAll"  id="productall" value="all" onClick="javascript:checkAll(myform);" class="checkbox" /> 全选 <input type="submit" value=" 删除 " name="submit" class="button"></td>
            <td class="fengye"><div class="admin_pages">
              <?PHP
              page_list($page,$pagetotal,$pagesize,'massage.php?keyword='.$keywords.'&page=',$totals);
              ?>
            </div></td>
          </tr>
        </table>
        <?  }
    }else{ ?>
        <table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="45" align="center" class="DADAE9">暂无产品。</td>
          </tr>
        </table>
        <? }?>
       </form>
    </div>
  </div>
</div>
</body>
</html>