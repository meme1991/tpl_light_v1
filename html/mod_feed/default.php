<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_feed
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php
if (!empty($feed) && is_string($feed)) :
	echo $feed;
else :
	$lang      = JFactory::getLanguage();
	$myrtl     = $params->get('rssrtl');
	$direction = ' ';

	$isRtl = $lang->isRtl();

	if ($isRtl && $myrtl == 0)
	{
		$direction = ' redirect-rtl';
	}

	// Feed description
	elseif ($isRtl && $myrtl == 1)
	{
		$direction = ' redirect-ltr';
	}

	elseif ($isRtl && $myrtl == 2)
	{
		$direction = ' redirect-rtl';
	}

	elseif ($myrtl == 0)
	{
		$direction = ' redirect-ltr';
	}
	elseif ($myrtl == 1)
	{
		$direction = ' redirect-ltr';
	}
	elseif ($myrtl == 2)
	{
		$direction = ' redirect-rtl';
	}

	if ($feed !== false) :
		// Image handling
		$iUrl   = isset($feed->image) ? $feed->image : null;
		$iTitle = isset($feed->imagetitle) ? $feed->imagetitle : null;
		$bootstrap_size = ($params->get('bootstrap_size')) ? $params->get('bootstrap_size') : 12;
		?>

		<div class="feed <?php echo $moduleclass_sfx; ?>">
		<?php if ($feed->title !== null && $params->get('rsstitle', 1)) : ?>
			<h2 class="<?php echo $direction; ?>">
				<a href="<?php echo htmlspecialchars($rssurl, ENT_COMPAT, 'UTF-8'); ?>" target="_blank">
				<?php echo $feed->title; ?></a>
			</h2>
		<?php endif; ?>

		<?php if ($params->get('rssdesc', 1)) : ?>
			<?php echo $feed->description; ?>
		<?php endif; ?>

		<?php if ($iUrl && $params->get('rssimage', 1)) : ?>
			<img src="<?php echo $iUrl; ?>" alt="<?php echo @$iTitle; ?>"/>
		<?php endif; ?>

		<!-- Show items -->
		<?php if (!empty($feed)) : ?>
			<ul class="list-unstyled newsfeed<?php echo $params->get('moduleclass_sfx'); ?> mb-0">
			<?php for ($i = 0, $max = min(count($feed), $params->get('rssitems', 5)); $i < $max; $i++) : ?>
				<?php $uri   = (!empty($feed[$i]->uri) || $feed[$i]->uri !== null) ? trim($feed[$i]->uri) : trim($feed[$i]->guid); ?>
				<?php $uri   = strpos($uri, 'http') !== 0 ? $params->get('rsslink') : $uri; ?>
				<?php $text  = !empty($feed[$i]->content) || $feed[$i]->content !== null ? trim($feed[$i]->content) : trim($feed[$i]->description); ?>
				<?php $title = trim($feed[$i]->title); ?>

					<li class="mb-2">
						<?php if (!empty($uri)) : ?>
							<span class="feed-link">
								<a href="<?php echo htmlspecialchars($uri, ENT_COMPAT, 'UTF-8'); ?>" target="_blank">
									<?php echo $feed[$i]->title; ?>
								</a>
							</span>
						<?php else : ?>
							<span class="feed-link"><?php echo $title; ?></span>
						<?php endif; ?>

						<?php if (!empty($text) && $params->get('rssitemdesc')) : ?>
							<div class="feed-item-description">
								<?php $text = JFilterOutput::stripImages($text); ?>
								<?php $text = JHtml::_('string.truncate', strip_tags($text), $params->get('word_count')); ?>
								<p class="mb-0"><?php echo str_replace('&apos;', "'", $text); ?></p>
							</div>
						<?php endif; ?>
					</li>
			<?php endfor; ?>
			</ul>
		<?php endif; ?>
		<!-- Show items -->

		</div>
	<?php endif; ?>
<?php endif; ?>
