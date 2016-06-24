<h3>供应商</h3>
<input type="hidden" value="<?php echo $supplier_id['supplier_id']?>" class="supplier_id">
<input type="hidden" value="<?php echo $medicine_id?>" class="upthreemedicine_id">
<?php foreach($supplier as $k=>$v){?>
<p><span><?php echo $v['supplier_name']?></span><input  value="<?php echo $v['supplier_id']?>" type="radio" name="qq" class="upsupplier_id"></p>
<?php }?>
<button id="upthreebaocun">保存</button>