<?php

// Load Slack helper functions
require_once( dirname( __FILE__ ) . '/slack_helper.php' );

// Assemble the Arguments
$slack_type = $argv[1]; // Argument One
$slack_channel = getenv('SLACK_CHANNEL');
$circle_url = getenv('CIRCLE_URL');

switch($slack_type) {
  case 'circle_start':
    $slack_agent = 'CircleCI';
    $slack_icon = 'http://live-drupalcon-github-magic.pantheonsite.io/sites/default/files/icons/circle.png';
    $slack_color = '#229922';
    $slack_message = 'Code is changing on GitHub! Kicking off a new build - ' . $circle_url . $argv[2];
    _slack_tell( $slack_message, $slack_channel, $slack_agent, $slack_icon, $slack_color);
    break;
  case 'pantheon_merge':
    $slack_agent = 'Pantheon-Merge';
    $slack_icon = 'http://live-drupalcon-github-magic.pantheonsite.io/sites/default/files/icons/pantheon.png';
    $slack_color = '#EFD01B';
    $slack_message = "Merging new code into the Pantheon `dev` environment";
    _slack_tell( $slack_message, $slack_channel, $slack_agent, $slack_icon, $slack_color);
    break;
  case 'pantheon_create':
    # If we are dealing with a BRANCH then create
    if ($argv[3]) {
      $slack_agent = 'Pantheon-Create';
      $slack_icon = 'http://live-drupalcon-github-magic.pantheonsite.io/sites/default/files/icons/pantheon.png';
      $slack_color = '#1EFD01B';
      $slack_message = "Creating Pantheon environment `". $argv[2] . "` for GitHub branch `" . $argv[3] . "`.";
      _slack_tell( $slack_message, $slack_channel, $slack_agent, $slack_icon, $slack_color);
    }
    break;
}
