<?php
$this->breadcrumbs=array(
	'Productconversions',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('productconversion/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Productconversion_productconversionid').val('');
					$('#Productconversion_productid').val('');
					$('#productname').val('');
					$('#Productconversion_fromuom').val('');
					$('#fromuomcode').val('');
					$('#Productconversion_fromvalue').val('');
					$('#Productconversion_touom').val('');
					$('#touomcode').val('');
					$('#Productconversion_tovalue').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function editdata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('productconversion/update'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Productconversion_productconversionid').val(data.productconversionid);
					$('#Productconversion_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Productconversion_fromuom').val(data.fromuom);
					$('#fromuomcode').val(data.fromuomcode);
					$('#Productconversion_fromvalue').val(data.fromvalue);
					$('#Productconversion_touom').val(data.touom);
					$('#touomcode').val(data.touomcode);
					$('#Productconversion_tovalue').val(data.tovalue);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('productconversion/delete'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=productconversion/help',
        'data': {
            'id': value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('divhelp').innerHTML = data.div;
                $('#helpdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=productconversion/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messages');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=productconversion/upload',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (!(ext && /^(csv)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only CSV files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				status.text('');
				//Add uploaded file to list
				if(response==="success"){
					$.fn.yiiGridView.update('datagrid');
				} else{
					status.text(response);
				}
			}
		});		
	});
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
				  'product'=>$product,
				  'fromuom'=>$fromuom,
				  'touom'=>$touom)); ?>
<?php $this->endWidget();?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1>Parameter: Material - Unit Conversions</h1>
<div id="toolbar">
<ul>
<?php
$imgcreate=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgcreate,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata()}",
	'title'=>Yii::t('app','create data')
));
echo CHtml :: closeTag('li');

$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata()}",
	'title'=>Yii::t('app','edit data')
));
echo CHtml :: closeTag('li');

$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
echo CHtml :: closeTag('li');
?>
<li>
<a id="upload" class="hover" style="cursor: pointer; text-decoration: underline; padding-top:15px; " title="upload file">
<img src="images/up.png" alt="">
</a>
</li><?php
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','download data')
));
echo CHtml :: closeTag('li');

$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
echo CHtml :: closeTag('li');

$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml :: openTag('li');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
echo CHtml :: closeTag('li');
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'productconversionid','visible'=>false, 'header'=>'ID','value'=>'$data->productconversionid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'$data->product->productname'),
		array(
            'name'=>'product.productpic',
			'header'=>'Picture',
             'type'=>'image',
             'value'=>'"images/material/" . $data->product->productpic',
        ),
	'fromvalue',
	array('name'=>'fromuom', 'value'=>'$data->fromuom0->uomcode'),
	'tovalue',
	array('name'=>'touom', 'value'=>'$data->touom0->uomcode'),
  ),
));
?>

