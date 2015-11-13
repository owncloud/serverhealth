<?php

style('serverhealth', ['style']);
script('serverhealth', ['script']);

?>

<script id="serverhealth-checks-table-template" type="text/x-handlebars-template">
	<table class="checks-list grid">
		<thead>
		<tr>
			<th>Name</th>
			<th>Last Run</th>
			<th>Status Text</th>
			<th class="text-centered">Status Percentage</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>{{table}}</tbody>
	</table>
</script>

<script id="serverhealth-checks-row-template" type="text/x-handlebars-template">
		{{#each this}}
		<tr data-id="{{id}}">
			<td>{{name}}</td>
			<td>{{formatRelativeISODateString lastRun}}</td>
			<td>{{state.stateText}}</td>
			<td class="text-centered">
				<div class="progress">
					<div class="progress-bar" style="width: {{formatPercentage state.statePercentage}}%">
						{{formatPercentage state.statePercentage}} %
					</div>
				</div>
			</td>
			<td>{{#if running}}<div class="icon-loading-small"></div>{{else}}<button>Run</button>{{/if}}</td>
		</tr>
		{{/each}}
</script>
<div class="section" id="app-serverhealth">
	<h2><?php p($l->t('Server Health')); ?></h2>
</div>
