<p align="right"><?php echo $this->Html->image('add.png',array('url'=>'/recipe/edit_recipe'))?></p>
<div id="recipe">
<?php foreach($recipes as $recipe): ?>
<h2><?php echo $this->Html->link($recipe['Recipe']['name'],'/recipe/edit_recipe/'. $recipe['Recipe']['id'])?> <span class="recipeType">[ <?php echo $recipe['RecipeType']['name']?> ]</span></h2>
<?php endforeach;?>
</div>