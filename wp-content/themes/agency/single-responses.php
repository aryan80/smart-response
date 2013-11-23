<?php
/**
 * Sample template for displaying single organizations posts.
 * Save this file as as single-organizations.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php
    $orgPost = get_custom_field('organization');
    $disasterPost = get_custom_field('disaster');
?>


<article id="organizations">
    <section id="org_contentWrap"></h1>
        <h2>Responding to <?php print $disasterPost['post_title']; ?></h2>
        <p id="org_mission_statement"><?php print_custom_field('org_crisis_mission_disaster'); ?></p>
        <p id="org_donate"><a href="#">Donate to <?php print $orgPost['post_title']; ?></a></p>
        <dl class="inline">
            <dt><?php the_title(); ?> Headquarters</dt>
            <dd><?php print_custom_field('hq_city'); ?>, <?php print_custom_field('hq_state'); ?>, <?php print_custom_field('hq_country'); ?></dd>
        </dl>
        <dl class="inline">
            <dt><?php the_title(); ?> Countries of Operation</dt>
            <dd>
                <?php print_custom_field('countries_of_operation:to_link'); ?>
            </dd>
       </dl>



        <div class="interface tabbed">

            <ul>
                <li><a href="#disaster">Disaster Name</a></li>
                <li><a href="#org_bkgd">Organization Background</a></li>
            </ul>


            <div id="disaster" class="tabbed_pane">
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
            <div id="org_bkgd" class="tabbed_pane">
                <a name="org_bkgd"></a>
                <?php print_custom_field('organization_name'); ?>
                <dl>
                    <dt>Organization's Tax Identification Number or other Government Identification Number</dt>
                    <dd><?php print $orgPost['org_tax_id_or_other_id_number']; ?></dd>

                    <dt>Organization Fiscal Year Ending</dt>
                    <dd><?php print $orgPost['org_fiscal_year_ending']; ?></dd>

                    <dt>Is Organization a faith based organization?</dt>
                    <dd><?php print $orgPost['org_faith_based']; ?></dd>

                    <dt>Does Organization have an anti-discrimination policy across racial, ethnic, sexual orientation, and gender discrimination for the provision of services?</dt>
                    <dd><?php print $orgPost['anti_discrim_policy_question']; ?></dd>

                    <dt>Please list Organization's memberships with other disaster preparedness, relief, recovery networks or associations.</dt>
                    <dd><?php print $orgPost['org_memberships']; ?></dd>
                    <dt>Does your organization share or re-grant funds to other relief, recovery, and/or service provider organizations?</dt>
                    <dd><?php print $orgPost['regranting_yes_no']; ?></dd>

                    <dt>Additional Comments</dt>
                    <dd><?php print $orgPost['additional_comments']; ?></dd>
                </dl>
            </div>

        </div>
        <!--/ tabbed interface -->
    </section>
    <!--/content_wrap-->
    <aside id="org_sidebar">
        <div class="module people ui-corner-all">
            <div>
                <h3>People Helping with Philippines Typhoon 2013 Relief</h3>
                <dl class="inline">
                    <dt>Staff</dt>
                    <dd>xxx</dd>
                </dl>
                <dl class="inline">
                    <dt>Volunteers</dt>
                    <dd><?php print_custom_field('volunteers'); ?></dd>
                </dl>
            </div>
        </div>
        <div class="module staffing ui-corner-all">
            <div>
                <h3>Services Provided for Philippines Typhoon 2013 Relief</h3>
                <?php print_custom_field('services:to_link'); ?>
            </div>
        </div>
        <div class="module years ui-corner-all">
            <div>
                <h3>Years Operating in Philippines</h3>
                <?php print_custom_field('years_operating'); ?>
            </div>
        </div>
        <div class="module money_raised_spent ui-corner-all">
            <div>
                <h3>Money Raised for Philippines Typhoon 2013 Relief</h3>
                <?php print_custom_field('money_raised_spent_ratio'); ?>
                <?php print_custom_field('current_annual_budget'); ?>
                <strong>How much interest (in USD) has been raised on donations to [Organization]  for [Disaster] relief?</strong> <?php print_custom_field('amount_interest_raised_org_disaster'); ?><br />
                <strong>How much (in USD) did [Organization]  raise for [Disaster] relief to-date?</strong> <?php print_custom_field('amount_raised_org_disaster'); ?><br />
                <strong>How much (in USD) did [Organization] spend and disburse for [Disaster] relief to-date?</strong> <?php print_custom_field('amount_spent_org_disaster'); ?><br />
            </div>
        </div>
        <div class="module social_media ui-corner-all">
            <div>
            <h3>Social Media</h3>
                <?php print_custom_field('twitter_handle'); ?>
            </div>
        </div>
    </aside>
    <!--/sidebar-->
</article>



<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>