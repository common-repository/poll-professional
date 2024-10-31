<div class="poll-p-fe">
    <div class="poll-title"><?= $pPost->post_title; ?></div>
    
    <?php // echo '<pre>';print_r($aPoll); echo '</pre>'; ?>
    
    <?php
        $aTmp = isset($_COOKIE['poll-p']) ? $_COOKIE['poll-p'] : '';
        if (!empty($aTmp)) {
            $aTmp = (array) json_decode(stripslashes($aTmp));
        } else {
            $aTmp['poll-p-vote'] = [];
        }
        $aTmp['poll-p-vote'] = (array) $aTmp['poll-p-vote'];
        if (!(is_array($aTmp['poll-p-vote']) && in_array($pPost->ID, $aTmp['poll-p-vote'])) && $success_vote == false) {
        
            if ($aPoll['general']['show-num-votes-before-vote']) : ?>
            <div class="num-votes"><?= __( 'Num votes' ). ': <span>' .intval($aPoll['general']['num-votes']).'</span>'; ?></div>
            <?php endif; ?>
        
            <div class="poll-container">
            <?php foreach($aPoll['answers'] as $aAnswer) : ?>
                <?php if ($aAnswer['visible'] == 1) : ?>
                <div class="poll-item">
                    <input type="radio" class="posible-poll-answer" name="poll-p" value="<?= $aAnswer['uID']; ?>"> <span class="answer"><?= $aAnswer['answer']; ?></span>
                    <?php if ($aPoll['general']['disable-show-desc'] == 0) : ?>
                        <span class="toggle-answer-content">&#x25CF;&#x25CF;&#x25CF;</span>
                        <div class="ans-desc-content hidden"><?= $aAnswer['answer-desc']; ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
            <div class="submit-poll-p-vote disable-vote" data-id="<?= $pPost->ID; ?>"><?= __( 'Vote' ); ?></div>
        <?php } else { ?>
            <?php if ($aPoll['general']['show-num-votes-after-vote']) : ?>
            <div class="num-votes"><?= __( 'Num votes' ). ': <span>' .intval($aPoll['general']['num-votes']).'</span>'; ?></div>
            <?php endif; ?>
            <div class="poll-container">
            <?php foreach($aPoll['answers'] as $aAnswer) : 
                if ($aAnswer['visible'] == 1) {
                    $strColor = '';
                    if ($aPoll['general']['only-general-color-answers'] == 1) {
                        $strColor = $aPoll['general']['general-color'];
                    } else {
                        $strColor = $aAnswer['color'];
                    }
                    if ($aPoll['general']['num-votes'] > 0) {
                        $fPercent = $aAnswer['num-votes'] / $aPoll['general']['num-votes'] * 100;
                    } else {
                        $fPercent = 0;
                    }
                ?>
                <div class="poll-item">
                    <div class="answer"><?= $aAnswer['answer']; ?> <span><?= intval($fPercent); ?>%</span></div>
                    <div class="answer-bar">
                    <?php if ($aPoll['general']['show-effect'] == 'animation') : ?>
                        <span class="fill" data-width="<?= $fPercent; ?>" style="background-color: <?= $strColor; ?>;"></span>
                    <?php elseif ($aPoll['general']['show-effect'] == 'none') : ?>
                        <span class="fill" style="background-color: <?= $strColor; ?>; width: <?= $fPercent; ?>%;"></span>
                    <?php endif; ?>
                    </div>
                    <?php if ($aPoll['general']['disable-show-desc'] == 0) : ?>
                        <span class="toggle-answer-content">&#x25CF;&#x25CF;&#x25CF;</span>
                        <div class="ans-desc-content hidden"><?= $aAnswer['answer-desc']; ?></div>
                    <?php endif; ?>
                </div>
                <?php } ?>
            <?php endforeach; ?>
            </div>
        <?php } ?>
</div>