
    <!-- 头部 -->
    <div class="header">
        录入<span><img src="img/订单详细-2_03.gif"  id="btnclose" type="button" value="X" class="lr_over"></span>
    </div>
    <!-- 表格 -->
    <div class="table">
        <p >药方编号<span><?php echo $prescription_list['prescription_id']?></span>医馆<span><?php echo $prescription_list['hospital_name']?></span>医师<span><?php echo $prescription_list['doctor_name']?></span>付数<span><?php echo $prescription_list['piece']?></span>味数<span><?php echo $prescription_list['kinds_per_piece']?></span>原药/代煎<span><?php if($prescription_list['production_type']==1){ echo "原药";}else{echo "代煎";}?></span><b id="print"><img src="img/yfjd_03.jpg" alt="" >标签打印</b></p>
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
            <div class="lrleftbottom">
                <input type="hidden" name="prescription_id" id="prescriptions_id" value="<?php echo $prescription_list['prescription_id']?>"/>
                <span>姓名<input type="text" name="patient_name" value="" id="patient_name"></span><span>性别<input type="radio" class="gender" name="gender" value="1" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">男<input type="radio" class="gender "name="gender" value="2" style="margin-left:15px;margin-right:15px;width:18px;height:18px;">女</span><br>
                <span>年龄<input type="text" name="age" id="age"></span><span>付数<input type="text" name="piece" id="piece"></span><br>
                <span>味数<input type="text" name="kinds_per_pieces" id="kinds_per_pieces"></span>
                <span>频次<select name="use_frequence" id="use_frequence">
                        <?php foreach($frequence_list as $k=>$v){?>
                        <option value="<?php echo $v['use_frequence_type']?>"><?php echo $v['use_frequence_type_name']?></option>
                        <?php }?>
                    </select></span>
                <br>
					<span>
							用法<select name="usage_id" id="yongfa">
                                            <?php foreach($usage_list as $k=>$v){?>
                                            <option value="<?php echo $v['usage_id']?>"><?php echo $v['usage_name']?></option>
                                            <?php }?>
                                        </select>
									</span><br>
									<span>
			                备注<textarea   disabled="disabled"  style="width:338px;height:83px;border-radius:5px;border: 1px solid #e3e4e4;margin-left:15px;"><?php echo $prescription_list['notes']?></textarea>
					</span>
            </div>
        </div>
        <div class="lrright">
            <table id="tabs">
                <tr class="tr-trs">
                    <td class="td-1">
                        <div class="container">
                            <input type="text" placeholder="药名" name="country1" id="autocomplete-ajax1" class="sel" style="position: absolute1; z-index: 2; background: transparent;"/>
                        </div>
                    </td>
                    <td class="td-2"><input type="text" placeholder="重量"  class="weight" style="width:80px;color:#e3e4e4;">克</td>
                    <td>
                        <select name="produce_frequence" class="produce_frequence">
                            <option value="1">先煎</option>
                            <option value="2">后下</option>
                            <option value="3">包煎</option>
                            <option value="4">烊化</option>
                            <option value="5">冲服</option>
                            <option value="6">普通</option>
                        <slect>
                    </td>
                    <td class="del"><img src="img/订单详细-2_03.gif" alt=""></td>
                </tr>

            </table>
            <button class="jia" id="jia" style="width:80px;height:40px;line-height:40px;font-size:16px; background:#f4ad59;text-align:center;margin-left:180px;border:none; color:white; border-radius:5px; margin-bottom:15px;">添加<tton>
        </div>

    </div>
    <div class="lrfoot" style="display:inline;">
        <div class="lrfootl" style="margin-top:600px; margin-left:300px;">
            <input id="lrover" type="button" value="完成" onclick="psdshowdiv();" />
        </div>
    </div>
    <div id="psdbg">
    </div>
    <div id="psdshow">
        <div class="psd" id="">
            <p>个人密码<input type="text" name="password_hash" id="password_hash"></p>
            <input id="psdover" type="button" value="完成" onclick="psdshowdiv();"/>
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
