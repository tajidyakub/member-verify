# Member Verify WordPress Plugin

**Contributor** : Tajid Yakub <tajid.yakub@gmail.com>

## What is Member Verify

Member Verify is a WordPress Plugin which does these;

* Add is_confirmed user meta in WordPress database
* Redirect user to a stand alone page after registration
* Send an email with a confirmation link to the newly registered user
* Provide a verification link for the user (/verification/verify/)
* Prevent an unconfirmed user from login to the dashboard if not yet confirm his email address with a redirection page

## Features

### Current Release v.1.0.0

* Redirect page after registration
* Generate a random token for the user
* Send email to the user which contain the verification link
* Verification page to check the verification token and confirm the user if successful

## Installation

To install manually in a WordPress installation, download a released version in ./releases folder.
The current release is ver. 1.0.0 which can be downloaded directly from this link **[Download Member Verify WordPress Plugin v. 1.0.0](https://github.com/tajidyakub/member-verify/blob/master/releases/member-verify-current.zip)**

The compressed plugin can be uploaded from WordPress Plugin's Management interface.

## Plugin's Usage

Member Verify plugin currently expected to work directly after install without administration settings (yet), changes can be done via editing the source code directly. Features for plugin's administration such as modify the email template will be added in the next release.

