<?php $aPollData = $aPoll['general']; ?>

<div class="poll-p poll-main-settings">
	<div class="poll-settings-row">
		<?= __( 'Show effect' ); ?>
		<select name="poll[show-effect]">
			<option <?= isset($aPollData['show-effect']) && $aPollData['show-effect'] == 'none' ? 'selected' : '' ?> value="none">Normal</option>
			<option <?= isset($aPollData['show-effect']) && $aPollData['show-effect'] == 'animation' ? 'selected' : '' ?> value="animation">Animate</option>
		</select>
	</div>
	<div class="poll-settings-row">
		<label for="visible"><?= __( 'Animate answer fill' ); ?></label>
		<input type="checkbox" class="poll-answer-animate" <?= ( isset($aPollData['answer-animate']) && $aPollData['answer-animate'] == '1' ) ? 'checked' : ''; ?> name="poll[answer-animate]" />
	</div>
	<div class="poll-settings-row">
		<label for="disable-show-desc"><?= __( 'Disable showing of description' ); ?></label>
		<input type="checkbox" class="poll-disable-show-desc" <?= ( isset($aPollData['disable-show-desc']) && $aPollData['disable-show-desc'] == '1' ) ? 'checked' : ''; ?> name="poll[disable-show-desc]" />
	</div>
    <!-- <div class="poll-settings-row">
		<label for="view-result"><?= __( 'Can user view result before voting' ); ?></label>
		<input type="checkbox" class="poll-view-result" <?= ( isset($aPollData['view-result']) && $aPollData['view-result'] == '1' ) ? 'checked' : ''; ?> name="poll[view-result]" />
	</div> -->
	<div class="poll-settings-row">
		<label for="num-votes"><?= __( 'Larger number of votes ( after vote )' ); ?></label>
		<input type="checkbox" class="poll-num-votes" <?= ( isset($aPollData['show-num-votes-after-vote']) && $aPollData['show-num-votes-after-vote'] == '1' ) ? 'checked' : ''; ?> name="poll[show-num-votes-after-vote]" />
	</div>
	<div class="poll-settings-row">
		<label for="num-votes-before"><?= __( 'Larger number of votes ( before vote )' ); ?></label>
		<input type="checkbox" class="poll-num-votes-before" <?= ( isset($aPollData['show-num-votes-before-vote']) && $aPollData['show-num-votes-before-vote'] == '1' ) ? 'checked' : ''; ?> name="poll[show-num-votes-before-vote]" />
	</div>
	<div class="poll-settings-row">
		<label for="color"><?= __( 'General color for answers' ); ?></label>
		<div class="poll-color <?= isset($aPollData['general-color']) ? '' : 'empty'; ?>" style="background-color: <?= isset($aPollData['general-color']) ? $aPollData['general-color'] : ''; ?>"></div>
		<input type="hidden"  name="poll[general-color]" value="<?= isset($aPollData['general-color']) ? $aPollData['general-color'] : 'rgb(52, 152, 219)'; ?>" class="color-store" />
		
		<div class="set-color">
			<div class="color-picker"></div>
		</div>
	</div>
	<div class="poll-settings-row">
		<label for="only-general-color-answers"><?= __( 'Use only general color for answers' ); ?></label>
		<input type="checkbox" class="poll-only-general-color-answers" <?= ( isset($aPollData['only-general-color-answers']) && $aPollData['only-general-color-answers'] == '1' ) ? 'checked' : ''; ?> name="poll[only-general-color-answers]" />
	</div>
    <div class="poll-settings-row date-section">
        <label for="start-date"><?= __( 'Start date' ); ?></label>
		<input class="start-datepicker start-date" placeholder="<?= __( 'Date' ); ?>" value="<?= isset($aPollData['start-date']) ? date('d.m.Y', strtotime($aPollData['start-date'])) : ''; ?>" name="poll[start-date]" />
        <input class="picker-start-date" disabled value="<?= isset($aPollData['start-date']) ? date('D, d M, y', strtotime($aPollData['start-date'])) : ''; ?>" />
        <input class="timepicker start-time" placeholder="<?= __( 'Time' ); ?>" value="<?= isset($aPollData['start-date']) ? date('H:i', strtotime($aPollData['start-date'])) : ''; ?>" name="poll[start-time]" />
    </div>
    <div class="poll-settings-row date-section">
        <label for="end-date"><?= __( 'End date' ); ?></label>
		<input class="end-datepicker end-date" placeholder="<?= __( 'Date' ); ?>" value="<?= isset($aPollData['end-date']) ? date('d.m.Y', strtotime($aPollData['end-date'])) : ''; ?>" name="poll[end-date]" />
        <input class="picker-end-date" disabled value="<?= isset($aPollData['end-date']) ? date('D, d M, y', strtotime($aPollData['end-date'])) : ''; ?>" />
        <input class="timepicker end-time" placeholder="<?= __( 'Time' ); ?>" value="<?= isset($aPollData['end-date']) ? date('H:i', strtotime($aPollData['end-date'])) : ''; ?>" name="poll[end-time]" />
    </div>
</div>