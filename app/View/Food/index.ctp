<p align="right"><?php echo $this->Html->image('add.png',array('url'=>'/food/edit_recipe'))?></p>

<?php foreach($recipes as $recipe): ?>
<p><?php echo $this->Html->link($recipe['Recipe']['name'],'/food/edit_recipe/'. $recipe['Recipe']['id'])?></p>
<?php endforeach;?>