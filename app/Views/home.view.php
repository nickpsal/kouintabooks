<!-- content -->
	<div class="container">
        <div class="error">
		    <?php
	    	    if (message()) {
		    	    echo message('', true);
		        }
		    ?>
	    </div>
	</div>
	<div class="table-responsive">
		<H1><?=$data['title']?></H1>
		<label class="searchLabel" for="search">Search:</label>
		<input class="searchInput" type="text" id="search" placeholder="Type to search...">
    	<button type="button" class="btn btn-primary" onclick="searchTable()">Search</button>
		<a href="<?=URL?>home/add" class="btn btn-primary" type="button">Add New</a>
		<table id="myTable" class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Publisher</th>
					<th>Year</th>
					<th>ISBN</th>
					<th>Price</th>
					<th>FinalPriceWithOutVAT</th>
					<th>FinalPriceWithVAT</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($data['data'] as $d) {
					?>
					<tr>
						<td><?=$d->Id?></td>
						<td><?=$d->Title?></td>
						<td><?=$d->PublisherName?></td>
						<td><?=$d->Year?></td>
						<td><?=$d->ISBN?></td>
						<td><?=$d->Price?></td>
						<td><?=$d->FinalPriceWithOutVAT?></td>
						<td><?=$d->FinalPriceWithVAT?></td>
						<td>
							<a href="<?=URL?>home/update?id=<?=$d->Id?>" class="btn btn-primary" type="button">Update</a>
							<a href="<?=URL?>home/delete?id=<?=$d->Id?>" class="btn btn-primary" type="button">Delete</a>
						</td>
					</tr>
				<?php }
			?>
			</tbody>
		</table>
	</div>