# MastoPHP

MastoPHP is a small library who provide a way to talk with a Mastodon instance.
[Fork of TootoPHP](https://framagit.org/MaxKoder/TootoPHP)

## Functionality

Actually, it's possible to :
- Retrieve a user profile
- Retrieve a user's favorites
- Retrieve a user's followers
- Retrieve a user's following
- Get authenticated user's notifications
- Retrieve a user's statuses
- Post a new status, with medias and visibility

# Requirements

MastoPHP needs only PHP 5.4 or later and the cURL librairie.

# Install

To install, you need only the 'MastoPHP' folder and its 3 files. In your script, simply include the 'autoload' file :

    require 'mastophp/autoload.php';

# Register

For MastoPHP to work, you must follow these steps :

## Step 1 : Register your App

For example, see the `1-register_app.php` file.

### Object Creation

```php
$MastoPHP = new MastoPHP\MastoPHP('@aka@instance.tld');
```

You must give your instance as unique parameter, like `mastodon.social`

### Register App

```php
$app = $MastoPHP->registerApp('YourAppName', 'http://my-website.com');
```
    
Give 2 parameters to this method :
- Application Name, like `MastoPHP`
- Your website URL, like `https://www.stefofficiel.me`

To know if eveything is okay, you can do this :
```php
if ( $app === false) {
    throw new Exception('Problem during register app');
}
else {
    // Everything is good ;)
}
```

### Get Auth URL

Auth URL will be used to let your app talk to Mastodon API.
When your app is registered, do this :

```php
echo $app->getAuthUrl();
```
    
An URL will be displayed. Copy and access it in your browser.
Accept your app use Mastodon, and the page will provide you with a security token.
Copy it.

Be carefull, this token is valid only 1 time.

You have now to register your access token and authenticate.

## Step 2 : Register your token

For example, see the `2-register_token_and_authentify.php` file.

### Register App

Create your object and register your app with the same credentials like above :

```php
$MastoPHP = new MastoPHP\MastoPHP('@aka@instance.tld');
$app = $MastoPHP->registerApp('MastoPHP', 'https://www.stefofficiel.me');
```

### Register your token

Now, take your access token and put it in this request :

```php
$app->registerAccessToken('write_here_your_token_got_in_step_1');
```

Your security token is now registered.

### Authentify

You can now to authenticate with your own credentials :

```php
$app->authentify("your_email@mail.com", "Your_Password");
```

You can now use MastoPHP :)

# Usage

Create your object and register your app with the same credentials like above :

```php
$MastoPHP = new MastoPHP\MastoPHP('@aka@instance.tld');
$app = $MastoPHP->registerApp('MastoPHP', 'https://www.stefofficiel.me');
```

Now, you can use requests.

## Users

### Get Authenticated User

    $app->getUser();

This will return the authenticated user's account, as an associative array :

| Attribute                | Description |
| ------------------------ | ----------- |
| `id`                     | The ID of the account |
| `username`               | The username of the account |
| `acct`                   | Equals `username` for local users, includes `@domain` for remote ones |
| `display_name`           | The account's display name |
| `locked`                 | Boolean for when the account cannot be followed without waiting for approval first |
| `created_at`             | The time the account was created |
| `followers_count`        | The number of followers for the account |
| `following_count`        | The number of accounts the given account is following |
| `statuses_count`         | The number of statuses the account has made |
| `note`                   | Biography of user |
| `url`                    | URL of the user's profile page (can be remote) |
| `avatar`                 | URL to the avatar image |
| `avatar_static`          | URL to the avatar static image (gif) |
| `header`                 | URL to the header image |
| `header_static`          | URL to the header static image (gif) |

### Get an other user

    $app->getAccount($id);

Return account's user as an associative array (like above).
`$id` is ID's user, like `1629`

### Getting an account's followers

    $app->getFollowers($id, $params);
    
This will return all followers from an account.
`$id` : (optionnal) ID's user. If not given, authenticated user's ID will be used
`$params` : (optionnal) Associative parameters array. Parameters can be :
- `limit` : Maximum number of accounts to get (Default 40, Max 80)
- `max_id` : Get a list of followers with ID less than or equal this value
- `since_id` : Get a list of followers with ID greater than this value

