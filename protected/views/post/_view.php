<div class="post">
	<div class="title">
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
	</div>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>







    <div id="comments">
        <?php if($data->commentCount>=1): ?>

            <?php $this->renderPartial('_comments',array(
                'post'=>$data,
                'comments'=>$data->comments,
            )); ?>
        <?php endif; ?>

    </div><!-- comments -->
    <br />




    

</div>
