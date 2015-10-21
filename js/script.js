/**
 * ownCloud - health
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Morris Jobke <hey@morrisjobke.de>
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 */

(function ($, OC, OCA) {

	OCA.Health = {

		render: function(data) {
			var template = Handlebars.compile($('#serverhealth-checks-template').html()),
				$settingsSection = $('#app-serverhealth');

			$settingsSection.find('checks-list').remove();
			$settingsSection.append(template(data));
		},

		load: function() {
			$.get(OC.generateUrl('/apps/serverhealth/checks'))
				.done(function(data){
					OCA.Health.render(data);
				})
				.fail(function(){
					console.log('Failed');
				});
		}
	};

	$(document).ready(function () {
		OCA.Health.load();
	});

})(jQuery, OC, OCA);
