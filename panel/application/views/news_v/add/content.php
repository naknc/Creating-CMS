<div class="row">
	<div class="col-md-12">
		<h4 class="m-b-lg">
			Yeni Haber Ekle
		</h4>
	</div><!-- END column -->
	<div class="col-md-12">
	<div class="widget">
		<div class="widget-body">
			<form action="<?php echo base_url("news/save");?>" method="post">
				
				<div class="form-group">
					<label>Başlık</label>
					<input class="form-control" placeholder="Başlık" name="title">
					<?php if(isset($form_error)){ ?>
						<small class="pull-right input-form-error"><?php echo form_error("title"); ?></small>
					<?php } ?>	
				</div>

				<div class="form-group">
					<label>Açıklama</label>
					<textarea name="description" class="m-0" data-plugin="summernote" data-options="{height: 250}"></textarea>
				</div>

				<div class="form-group">
					<label for="control-demo-6" class="">Haberin Türü</label>
						<div id="control-demo-6" class="">
							<select class="form-control news_type_select" name="news_type">
								<option value="image">Resim</option>
								<option value="video">Video</option>
							</select>
						</div>
				</div><!-- .form-group -->

				<div class="form-group image_upload_container">
					<label for="exampleInputFile">Görsel Seçiniz</label>
						<input type="file" name="img_url" class="form-control">
				</div>
				
				<div class="form-group video_url_container">
					<label>Video URL</label>
					<input class="form-control" placeholder="Video bağlantısını buraya yapıştırınız" name="video_url">
					<?php if(isset($form_error)){ ?>
						<small class="pull-right input-form-error"><?php echo form_error("video_url"); ?></small>
					<?php } ?>	
				</div>

				<button type="submit" class="btn btn-primary btn-md btn-outline">Kaydet</button>
				<a href="<?php echo base_url("news");?>" class="btn btn-md btn-danger btn-outline">İptal</a>

			</form>
		</div><!-- .widget-body -->
	</div><!-- .widget -->
	</div><!-- END column -->
</div>