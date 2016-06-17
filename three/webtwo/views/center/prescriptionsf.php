<div class="shenfang">
<!-- 头部 -->
    <div class="header">
        审方<span><img src="img/订单详细-2_03.gif"  id="btnclose" type="button" value="X" class="lr_over"></span>
    </div>
    <!-- 表格 -->
    <div class="table">
        <p >药方编号<span id="prescription_id_sf"><?php echo $prescription_list['prescription_id']?></span>医馆<span><?php echo $prescription_list['hospital_name']?></span>医师<span><?php echo $prescription_list['doctor_name']?></span>付数<span><?php echo $prescription_list['piece']?></span>味数<span><?php echo $prescription_list['kinds_per_piece']?></span>原药/代煎<span><?php if($prescription_list['production_type']==1){ echo "原药";}else{echo "代煎";}?></span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
    </div>
    <div class="lrcont">
        <div class="lrleft">
            <div class="lrtop">
                <div class="lrlefttop"><img src="<?php echo $prescription_photo_list['0']['photo_img']?>" width="650" height="350"></div>
                <div class="lrleftbot">
                    <?php foreach($prescription_photo_list as $k=>$v){?>
                        <div class="lrleftbotleft" value="<?php echo $v['photo_id']?>"><img src="<?php echo $v['photo_img']?>" width="170" height="110"></div>
                    <?php }?>
                </div>
            </div>
            <input type="hidden" value="<?php echo $prescription_list['doctor_id']?>" id="doctor_id"/>
            <div class="lrleftbottom">
                <input type="hidden" name="prescription_id" id="prescriptions_id" value="<?php echo $prescription_list['prescription_id']?>"/>
                <span> 姓名<input type="text" name="patient_name" value="<?php echo $patient_list['patient_name']?>" id="patient_name"></span>

                <span> 性别
                    <?php  if($patient_list['gender']==1){?>
                    <input checked="checked" type="radio" class="gender" name="gender" value="1" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">男
                    <input type="radio" class="gender "name="gender" value="2" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">女
                    <?php }else{?>
                    <input type="radio" class="gender" name="gender" value="1" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">男
                    <input type="radio" checked="checked"  class="gender "name="gender" value="2" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">女
                    <?php }?>
                </span><br>
                <span>年龄<input type="text" name="age" id="age" value="<?php echo $patient_list['age']?>"></span><span>付数<input type="text" name="piece" id="piece" value="<?php echo $prescription_list['piece']?>"></span><br>
                <span>味数<input type="text" name="kinds_per_pieces" id="kinds_per_pieces" value="<?php echo $prescription_list['kinds_per_piece']?>"></span>
                <span>频次<select name="use_frequence" id="use_frequence">
                        <?php
                        foreach($frequence_list as $k=>$v) {
                            if ($v['use_frequence_type'] == $prescription_list['use_frequence']) {
                        ?>
                                <option value="<?php echo $v['use_frequence_type'] ?>" selected><?php echo $v['use_frequence_type_name'] ?></option>
                            <?php } else {?>
                                <option value="<?php echo $v['use_frequence_type'] ?>"><?php echo $v['use_frequence_type_name'] ?></option>
                            <?
                            }
                        }?>
                    </select></span>
                <br>
					<span>
							用法<select name="usage_id" id="yongfa">
                            <?php
                            foreach($usage_list as $k=>$v) {
                                if ($v['usage_id'] == $prescription_list['usage_id']) {
                                    ?>
                                    <option value="<?php echo $v['usage_id']?>" selected><?php echo $v['usage_name']?></option>
                                <?php } else {
                                    ?>
                                    <option value="<?php echo $v['usage_id']?>"><?php echo $v['usage_name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
									</span><br>
									<span>
			                备注<textarea   disabled="disabled"  style="width:338px;height:83px;border-radius:5px;border: 1px solid #e3e4e4;margin-left:15px;"><?php echo $prescription_list['notes']?></textarea>
					</span>
            </div>
            <?php if($prescription_list['excessive_prescription']==0){?>
            <input type="button" id="physician_confirmations" value="通知医师再度确认禁忌超量" style="width:244px;text-align:center;height:40px;background:#f4ad59;font-size:18px;color:white;border:none;border-radius: 5px; margin-left:249px;margin-bottom:30px;margin-top:30px;">
            <div class="zdjcfoot" style="display:inline;">
                <div class="zdjcfootl" style=" margin-left:247px;">
                    <input type="checkbox" style="">药方中上述警示内容已与医师确认
                </div>
            </div>
            <?php }?>
        </div>
        <div class="lrright">
            <table id="tabs">
                <?php foreach($prescription_detail as $k=>$v){?>
                    <tr class="tr-trs">
                        <td>
                            <?php if($v['is_violation']=='0'){?>
                                <span><img src="img/自动检查(2)_05.gif" alt=""></span>
                            <?}if($v['is_excess']=='0'){?>
                                <span><img src="img/自动检查(2)_07.gif" alt=""></span>
                            <?php }?>
                        </td>
                        <td class="td-1">
                            <div class="container">
                                <input type="text" placeholder="药名" name="country1" id="autocomplete-ajax1" class="sel" style="position: absolute1; z-index: 2; background: transparent;" value="<?php echo $v['medicine_name']?>" alt="<?php echo $v['medicine_id']?>"/>
                            </div>
                        </td>
                        <td class="td-2"><input type="text" placeholder="重量"  class="weight" style="width:80px;color:#e3e4e4;" value="<?php echo $v['weight']?>">克</td>
                        <td>
                            <select name="produce_frequence" class="produce_frequence">
                                <?php
                                foreach($produce_frequence as $kk=>$vv){
                                    if($vv['produce_frequence_type']==$v['produce_frequence']){
                                        ?>
                                        <option value="<?php echo $vv['produce_frequence_type']?>" selected><?php echo $vv['produce_frequence_name']?></option>
                                    <?php
                                    }else{
                                        ?>
                                        <option value="<?php echo $vv['produce_frequence_type']?>"><?php echo $vv['produce_frequence_name']?></option>
                                    <?php
                                    }
                                }
                                ?>
                        </td>
                        <td class="del"><img src="img/订单详细-2_03.gif" alt=""></td>
                    </tr>
                <?php }?>
            </table>
            <button class="jia" id="jia" style="width:80px;height:40px;line-height:40px;font-size:16px; background:#f4ad59;text-align:center;margin-left:180px;border:none; color:white; border-radius:5px; margin-bottom:15px;">添加<tton>
        </div>
    </div>
    <div class="lrfoot" style="display:inline;">
        <div class="lrfootl" style=" margin-left:300px;">
            <input id="shenfangover"  type="button" value="完成" onclick="psdshowdiv();" style="display:inline;width:100px;height:40px;line-height: 40px;text-align:center;background-color: #f4ad59;color:white;font-size: 14px;outline: none;border:none;border-radius: 4px;left:50%;margin-left:170px;margin-top:30px;" />
        </div>
    </div>
    <div id="psdbg-sf">
    </div>
    <div id="psdshow-sf">
        <div class="psd" id="">
            <p>个人密码<input type="text" name="password_hash" id="password_hash_sf"></p>
            <input id="psdover-sf" type="button" value="完成" onclick="psdshowdiv();"/>
        </div>
    </div>
</div>
<script type="text/javascript" src="jQuery-Autocomplete-master/src/jquery.autocomplete.js"></script>
<script>
    $(document).ready(function() {
        $(function () {
            'use strict';
            var countries = <?php echo $medicines_list;?>;
            var countriesArray = $.map(countries, function (value, key) {
                return {value: value, data: key};
            });
            $('.sel').autocomplete({
                lookup: countriesArray,
                showNoSuggestionNotice: false,
                noSuggestionNotice: '没有可匹配药材',
                lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function (suggestion) {
                    var words = suggestion.value.split(' ');
                    $(this).attr("value", words[1]);
                    //$(this).attr("value", suggestion.value);
                    $(this).attr("alt", suggestion.data);
                },
                onHint: function (hint) {
                    $(this).val(hint);
                },
                onInvalidateSelection: function () {
                    $(this).html('未选择');
                    //$(this).html('You selected: none');
                }
            });
        })
    })
</script>

