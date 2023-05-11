<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title"><?= $heading?></h3>
				</div>
				<div class="col-auto text-right">
					<a href="<?= admin_url('subscription/create')?>" class="btn btn-primary add-button">
						<i class="fas fa-plus"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="row pricing-box">
			<?php foreach ($offersdata as $key) { ?>
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="card" style="height:400px;">
					<div class="card-body">
						<div class="pricing-header">
							<h2><?php echo @$key->subscription_name; ?></h2>
							<p><?php echo ucfirst(@$key->subscription_type)?> Subscription (<b><?php echo $key->subscription_amount?></b>)</p>
						</div>
						<div class="pricing-card-price">
							<!-- <h3 class="heading2 price"><?php //echo 'USD'.' '.$key->subscription_amount; ?></h3> -->
							<p>Duration: <span><?php echo $key->subscription_duration; ?> </span></p>
						</div>
						<div class="pricing-options">
							<?php echo $key->subscription_description;?>
						</div>
						<!-- <ul class="pricing-options">
						<?php //$suboffer=$this->Crud_model->GetData('subscription_service','',"subscription_id='".$key->id."'");
						//foreach ($suboffer as $row) { ?>
							<li><i class="far fa-check-circle"></i><?php //echo $row->service;?></li>
						<?php //} ?>
						</ul> -->
						<a href="<?= admin_url('subscription/update/'.base64_encode($key->id))  ?>" class="btn btn-primary btn-block">Edit</a>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>
</div>
<style>
.pricing-box .pricing-header {
    margin-bottom: 0 !important;
}
</style>
