<?php
class CF7_Views_Upgrade_to_Pro_Page {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ) );
	}

	function add_page() {
		add_submenu_page(
			'edit.php?post_type=cf7-views',
			__( 'Get Pro', 'textdomain' ),
			__( '<strong style="color: #FCB214;">Get Pro</strong>', 'textdomain' ),
			'manage_options',
			'cf7-views-get-pro',
			array( $this, 'upgrade_to_pro_page' )
		);
	}

	function upgrade_to_pro_page() {
		?>
		<style>
			#cf7-views-upgrade-section{
				margin: 32px;
				font-size: 1rem;
			}
			#cf7-views-upgrade-section h2{
				font-size: 1.88em;
				line-height: 2.5rem;
				margin-bottom: 1.2rem;
			}
			.cf7-views-heading-highlight {
				color: #cd631d;
				font-weight: 600;
			}
			.cf7-views-pro-benefits li {
				list-style: none!important;
				position: relative;
				padding-left: 1.2533333333rem;
				height: 30px;
			}
			.cf7-views-pro-benefits span{
				line-height: 30px;
			}
			.cf7-views-pro-benefits .dashicons-yes{
				color:green;
				font-size:32px;
			}
			.cf7-views-pro-benefits__title {
				font-weight: 600;
				padding-left: 10px;
			}
			.cf7-views-pro-benefits__description:before {
				content: "– ";
			}
			.cf7-views-upsell{
				display: inline-flex;
				align-items: center;
				justify-content: center;
				box-sizing: border-box;
				min-height: 48px;
				padding: 8px 1em;
				font-size: 16px;
				line-height: 1.5;
				font-family: Arial,sans-serif;
				color: #ffffff;
				border-radius: 4px;
				box-shadow: inset 0 -4px 0 rgba(0,0,0,.2);
				filter: drop-shadow(0 2px 4px rgba(0,0,0,.2));
				text-decoration: none;
				background-color: #FF9800 ;
			}


.view-pricing {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

}

.view-pricing .pricing-heading {
  font-size: 3em;
  margin-bottom: 20px;
  color: #333;
}

.view-pricing .pricing-table {
    display: flex;
    justify-content: center;
    /* align-items: center; */
    flex-wrap: wrap;
    gap: 20px;
    padding-top: 60px;
}

.view-pricing .pricing-plan {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  text-align: center;
  width: 250px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s;
}

.view-pricing .pricing-plan:hover {
  transform: translateY(-10px);
}

.view-pricing .plan-title {
  font-size: 1.8em;
  margin-bottom: 10px;
  color: #333;
}

.view-pricing .plan-price {
  font-size: 2em;
  margin: 10px 0;
  color: #007BFF;
}

.view-pricing .plan-features {
  list-style: none;
  padding: 0;
  margin: 20px 0;
}

.view-pricing .plan-features li {
 margin: 10px 0;
	font-size: 1.1em;
	text-align: left;
	border-bottom: 1px solid #f2f2f2;
}

.view-pricing .plan-button {
  background-color: #007BFF;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
  transition: background-color 0.3s;
}

.view-pricing .plan-button:hover {
  background-color: #0056b3;
}

		</style>

		<div id="cf7-views-upgrade-section">
			<h2><span class="cf7-views-heading-highlight">CF7 Views Pro</span>, take your Views to next level!</h2>
			<ul class="cf7-views-pro-benefits ">
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">Edit Entries</span>
						<span class="cf7-views-pro-benefits__description">edit entries from site frotend within your view.</span>
					</li>
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">Filter & Sorting</span>
						<span class="cf7-views-pro-benefits__description">filter & sort view by form field values.</span>
					</li>
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">Approved Submissions</span>
						<span class="cf7-views-pro-benefits__description">display only those submissions which are approved by admin.</span>
					</li>
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">List & DataTable View</span>
						<span class="cf7-views-pro-benefits__description">display entries in List View or DataTable View.</span>
					</li>
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">Search</span>
						<span class="cf7-views-pro-benefits__description">allow users to search data in view.</span>
					</li>
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">Single Page View</span>
						<span class="cf7-views-pro-benefits__description">display entry details on single page.</span>
					</li>
					<li class="cf7-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="cf7-views-pro-benefits__title">Premium Support</span>
						<span class="cf7-views-pro-benefits__description">access to premium support.</span>
					</li>
				</ul>
				<a class="cf7-views-upsell" target="_blank" href="https://cf7views.com/pricing/?utm_source=wordpress-plugin-dashboard&utm_medium=cf7-views-upgrade-page&utm_campaign=cf7-views-lite-version"> Buy CF7 Views Pro</a>
		</div>
		<div class="view-pricing">
  <h1 class="pricing-heading">Choose Your Plan</h1>
	<div class="pricing-table">
		<div class="pricing-plan">
			<h2 class="plan-title">Personal</h2>
			<p class="plan-price">$59</p>
			<ul class="plan-features">
				<li>1 Site</li>
				<li>Table & List View</li>
				<li>Sorting & Filtering</li>
				<li>Search Widget</li>
				<li>Limit entries created by logged-in users</li>
			</ul>
			<a href="https://cf7views.com/checkout?addon-license=2146" target="_blank"><button class="plan-button">Buy Now</button></a>
		</div>
		<div class="pricing-plan">
			<h2 class="plan-title">Professional</h2>
			<p class="plan-price">$99</p>
			<ul class="plan-features">
				<li>5 Sites</li>
				<li>Table & List View</li>
				<li>Sorting & Filtering</li>
				<li>Search Widget</li>
				<li>Limit entries created by logged-in users</li>
				<li>Approve Entries Add-on</li>
				<li>Single Entry Add-on</li>
				<li>Calculations Add-on</li>
			</ul>
			<a href="https://cf7views.com/checkout?addon-license=2149" target="_blank"><button class="plan-button">Buy Now</button></a>
		</div>
		<div class="pricing-plan">
			<h2 class="plan-title">Developer</h2>
			<p class="plan-price">$199</p>
			<ul class="plan-features">
				<li>20 Sites</li>
				<li>Table & List View</li>
				<li>Sorting & Filtering</li>
				<li>Search Widget</li>
				<li>Limit entries created by logged-in users</li>
				<li>Approve Entries Add-on</li>
				<li>Calculations Add-on</li>
				<li>Edit Entries Add-on</li>
				<li>DataTable Add-on</li>
				<li>Single Entry Add-on</li>
				<li>Delete Entries Add-on</li>
			</ul>
			<a href="https://cf7views.com/checkout?addon-license=2150" target="_blank"><button class="plan-button">Buy Now</button></a>
		</div>

	</div>
</div>

		<?php
	}


}
new CF7_Views_Upgrade_to_Pro_Page();
