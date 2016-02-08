<?php /** @package ecfirm.net
* @copyright	Copyright (C) kilmeny.net. All rights reserved.
* @license GNU General Public License version 2 or later. */
defined('_JEXEC') or die('Restricted access');



$valueKey = (is_object($item)) ? $item->$nameKey : 0; //EcDebug::lp($item);
$availableEdit = (1) ? true : false;
$availableDelete = (1) ? true : false;
$intro = nl2br(JHtml::_('string.truncateComplex', $item->body, 80));
$sizeIntro = JString::strlen($intro);
$sizeBody = JString::strlen($item->body); //EcDebug::lp($sizeIntro); EcDebug::lp($sizeBody);
$body = ($sizeIntro < $sizeBody) ?
$intro.EcWidget::readmoreSpan($item->body) : $intro;
$modified = EcDatetime::interval($item->modified);
$itemLink = '?option='.$optionCom.'&view='.$nameKey.'&'.$nameKey.'='.$valueKey;
$title = ($this->plural) ? '<a href="'.$itemLink.'">'.$item->title.'</a>' : $item->title;

$imgs = json_decode($item->imgs, true); //EcDebug::lp(count($imgs));
$imgThumb = (count($imgs) > 1) 
	? JUri::base().$imgs['thumb'] : EctopicConst::IC_TOPIC_ABSTRACT;



echo '<div id="'.$nameKey.'_'.$valueKey.'" class="well well-small">';
	if(isset($item->event->beforeDisplay)) echo $item->event->beforeDisplay;
	
	echo '<form action="'.(JUri::getInstance()->toString()).'" method="post" id="'
		.$nameKey.'_'.$valueKey.'_form" class="form-validate form-vertical">';

		echo '<div class="pull-left" style="width:80%" align="left">';
			echo '<div class="pull-left media" style="margin-right:10px;">';
				//echo '<a href="">';
					echo '<img class="media-object thumbnail" src="'.$imgThumb.'" alt="">';
				//echo '</a>';
			echo '</div>';
			echo '<div class="media-body">';
				echo '<div>'.$title.'</div>';
				echo '<div>'.$item->modified.'</div>';
				//echo '<div>'.$body.'</div>';
			echo '</div>';
		echo '</div>';	
	
		echo '<div class="pull-right" style="width:20%" align="right">';
			echo '<div class="btn-group">';
				echo EcWidget::caretBtn(false);
				echo '<ul class="dropdown-menu" style="right:0px;left:auto;" role="menu">';
					$params['nameCols'] = array('topic', 'user');
					$params['optionCom'] = $optionCom;
					$params['nameKey'] = $nameKey;
					$params['valueKey'] = $valueKey;
					$params['task'] = 'touch';
					$params['idPostfix'] = 'form';
					$params['post'] = true;
					if($availableEdit) echo EcWidget::submitBtnLi($params);
					$params['task'] = 'edit';
					if($availableEdit) echo EcWidget::submitBtnLi($params);
					echo '<li class="divider"></li>';
					$params['task'] = 'delete';
					if($availableDelete) echo EcWidget::submitBtnLi($params);
				echo '</ul>';
			echo '</div>';
		echo '</div>'; //EcDebug::lp($params);

		echo '<input type="hidden" name="'.$nameKey.'" value="'.$valueKey.'">';
		echo '<input type="hidden" name="task" value="" />';
		echo JHtml::_('form.token');
	echo '</form><div class="clearfix"></div>';
	
	
	if(isset($item->event->afterDisplay)) echo $item->event->afterDisplay;
echo '</div>';