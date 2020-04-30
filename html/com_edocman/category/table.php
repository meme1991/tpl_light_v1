<?php
/**
 * @version         1.9.7
 * @package        Joomla
 * @subpackage  EDocman
 * @author         Tuan Pham Ngoc
 * @copyright      Copyright (C) 2011 - 2018 Ossolution Team
 * @license        GNU/GPL, see LICENSE.php
 */
// no direct access
defined( '_JEXEC' ) or die ;
$user = JFactory::getUser();
?>
<section class="wrapper">
	<div class="container" id="edocman-category">
		<div class="row">
			<div class="col-12">

				<form method="post" name="adminForm" id="adminForm" action="<?php echo JRoute::_('index.php?option=com_edocman&view=category&id='.$this->category->id.'&layout=table&Itemid='.$this->Itemid); ?>">
					<div id="edocman-category-page-table" class="edocman-container">
						<?php $imgUrl = ''; ?>
							<?php if ($this->category) : ?>
								<?php if ($this->category->image && JFile::exists(JPATH_ROOT.'/media/com_edocman/category/thumbs/'.$this->category->image)) : ?>
									<?php $imgUrl = JUri::base().'media/com_edocman/category/thumbs/'.$this->category->image; ?>
								<?php endif; ?>
								<div class="d-flex align-items-center">
									<?php if ($imgUrl) : ?>
										<div class="edocman-image-category">
											<img class="img-thumbnail edocman-thumb-left" src="<?php echo $imgUrl; ?>" alt="<?php echo $this->category->title; ?>" />
										</div>
									<?php endif; ?>
									<div class="w-100">
										<h1 class="edocman-page-heading">
											<?php if($imgUrl == '') : ?>
												<i class="edicon edicon-folder-open"></i>
											<?php endif; ?>
											<?php echo $this->category->title; ?>
										</h1>
										<?php if($this->config->enable_rss) : ?>
											<span class="edocman-rss-icon"><a href="<?php echo JRoute::_('index.php?option=com_edocman&view=category&id='.$this->category->id.'&format=feed&type=rss'); ?>"><img src="<?php echo JUri::root().'/components/com_edocman/assets/images/rss.png' ?>" /></a></span>
										<?php endif; ?>
										<?php if ($user->authorise('core.create', 'com_edocman.category.'.$this->category->id)) : ?>
											<span style="float: right;"><a href="<?php echo JRoute::_('index.php?option=com_edocman&view=document&layout=edit&catid=' . $this->category->id . '&Itemid=' . $this->Itemid); ?>" class="edocman_upload_link btn btn-primary"><i class="edicon edicon-upload"></i>&nbsp;<?php echo JText::_('EDOCMAN_UPLOAD'); ?></a></span>
										<?php endif; ?>
										<?php if($this->category->description != '') : ?>
											<div class="edocman-description"><?php echo $this->category->description;?></div>
										<?php endif; ?>
									</div>
								</div>
								<div class="clearfix"></div>
							<?php else : ?>
								<?php if (is_object($this->menu)) : ?>
									<?php if ($this->params->get('show_page_heading', 0)) : ?>
										<h1 class="edocman-page-heading"><?php echo $this->params->get('page_heading'); ?></h1>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if (count($this->categories) && $this->combine_categories == 0) : ?>
								<?php echo EDocmanHelperHtml::loadCommonLayout('common/categories_table.php', array('categories' => $this->categories, 'categoryId' => $this->category->id, 'config' => $this->config, 'bootstrapHelper' => $this->bootstrapHelper, 'Itemid' => $this->Itemid , 'subscat' => $this->show_subcat)); ?>
							<?php endif; ?>
							<?php if ($this->config->show_sort_options && count($this->items)) : ?>
								<?php echo EDocmanHelperHtml::loadCommonLayout('common/category_header.php', array('lists' => $this->lists, 'showLayoutswitcher' => false, 'bootstrapHelper' => $this->bootstrapHelper)); ?>
							<?php endif; ?>
							<?php if (count($this->items)) : ?>
								<?php echo EDocmanHelperHtml::loadCommonLayout('common/documents_table.php', array('items' => $this->items, 'config' => $this->config, 'Itemid' => $this->Itemid, 'category' => $this->category, 'categoryId' => (int) $this->categoryId, 'bootstrapHelper' => $this->bootstrapHelper)); ?>
							<?php endif; ?>

							<?php if ($this->pagination->total > $this->pagination->limit) : ?>
								<div class="pagination">
									<?php echo $this->pagination->getPagesLinks(); ?>
								</div>
							<?php endif; ?>
					</div>
					<input type="hidden" name="cid[]" value="0" id="document_id" />
					<input type="hidden" name="category_id" value="<?php echo $this->category->id ; ?>" />
					<input type="hidden" name="task" value="" />
					<?php echo JHtml::_('form.token'); ?>
				</form>

			</div>
		</div>
	</div>
</section>


<script type="text/javascript">
	function deleteConfirm(id) {
		var msg = "<?php echo JText::_('EDOCMAN_DELETE_CONFIRM'); ?>";
		if (confirm(msg)) {
			var form = document.adminForm ;
			form.task.value = 'documents.delete';
			document.getElementById('document_id').value = id;
			form.submit();
		}
	}
</script>
