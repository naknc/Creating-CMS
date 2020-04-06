<?php if(empty ($item_images)) { ?>

<div class="alert alert-info text-center">
	<p>Burada herhangi bir resim bulunmamaktadır.</p>
</div>

<?php } else { ?>

		<table class="table table-bordered table-striped table-hover pictures_list">
			<thead>
				<th>#id</th>
				<th>Görsel</th>
				<th>Resim Adı</th>
				<th>Durumu</th>
				<th>Kapak</th>
				<th>İşlem</th>
			</thead>
			<tbody>

			<?php foreach($item_images as $image ){ ?>
				<tr>
					<td class="w100 text-center">#<?php echo $image->id; ?></td>
					<td class="w100 text-center"><img width="30" src="<?php echo base_url("uploads/{$viewFolder}/$image->img_url");?>" alt="<?php echo $image->img_url;?>" class="img-responsive"></td>
					<td><?php echo $image->img_url; ?></td>
					<td class="w100 text-center">
						<input
							data-url="<?php echo base_url("product/isActiveSetter")?>"
							class="isActive"
							type="checkbox" 
							data-switchery 
							data-color="#10c469" 
							<?php echo ($image->isActive) ? "checked" : ""; ?>
						/>
					</td>
					<td class="w100 text-center">
						<input
							data-url="<?php echo base_url("product/isCoverSetter/$image->id/$image->product_id")?>"
							class="isCover"
							type="checkbox" 
							data-switchery 
							data-color="#ff5b5b" 
							<?php echo ($image->isCover) ? "checked" : ""; ?>
						/>
					</td>
					<td class="w100 text-center">
						<button 
							data-url="<?php echo "product/delete"; ?>" 
							class="btn btn-sm btn-danger btn-outline btn-block remove-btn">
							<i class="fa fa-trash"></i> Sil
						</button>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php } ?>