<?php

use yii\widgets\ListView;
?>
<div class="gallery-default-index row">
    <div class="col-lg-6 col-md-6">
        <a href="#" class="uploadFile"><span class="fix">Uploads</span></a>
    </div>
</div>

<?= $this->render('_list', ['dataProvider' => $dataProvider]); ?>

<a href="javascript:void(0)" class="page" data-bind="2">Xem them</a>
<?= $this->registerJsFile(Yii::$app->urlManager->createAbsoluteUrl($this->theme->baseUrl . '/webroot/js/jquery.uploadfile.min.js'), ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?=
$this->registerJs('$(document).ready(function ()
{
    $(".uploadFile").uploadFile({
        url: "' . Yii::$app->urlManager->createAbsoluteUrl(["gallery/upload"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: true,
        maxSize: 100000,
        onBeforeSend: function () {
            $(".loading").html("Đang tải...");
        },
        onSuccess: function (files, data, xhr)
        {
            $.each(data, function (index, value) {
               $("#myModal .modal-body").load("/gallery");      
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".resultFile").html("Không đúng định dạng hoặc size không quá 2 MB");
        }
    });

})');
?>
<?=
$this->registerJs('$(document).on("click", ".page", function (event){
    var data = $(this).attr("data-bind");
     $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["gallery/?page=2"]) . '",
   type:"GET",            
   success:function(data){     
         if(data){
            $(".lists").append(data);
         }
       } 
      });
})')?>