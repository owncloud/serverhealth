<?php

script('serverhealth', ['script']);

?>

<script id="serverhealth-checks-template" type="text/x-handlebars-template">
	<table class="checks-list grid">
		<thead>
			<tr>
				<th>Name</th>
				<th>Last Run</th>
				<th>Status Text</th>
				<th>Status Percentage</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			{{#each this}}
				<tr>
					<td>{{name}}</td>
					<td>{{lastRun}}</td>
					<td>{{state.stateText}}</td>
					<td></td>
					<td>Run</td>
				</tr>
			{{/each}}
		</tbody>
	</table>
</script>
<div class="section" id="app-serverhealth">
	<h2><?php p($l->t('Server Health')); ?></h2>
</div>
