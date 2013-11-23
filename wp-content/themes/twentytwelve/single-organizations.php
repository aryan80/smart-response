<?php
/**
 * Sample template for displaying single organizations posts.
 * Save this file as as single-organizations.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<article id="organizations">
    <section id="org_contentWrap">
        <h1><?php the_title(); ?></h1>
        <h2>Responding to Philippines Typhoon 2013</h2>
        <p id="org_mission_statement"><?php print_custom_field('org_crisis_mission_disaster'); ?></p>
        <p id="org_donate"><a href="#">Donate to <?php the_title(); ?></a></p>
        <dl id="org_location_data">
            <dt><?php the_title(); ?> Headquarters:</dt>
            <dd><?php print_custom_field('hq_city'); ?>, <?php print_custom_field('hq_state'); ?>, <?php print_custom_field('hq_country'); ?></dd>
            <dt><?php the_title(); ?> Countries of Operation:</dt>
            <dd>
                <?php
                    $hrefs = get_custom_field('countries_of_operation:to_link_href','http://yoursite.com/default/page/');
                    foreach($hrefs as $h) {
                        printf('<a href="%s">Click Here</a><br/>', $h);
                    }
                ?>
            </dd>
        </dl>

        <div class="interface tabbed">

            <ul>
                <li><a href="#disaster">Disaster Name</a></li>
                <li><a href="#org_bkgd">Organization Background</a></li>
            </ul>


            <div data-tab="#disaster" class="tabbed_pane">
                <a name="disaster"></a>
                <strong>Please discuss [Organization]'s history of activity in [Disaster]-impacted areas: (250-word limit)</strong> <?php print_custom_field('org_history_activity_disaster_area'); ?><br />
                <strong>Is [Organization]  currently providing [Disaster]-related relief or recovery services?</strong> <?php print_custom_field('org_providing_disaster_relief'); ?><br />
                <strong>When did [Organization] first begin operating in [Disaster]-impacted areas?</strong> <?php print_custom_field('date_begin_operating_impacted_areas'); ?><br />
                <strong>When did [Organization]  begin providing [Disaster]-related relief or recovery services?</strong> <?php print_custom_field('date_begin_providing_services'); ?><br />
                <strong>When did [Organization] begin soliciting donations for its response to [Disaster]?</strong> <?php print_custom_field('date_begin_soliciting_donations'); ?><br />
                <strong>When did [Organization]  stop soliciting donations for its response to [Disaster]?</strong> <?php print_custom_field('date_end_soliciting_donations'); ?><br />
                <strong>When did [Organization]  stop providing [Disaster]-related relief or recovery services?</strong> <?php print_custom_field('date_end_providing_services'); ?><br />
                <strong>How will [Organization] spend the interest raised on donations for [Disaster] relief?</strong> <?php print_custom_field('how_will_org_spend_interest_org_disaster'); ?><br />
                <strong>What languages(s) do your [Country] [Disaster] *staff* members speak?</strong> <?php print_custom_field('languages_spoken_org_disaster_country'); ?><br />
                <strong>Is [Organization] currently soliciting donations for [Disaster] relief, response, or recovery?</strong> <?php print_custom_field('soliciting_donations_for_disaster_yes_no'); ?><br />
                <strong>If [Organization]  is currently soliciting donations, please list the URL for making [Disaster]-specific donations via [Organization]'s website:</strong> <?php print_custom_field('website_for_orgs_disaster_specific_donations'); ?><br />
                <strong>Where is [Organization] providing [Disaster] related relief services? (100 words limit)</strong> <?php print_custom_field('where_org_providing_relief'); ?><br />

            </div>
            <div data-tab="#org_bkgd" class="tabbed_pane">
                <a name="org_bkgd"></a>
                <?php print_custom_field('organization_name'); ?>

                <strong>Organization's Tax Identification Number or other Government Identification Number</strong> <?php print_custom_field('org_tax_id_or_other_id_number'); ?><br />
                <strong>Organization Fiscal Year Ending</strong> <?php print_custom_field('org_fiscal_year_ending'); ?><br />
                <strong>Is Organization a faith based organization?</strong> <?php print_custom_field('org_faith_based'); ?><br />
                <strong>Does Organization have an anti-discrimination policy across racial, ethnic, sexual orientation, and gender discrimination for the provision of services?</strong> <?php print_custom_field('anti_discrim_policy_question'); ?><br />
                <strong>Please list Organization's memberships with other disaster preparedness, relief, recovery networks or associations.</strong> <?php print_custom_field('org_memberships'); ?><br />
                <strong>Does your organization share or re-grant funds to other relief, recovery, and/or service provider organizations?</strong> <?php print_custom_field('regranting_yes_no'); ?>
                <strong>Additional Comments</strong> <?php print_custom_field('additional_comments'); ?><br />
            </div>

        </div>
        <!--/ tabbed interface -->
    </section>
    <!--/content_wrap-->
    <aside id="org_sidebar">
        <div class="module people">
            <h3>People Helping with Philippines Typhoon 2013 Relief</h3>
            <?php print_custom_field('volunteers'); ?>
        </div>
        <div class="module staffing">
            <h3>Services Provided for Philippines Typhoon 2013 Relief</h3>
            <?php print_custom_field('services'); ?>
        </div>
        <div class="module years">
            <h3>Years Operating in Philippines</h3>
            <?php print_custom_field('years_operating'); ?>
        </div>
        <div class="module money_raised_spent">
            <h3>Money Raised for Philippines Typhoon 2013 Relief</h3>
            <?php print_custom_field('money_raised_spent_ratio'); ?>
            <?php print_custom_field('current_annual_budget'); ?>
            <strong>How much interest (in USD) has been raised on donations to [Organization]  for [Disaster] relief?</strong> <?php print_custom_field('amount_interest_raised_org_disaster'); ?><br />
            <strong>How much (in USD) did [Organization]  raise for [Disaster] relief to-date?</strong> <?php print_custom_field('amount_raised_org_disaster'); ?><br />
            <strong>How much (in USD) did [Organization] spend and disburse for [Disaster] relief to-date?</strong> <?php print_custom_field('amount_spent_org_disaster'); ?><br />
        </div>
        <div class="module social_media">
            <h3>Social Media</h3>
            <?php print_custom_field('twitter_handle'); ?>
        </div>
    </aside>
    <!--/sidebar-->
</article>

<script>
  $(function() {
    $( ".tabbed" ).tabs();
  });
  </script>

<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>