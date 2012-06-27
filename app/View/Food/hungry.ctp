<?php echo $this->Form->create('Filter',array('url'=>'/food/hungry/'))?>
<p align="right">Filter: <?php echo $this->Form->select('type',$r_types,array('empty'=>true,'onChange'=>'$("#FilterHungryForm").submit()'))?></p>
<?php echo $this->Form->end(); ?>
<div id="recipe">
<?php foreach ($allRecipes as $recipe): ?>

<h1><?php echo $recipe['Recipe']['name']?> <span class="recipeType">[ <?php echo $recipe['RecipeType']['name']?> ]</span></h1>

<?php endforeach;?>
</div>