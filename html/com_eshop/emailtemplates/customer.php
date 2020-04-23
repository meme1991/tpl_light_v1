<?php
/**
 * @version		3.3.0
 * @package		Joomla
 * @subpackage	EShop
 * @author  	Giang Dinh Truong
 * @copyright	Copyright (C) 2012 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined( '_JEXEC' ) or die();
?>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
	<thead>
		<tr>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">
				<?php echo JText::_('ESHOP_PRODUCT_NAME'); ?>
			</td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">
				<?php echo JText::_('ESHOP_MODEL'); ?>
			</td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
				<?php echo JText::_('ESHOP_QUANTITY'); ?>
			</td>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
				<?php echo JText::_('ESHOP_UNIT_PRICE'); ?>
			</td>
			<?php
			if ($showDownloadLink)
			{
				?>
				<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: center; padding: 7px; color: #222222;">
					<?php echo JText::_('ESHOP_DOWNLOADS'); ?>
				</td>
				<?php
			}
			?>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
				<?php echo JText::_('ESHOP_TOTAL'); ?>
			</td>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($orderProducts as $product)
		{
			?>
			<tr>
				<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
				<?php echo $product->product_name; ?>
				<?php
				foreach ($product->orderOptions as $option)
				{
					if ($option->option_type == 'File' && $option->option_value != '')
					{
						echo '<br />- ' . $option->option_name . ': <a href="' . EshopHelper::getSiteUrl() . 'index.php?option=com_eshop&task=downloadOptionFile&id=' . $option->id . '">' . $option->option_value . '</a>';
					}
					else
					{
						echo '<br />- ' . $option->option_name . ': ' . $option->option_value . (isset($option->sku) && $option->sku != '' ? ' (' . $option->sku . ')' : '');
					}
				}
				?>
			</td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
				<?php echo $product->product_sku; ?>
			</td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
				<?php echo $product->quantity; ?>
			</td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
				<?php echo $product->price; ?>
			</td>
			<?php
			$colspan = 4;
			if ($showDownloadLink)
			{
				$colspan = 5;
				//Show list of download links for each product
				?>
				<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
					<?php
					if (count($product->downloads))
					{
						for ($i = 0; $n = count($product->downloads), $i < $n; $i++)
						{
							$download = $product->downloads[$i];
							?>
							<?php echo ($i + 1) . '. '?><a href="<?php echo JRoute::_(EshopHelper::getSiteUrl() . 'index.php?option=com_eshop&task=customer.downloadFile&order_id='.intval($download->order_id).'&download_code='.$download->download_code); ?>" title="<?php echo JText::_('ESHOP_DOWNLOAD'); ?>"><?php echo $download->download_name; ?></a>
							<?php
							if ($i < ($n - 1))
							{
								echo '<br />';
							}
						}
					}
					?>
				</td>
				<?php
			}
			?>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
				<?php echo $product->total_price; ?>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
	<tfoot>
		<?php
		foreach ($orderTotals as $total)
		{
			?>
			<tr>
				<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="<?php echo $colspan; ?>">
					<b><?php echo JText::_($total->title); ?></b>
				</td>
				<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
					<?php echo $total->text; ?>
				</td>
			</tr>
		<?php
		}
		?>
	</tfoot>
</table>