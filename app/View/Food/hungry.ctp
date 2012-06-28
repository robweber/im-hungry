<?php echo $this->Form->create('Filter',array('url'=>'/food/hungry/'))?>
<p align="right">Filter: <?php echo $this->Form->select('type',$r_types,array('empty'=>true,'onChange'=>'$("#FilterHungryForm").submit()'))?></p>
<?php echo $this->Form->end(); ?>
<div id="recipe">
<?php foreach ($allRecipes as $recipe): ?>

<h2><?php echo $this->Html->link($recipe['Recipe']['name'],'/food/edit_recipe/' . $recipe['Recipe']['id']) ?> <span class="recipeType">[ <?php echo $recipe['RecipeType']['name']?> ]</span></h2>

<?php endforeach;?>
</div>