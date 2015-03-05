<style type="text/css">
    #menu-panel{
        margin: 0 auto;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 20px;
        width: auto;
    }
</style>
<div id="menu-panel" class="panel">
	<div class="panel-heading">菜单</div>
	<div class="panel-body">

	<?php
		global $BEE;
		$menus = array(
			1 => array(
				'name' => '系统',
				'class_name'=>'',
				'func_name' =>'',
				'is_leaf' => 0,
				'child' => array(
					2=>array(
						'name' => '首页',
						'class_name'=>'home',
						'func_name' =>'index',
						'is_leaf' => 1,
					),
					3=>array(
						'name' => '用户',
						'class_name'=>'user',
						'func_name' =>'index',
						'is_leaf' => 1,
					),
				),
			),
			4 => array(
				'name' => 'Trash',
				'class_name'=>'',
				'func_name' =>'',
				'is_leaf' => 1,
				'child' => array(),
			),
			5 => array(
				'name' => 'All',
				'class_name'=>'',
				'func_name' =>'',
				'is_leaf' => 1,
				'child' => array(),
			),
		);
	?>
			
	<nav class="menu" data-toggle="menu" style="width: auto">
		<ul class="nav nav-primary">
		
			<?php foreach ($menus as $m1):?>
				<?php if($m1['child']):?>
					<li class="nav-parent show">
					<a href="">
						<i class="icon-time"></i><?php echo $m1['name']?>
					</a>
					<ul class="nav" style="display: block;">
					<?php foreach ($m1['child'] as $m2):?>
						<li id="<?php echo $m2['class_name'].'-'.$m2['func_name'];?>"
							class="<?php echo $m2['class_name'] == $BEE->ctrl ? 'active' : '';?>">
							<a href="index.php?c=<?php echo $m2['class_name'];?>"><?php echo $m2['name']?></a>
						</li>
					<?php endforeach;?>
					</ul>
					</li>
				<?php else:?>
					<li><a href="index.php?c=<?php echo $m1['class_name'];?>"><?php echo $m1['name']?></a></li>
				<?php endif;?>
			<?php endforeach;?>
		 
			<!-- 
			<li class="nav-parent">
				<a href=""><i class="icon-time"></i>系统<i class="icon-chevron-right nav-parent-fold-icon"></i></a>
                <ul class="nav" style="display: block;">
                  <li class="active"><a href="index.php?c=home">首页</a></li>
                  <li><a href="index.php?c=user">用户</a></li>
                  <li><a href="###">Yestorday</a></li>
                  <li><a href="###">This Week</a></li>
                </ul>
           	</li>
              <li class=""><a href="###"><i class="icon-trash"></i> Trash</a></li>
              <li class=""><a href="###"><i class="icon-list-ul"></i> All</a></li>
              <li class="nav-parent active show">
                <a href="###"><i class="icon-tasks"></i> Status<i class="icon-chevron-right nav-parent-fold-icon icon-rotate-90"></i></a>
                <ul class="nav" style="display: none;">
                  <li><a href="###"><i class="icon-circle-blank"></i> Ready</a></li>
                  <li class=""><a href="###"><i class="icon-play-sign"></i> Ongoing</a></li>
                  <li><a href="###"><i class="icon-ok-sign"></i> Completed</a></li>
                </ul>
              </li>
               -->
              
    	</ul>
	</nav>
          
	</div>
</div>

<script>
//非父节点被点击时触发
$('.menu .nav li:not(".nav-parent") a').click(function (){
	menu_click(this);
});
var lid = '<?php echo $BEE->ctrl.'-'.$BEE->func;?>';
$("#"+lid).load(function(){
	menu_click(this);
});

function menu_click(eve){
	var $this = $(eve);
	$('.menu .nav .active').removeClass('active');
	$this.closest('li').addClass('active');
	var parent = $this.closest('.nav-parent');
	if(parent.length){
		parent.addClass('active');
	}
}

</script>