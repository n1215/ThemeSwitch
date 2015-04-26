<h2>設定</h2>
<table class="form-table">
	<tbody>
	<?php foreach(array('smartphone' => 'スマートフォン', 'mobile' => 'モバイル') as $key => $name): ?>
	<tr>
		<th class="col-head">
			<label for="theme-switch-config-<?php echo $key ?>"><?php echo $name ?></label>
		</th>
		<td class="col-input">

			<?php

			echo $this->Form->select($key, $themeList,
				array(
					'value' => $currentThemes[$key],
					'empty' => '選択',
					'id' => "theme-switch-config-{$key}"
				)
			);
			?>
		</td>
	</tr>

	<?php endforeach ?>
	</tbody>
</table>
<div style="display: none;" id="theme-switch-config-submit-url"><?php echo $submitUrl ?></div>
<div class="submit">
<button class="button" id="theme-switch-config-submit">保存</button>
</div>

<script>
$(function(){
	var $button = $('#theme-switch-config-submit');
	var submitUrl = $('#theme-switch-config-submit-url').html();
	var $smartphone = $('#theme-switch-config-smartphone');
	var $mobile = $('#theme-switch-config-mobile');
	var $waiting = $('#Waiting');


	$button.on('click', function(){
		var data = {
			smartphone: $smartphone.val(),
			mobile: $mobile.val()
		};

		$.ajax({
			url: submitUrl,
			type: 'POST',
			data: JSON.stringify(data),
			beforeSend: function() {
				$waiting.show();
			},
			success: function(response, status) {

			},

			error: function(response, status) {

			},
			complete: function() {
				$waiting.hide();
			}
		});
	});
});
</script>