<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
    <?php if (isset($this->breadcrumbs)): ?>
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
            'homeLink' => CHtml::link('Dashboard'),
            'htmlOptions' => array('class' => 'breadcrumb')
        ));
        ?><!-- breadcrumbs -->
    <?php endif ?>
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">
  <button type="button" class="close" data-dismiss="alert">×</button>' . $message . "</div>\n";
    }
    ?>
    <?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>