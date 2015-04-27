<?php $this->BcBaser->js('ThemeSwitch.theme_switch'); ?>
<div id="theme-switch">
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
			<div id="error-message-<?php echo $key ?>" class="error-message" style="display: none;"></div>
		</td>
	</tr>

	<?php endforeach ?>
	</tbody>
</table>
<div style="display: none;" id="theme-switch-config-submit-url"><?php echo $submitUrl ?></div>
<div style="display: none;" id="theme-switch-config-token"><?php echo $csrfTokenKey ?></div>
<div class="submit">
<button class="button" id="theme-switch-config-submit">保存</button>
</div>
<div id="theme-switch-config-dialog" class="display-none">
	<p>保存しました</p>
</div>
</div>