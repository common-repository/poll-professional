<div class="poll-p">
	<h2 class="title">
		<?= __( 'Poll answers' ); ?>
		<span class="answer-number"><?= isset($aPoll['answers']) ? count($aPoll['answers']) : ''; ?></span>
	</h2>
	<div class="add-poll-row">+</div>
	<ul class="poll-answers-container sortable">
	<?php if (isset($aPoll['answers'])) : ?>
		<?php foreach ($aPoll['answers'] as $aRow) : // echo '<pre>';print_r($aRow);die;?>
		<li class="poll-answers-content">
			<div class="poll-row">
                <input type="hidden" name="poll[poll-answers][uID][]" value="<?= isset($aRow['uID']) ? $aRow['uID'] : md5(time().rand(1,1000)); ?>" />
				<span class="move-poll-row">&#8597;</span>
				<input type="text" name="poll[poll-answers][poll-answer][]" class="answer" value="<?= $aRow['answer']; ?>" placeholder="<?= __( 'Enter possible answer' ); ?> *" />
				<div class="poll-row-toggle-area">
					<textarea name="poll[poll-answers][poll-answer-desc][]" value="" placeholder="<?= __( 'Enter answer description' ); ?>" ><?= $aRow['answer-desc']; ?></textarea>
					<label class="hidden" for=""><?= __(  'Choose sub poll on select' ) ?></label>
					<select class="sub-poll hidden" name="poll[poll-answers][sub-poll][]">
						<option></option>
					<?php foreach ($aPolls as $pRow) : ?>
						<option <?= isset($aRow['sub-poll']) && !empty($aRow['sub-poll']) ? 'selected' : '' ?> value="<?= $pRow->ID?>"><?= $pRow->post_title ?></option>
					<?php endforeach; ?>
					</select>
					<fieldset class="poll-row-settings">
						<legend><?= __(  'Answer settings' ) ?></legend>
						<div class="poll-row-settings-content">
							<div class="poll-settings-row">
								<label for="visible"><?= __( 'Visible answer' ); ?></label>
								<select name="poll[poll-answers][visible][]">
									<option <?= ( isset($aRow['visible']) && $aRow['visible'] == '1' ) ? 'selected' : ''; ?> value="1"><?= __( 'Yes' ); ?></option>
									<option <?= ( isset($aRow['visible']) && $aRow['visible'] == '0' ) ? 'selected' : ''; ?> value="0"><?= __( 'No' ); ?></option>
								</select>
							</div>
							<div class="poll-settings-row">
								<label for="color"><?= __( 'Color' ); ?></label>
								<div class="poll-color <?= isset($aRow['color']) ? '' : 'empty'; ?>" style="background-color: <?= isset($aRow['color']) ? $aRow['color'] : ''; ?>"></div>
								<input type="hidden" value="<?= isset($aRow['color']) ? $aRow['color'] : 'rgb(52, 152, 219)'; ?>" name="poll[poll-answers][color][]" class="color-store" />
								
								<div class="set-color">
									<div class="color-picker"></div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<span class="remove-poll-row">-</span>
				<div class="toggle-poll-row">&#10151;</div>
			</div>
		</li>
		<?php endforeach; ?>
	<?php endif; ?>
		<li class="poll-answers-content answer-template">
			<div class="poll-row">
				<span class="move-poll-row">&#8597;</span>
				<input type="text" name="poll[poll-answers][poll-answer][]" class="answer" value="" placeholder="<?= __( 'Enter possible answer' ); ?> *" />
				<div class="poll-row-toggle-area">
					<textarea name="poll[poll-answers][poll-answer-desc][]" value="" placeholder="<?= __( 'Enter answer description' ); ?>" ></textarea>
					<label class="hidden" for=""><?= __(  'Choose sub poll on select' ) ?></label>
					<select class="sub-poll hidden" name="poll[poll-answers][sub-poll][]">
						<option></option>
					<?php foreach ($aPolls as $pRow) : ?>
						<option value="<?= $pRow->ID?>"><?= $pRow->post_title ?></option>
					<?php endforeach; ?>
					</select>
					<fieldset class="poll-row-settings">
						<legend><?= __(  'Answer settings' ) ?></legend>
						<div class="poll-row-settings-content">
							<div class="poll-settings-row">
								<label for="visible"><?= __( 'Visible answer' ); ?></label>
								<select name="poll[poll-answers][visible][]">
									<option <?= ( isset($aRow['visible']) && $aRow['visible'] == '1' ) ? 'selected' : ''; ?> value="1"><?= __( 'Yes' ); ?></option>
									<option <?= ( isset($aRow['visible']) && $aRow['visible'] == '0' ) ? 'selected' : ''; ?> value="0"><?= __( 'No' ); ?></option>
								</select>
							</div>
							<div class="poll-settings-row">
								<label for="color"><?= __( 'Color' ); ?></label>
								<div class="poll-color empty"></div>
								<input type="hidden" value="rgb(52, 152, 219)" name="poll[poll-answers][color][]" class="color-store" />
								
								<div class="set-color">
									<div class="color-picker"></div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<span class="remove-poll-row">-</span>
				<div class="toggle-poll-row">&#10151;</div>
			</div>
		</li>
	</ul>
</div>