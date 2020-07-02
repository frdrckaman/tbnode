<?php require_once('php/core/init.php');
$user = new User();
$override = new OverideData();
if($_GET['content'] == 'site'){
    if($_GET['site']){
        $sites=$override->getNews('site','c_id',$_GET['site'],'status',1);?>
        <option value="">Select Site</option>
        <?php foreach($sites as $site){?>
            <option value="<?=$site['id']?>"><?=$site['name']?></option>
        <?php }
    }
}elseif ($_GET['content'] == 'pages') {
    if($_GET['page']){
        $pages=$override->getNews('crf_type','status',1,'id',$_GET['page']);}?>
    <option value="">Select Page</option>
    <?php $x=1;while($x<=$pages[0]['pages']){?>
        <option value="<?=$x?>"><?=$x?></option>
        <?php $x++;}?>
<?php }elseif ($_GET['content'] == 'query'){?>
    <div class="head bg-dot30">
        <h2>Duis eu libero pellentesque</h2>
        <div class="pull-right"><span class="icon-paper-clip"></span> Today 09:20 PM</div>
    </div>
<?php }?>