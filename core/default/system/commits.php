<?php
	$template->getHeader();
	
	?>
	<style>
		.commits {
			margin-top: 10px;
			list-style-type: none;
			display: table;
			width: 100%;
			color: #6a737d;
			table-layout: fixed;
			padding: 0 50px 0 50px;
		}
		
		.commits .commit {
			position: relative;
			display: table-row;
			list-style: none;
		}
		
		.commits .commit ctn-author,
		.commits .commit ctn-message,
		.commits .commit ctn-actions {
			position: relative;
			display: table-cell;
			padding: 8px 10px;
			font-size: 12px;
			vertical-align: top;
			border-top: 1px solid #eaecef;
		}
		
		.commits .commit ctn-author {
			width: 47px;
			border-left: 1px solid #eaecef;
		}
		
		.commits .commit ctn-author img {
			display: inline-block;
			overflow: hidden;
			line-height: 1;
			vertical-align: middle;
			border-radius: 3px;
			width: 36px;
			height: 36px;
		}
				
		.commits .commit ctn-actions {
			width: 335px;
			text-align: right;
			border-right: 1px solid #eaecef;
		}
		
		.commits .commit:last-child ctn-author,
		.commits .commit:last-child ctn-message,
		.commits .commit:last-child ctn-actions {
			border-bottom: 1px solid #eaecef;
		}
	</style>
	<ol class="commits">
	<?php
	foreach($commits AS $commit) {
		?>
			<li class="commit">
				<ctn-author>
					<img src="<?php print $commit->author->avatar_url; ?>&s=72" alt="" />
				</ctn-author>
				<ctn-message>
					<strong><?php print $commit->commit->message; ?></strong>
					<p><?php print $commit->author->login; ?> committed <?php print $commit->commit->author->date; ?></p>
				</ctn-message>
				<ctn-actions>
					<a href="<?php print $commit->html_url; ?>" class="btn btn-primary" target="_blank">Ansehen</a>
				</ctn-actions>
			</li>
		<?php
	}
	?>
	</ol>
	<?php
	
	$template->getFooter();
?>