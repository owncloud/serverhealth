/**
 * ownCloud - health
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Morris Jobke <hey@morrisjobke.de>
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 */

Handlebars.registerHelper('formatPercentage', function(value) {
	return Math.round(value * 100);
});

Handlebars.registerHelper('formatRelativeISODateString', function(dateString) {
	return OC.Util.relativeModifiedDate(Date.parse(dateString));
});

(function ($, _, OC, OCA) {

	OCA.Health = {

		checks: [],

		render: function(data) {
			var tableTemplate = Handlebars.compile($('#serverhealth-checks-table-template').html()),
				rowTemplate = Handlebars.compile($('#serverhealth-checks-row-template').html()),
				$settingsSection = $('#app-serverhealth');

			$settingsSection.find('.checks-list').remove();
			$settingsSection.append(tableTemplate({'table': new Handlebars.SafeString(rowTemplate(data))}));

			$settingsSection.find('.checks-list button').on('click', function() {
				var id = $(this).closest('tr').data('id');
				OCA.Health.runStep(id);
			});
		},

		updateState: function(id) {
			var checkList = $('#app-serverhealth').find('.checks-list'),
				row = checkList.find('tr[data-id="' + id + '"]'),
				rowTemplate = Handlebars.compile($('#serverhealth-checks-row-template').html()),
				check = OCA.Health.getCheckById(id);

			row.replaceWith(rowTemplate([check]));

			checkList
				.find('tr[data-id="' + id + '"] button')
				.on('click', function() {
					var id = $(this).closest('tr').data('id');
					OCA.Health.runStep(id);
				});
		},

		load: function() {
			$.get(OC.generateUrl('/apps/serverhealth/checks'))
				.done(function(data){
					OCA.Health.render(data);
					OCA.Health.checks = data;
				})
				.fail(function(){
					console.log('Failed');
				});
		},

		runStep: function(id) {
			var index = OCA.Health.getCheckIndexById(id);

			OCA.Health.checks[index]['running'] = true;
			OCA.Health.updateState(id);

			var queryParam = '';
			if (OCA.Health.checks[index]['state']['statePercentage'] >= 1) {
				console.log('reset run');
				// TODO ask user
				queryParam = '?restart=1';
			}

			console.log('run', id);
			$.get(OC.generateUrl('/apps/serverhealth/checks/' + id + '/run' + queryParam))
				.done(function(data){
					OCA.Health.checks[index]['state'] = data;
					OCA.Health.checks[index]['lastRun'] = (new Date()).toISOString();;
					OCA.Health.updateState(id);

					if (data.statePercentage < 1) {
						OCA.Health.runStep(id);
					} else {
						OCA.Health.checks[index]['running'] = false;
						OCA.Health.updateState(id);
					}
				})
				.fail(function(){
					console.log('Failed');
					OCA.Health.checks[index]['running'] = false;
					OCA.Health.checks[index]['lastRun'] = (new Date()).toISOString();;
					OCA.Health.updateState(id);
				});
		},

		getCheckById: function(id) {
			return _.find(OCA.Health.checks, function(check) {
				return check['id'] === id;
			});
		},

		getCheckIndexById: function(id) {
			return _.findIndex(OCA.Health.checks, function(check) {
				return check['id'] === id;
			});
		}
	};

	$(document).ready(function () {
		OCA.Health.load();
	});

})(jQuery, _, OC, OCA);
