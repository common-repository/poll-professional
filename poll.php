<?php
require_once (__DIR__.'/init.php');
/*
	Plugin Name: Poll Professional
	Description: Plugin for professional polls.
	Version: 1.0
	Author: Sasho Celov
	Author Email: sasho.celov@gmail.com
	Author URI: 
*/


add_shortcode("poll_content", "pp_poll_get_content");
function pp_poll_get_content($attr) {
    $success_vote = false;
    extract($attr);
    if (isset($id)) {
        $pPost = get_post($id);
        $aPoll = get_post_meta($id, 'poll-data');
        if (isset($aPoll[0]) && !empty($aPoll)) {
            $aPoll = unserialize($aPoll[0]);
        }
        if (strtotime($aPoll['general']['start-date']) < time() && strtotime($aPoll['general']['end-date']) > time()) {
            require_once (__DIR__.'/templates/poll_template.php');
        }
    }
}

add_action( 'wp_ajax_pp_poll_p_vote', 'pp_poll_p_vote' );
function pp_poll_p_vote() {
    if (!isset($_POST['poll-id']) || !isset($_POST['poll-answer'])) {
        return false; // missing params
    }        
    if (strlen($_POST['poll-answer']) < 2) {       
        return false;    
    }    
    
    if ( !intval($_POST['poll-id']) ) { return false; }        
    $_POST['poll-answer'] = esc_attr(sanitize_text_field($_POST['poll-answer']));
    
    $aTmp = isset($_COOKIE['poll-p']) ? $_COOKIE['poll-p'] : '';
    if (!empty($aTmp)) {
        $aTmp = (array) json_decode(sanitize_text_field(stripslashes($aTmp)));
    }
    if (isset($aTmp['poll-p-vote'])) {
        $aTmp['poll-p-vote'] = (array) $aTmp['poll-p-vote'];
        if (is_array($aTmp['poll-p-vote']) && in_array($_POST['poll-id'], $aTmp['poll-p-vote'])) {
            wp_send_json(['message' => __( 'Already voted' )]);
            return true;
        }
    }

    $aPoll = get_post_meta($_POST['poll-id'], 'poll-data');
    if (isset($aPoll[0]) && !empty($aPoll)) {
        $aPoll = unserialize($aPoll[0]);
    }
    if (!empty($aPoll) && isset($aPoll['answers'])) {
        $bExist         = false;
        $nTotalVotes    = 0;
        foreach($aPoll['answers'] as $k => $aAns) {
            if ($aAns['uID'] == $_POST['poll-answer']) {
                $bExist = true;
                $aPoll['answers'][$k]['num-votes'] = intval($aAns['num-votes']) + 1;
            }
            $nTotalVotes += $aPoll['answers'][$k]['num-votes'];
        }
        $aPoll['general']['num-votes'] = $nTotalVotes;
        if ($bExist) {
            update_post_meta( $_POST['poll-id'],
                'poll-data',
                sanitize_text_field(serialize($aPoll))
            );
            
            wp_send_json([pp_poll_get_content(['id' => $_POST['poll-id'], 'success_vote' => true])]);
        }
    } else {
        echo 'error, missing poll or selected answer';
        return false; // error, missing poll or selected answer
    }
}

function render_poll_settings_meta_boxes( $post ) { 
	global $aPoll;
	require_once (__DIR__.'/templates/admin/poll_settings.php');
}

function render_poll_answers_meta_boxes( $post ) { 
	$args = [
	  'numberposts' 	=> 0,
	  'post_type'   	=> 'poll',
	  'post__not_in'	=> [$_GET['post']]
	];
	 
	$aPolls = get_posts( $args );	
	global $aPoll;
	require_once (__DIR__.'/templates/admin/poll_answers.php');
}

function pp_save_poll( $post_id ) {
    if ( array_key_exists('poll', $_POST ) ) {
    	$aPost = $_POST['poll'];
        $aTmpPoll = get_post_meta($post_id, 'poll-data');
        $nNumVotes = 0;
        if(!empty($aTmpPoll) && isset($aTmpPoll[0])) {
            $aTmpPoll = unserialize($aTmpPoll[0]);
            $nNumVotes = $aTmpPoll['general']['num-votes'];
        }

    	$aData = [
    		'general' 	=> [
    			'show-effect' 		            => sanitize_text_field($aPost['show-effect']),
    			'answer-animate'	            => isset($aPost['answer-animate']) ? 1 : 0,
    			'general-color'		            => isset($aPost['general-color']) ? sanitize_text_field($aPost['general-color']) : 'rgb(52, 152, 219)',
                'only-general-color-answers'    => isset($aPost['only-general-color-answers']) ? 1 : 0,
                'view-result'                   => isset($aPost['view-result']) ? 1 : 0,
                'show-num-votes-after-vote'     => isset($aPost['show-num-votes-after-vote']) ? 1 : 0,
                'show-num-votes-before-vote'    => isset($aPost['show-num-votes-before-vote']) ? 1 : 0,
                'start-date'                    => pp_get_date_time(sanitize_text_field($aPost['start-date']), sanitize_text_field($aPost['start-time'])),
                'end-date'                      => pp_get_date_time(sanitize_text_field($aPost['end-date']), sanitize_text_field($aPost['end-time'])),
                'num-votes'                     => $nNumVotes,
                'disable-show-desc'             => isset($aPost['disable-show-desc']) ? 1 : 0,
    		],
    	];

    	if (isset($aPost['poll-answers']['poll-answer'])) {
    		for ($i = 0; $i < count($aPost['poll-answers']['poll-answer']); $i++) {
    			if (!empty($aPost['poll-answers']['poll-answer'][$i])) {
                    $nNumVotes = 0;
                    if (isset($aTmpPoll['answers'][$i]['num-votes'])) {
                        $nNumVotes = sanitize_text_field($aTmpPoll['answers'][$i]['num-votes']);
                    }
					$aAnswerData[] = [
                        'uID'                   => sanitize_text_field($aPost['poll-answers']['uID'][$i]),
						'answer' 		        => sanitize_text_field($aPost['poll-answers']['poll-answer'][$i]),
						'answer-desc' 	        => sanitize_text_field($aPost['poll-answers']['poll-answer-desc'][$i]),
						'visible' 		        => sanitize_text_field($aPost['poll-answers']['visible'][$i]),
						'sub-poll'		        => sanitize_text_field($aPost['poll-answers']['sub-poll'][$i]),
						'color' 		        => sanitize_text_field($aPost['poll-answers']['color'][$i]),
                        'num-votes'             => $nNumVotes
					];
				}
    		}
        }

		$aData['answers'] = $aAnswerData;

      	update_post_meta( $post_id,
         	'poll-data',
          	serialize($aData)
      	);
    }
}

function pp_get_date_time($strDate, $strTime) {
    $strDate = str_replace('.', '-', $strDate);
    return date('Y-m-d H:i:s', strtotime($strDate.' '.$strTime));
}