Return an array of accounts, like above.

### Getting who account is following

    $app->getFollowing($id);
    
`$id` : (optionnal) ID's user. If not given, authenticated user's ID will be used
Returns all users following the user, as an array of accounts like above.

## Statuses

### Getting user's statuses

    $app->getStatuses($id, $params);
    
This will return all statuses from an account.
`$id` : (optionnal) ID's user. If not given, authenticated user's ID will be used
`$params` : (optionnal) Associative parameters array. Parameters can be :
- `only_media` : If true, only return statuses that have media attachments
- `exclude_replies` : If true, skip statuses that reply to other statuses

Return an array of statuses. Statuses are associative arrays :

| Attribute                | Description |
| ------------------------ | ----------- |
| `id`                     | The ID of the status |
| `uri`                    | A Fediverse-unique resource ID |
| `url`                    | URL to the status page (can be remote) |
| `account`                | The Account which posted the status |
| `in_reply_to_id`         | `null` or the ID of the status it replies to |
| `in_reply_to_account_id` | `null` or the ID of the account it replies to |
| `reblog`                 | `null` or the reblogged Status |
| `content`                | Body of the status; this will contain HTML (remote HTML already sanitized) |
| `created_at`             | The time the status was created |
| `reblogs_count`          | The number of reblogs for the status |
| `favourites_count`       | The number of favourites for the status |
| `reblogged`              | Whether the authenticated user has reblogged the status |
| `favourited`             | Whether the authenticated user has favourited the status |
| `sensitive`              | Whether media attachments should be hidden by default |
| `spoiler_text`           | If not empty, warning text that should be displayed before the actual content |
| `visibility`             | One of: `public`, `unlisted`, `private`, `direct` |
| `media_attachments`      | An array of Attachments |
| `mentions`               | An array of Mentions |
| `tags`                   | An array of Tags |
| `application`            | Application from which the status was posted |

### Getting user's favourites

    $app->getFavourites();

Returns an array of Statuses favourited by the authenticated user.

## Notifications

You can fetch a list of notifications for the authenticated user :

    $app->getNotifications();
    
Return an array of Notifications. Notifications are associative array like this :

| Attribute                | Description |
| ------------------------ | ----------- |
| `id`                     | The notification ID |
| `type`                   | One of: "mention", "reblog", "favourite", "follow" |
| `created_at`             | The time the notification was created |
| `account`                | The Account sending the notification to the user |
| `status`                 | The Status associated with the notification, if applicable |

## Post a new status

MastoPHP give you possibility to toot a new status from PHP :

    $app->postStatus('@maxk@mastodon.xyz This status is posted by #PHP #MastoPHP');

3 parameters are supported :

- `$content` : The text of the status
- `$visibility` : (optionnal) Toot's visibility. Either "direct", "private", "unlisted" or "public"
- `$medias` : (optional) array of media IDs to attach to the status (maximum 4)

Medias can be upload with the following method :

## Create an attachement

    $app->createAttachement('path/to/the/media.png');

Only the path to the media is needed.
Returns an Attachment that can be used when creating a status.

Attachment is an associative array :

| Attribute                | Description |
| ------------------------ | ----------- |
| `id`                     | ID of the attachment |
| `type`                   | One of: "image", "video", "gifv" |
| `url`                    | URL of the locally hosted version of the image |
| `remote_url`             | For remote images, the remote URL of the original image |
| `preview_url`            | URL of the preview image |
| `text_url`               | Shorter URL for the image, for insertion into text (only present on local images) |

To use them in a new status, specify their IDs in a array like this :

```php
// Create Attachments
$img1 = $app->createAttachement("C:\Users\Max\Pictures\MastoPHP.png");
$img2 = $app->createAttachement("C:\Users\Max\Pictures\mastodonauth.png");

// Post the new status with both medias
$app->postStatus('This is a test with #MastoPHP #PHP', 'public', [$img1['id'], $img2['id']]);
```

Enjoy !

# Important

Credentials and tokens are saved in a JSON file `MastoPHP_instance_unique_key.json`, in the 'MastoPHP' dir.
Make it writable on App's register and readable next.