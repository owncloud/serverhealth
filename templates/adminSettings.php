<?php

script('health', ['script']);

?>

<script id="health-checks-template" type="text/x-handlebars-template">
	<table class="checks-list grid">
		<thead>
			<tr>
				<th>Name</th>
				<th>Last Run</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			{{#each this}}
				<tr>
					<td>{{name}}</td>
					<td>{{lastRun}}</td>
					<td>Run</td>
				</tr>
			{{/each}}
		</tbody>
	</table>
</script>
<div class="section" id="app-health">
	<h2><?php p($l->t('Health')); ?></h2>
</div>
