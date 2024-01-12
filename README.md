# laravel-socialite-mediawiki

## This is a temporary copy of [taavi/laravel-socialite-mediawiki](https://sr.ht/~taavi/laravel-socialite-mediawiki/) created due to a sourcehut outage


This package provides a Socialite service that can be used to log in
using MediaWiki's OAuth extension.

## Installing

### Install the package from composer

```
composer require taavi/laravel-socialite-mediawiki
```

### Setup configuration

Add the following to `config/services.php`:

```php
return [
    'mediawiki' => [
        'identifier' => env('MEDIAWIKI_OAUTH_CLIENT_ID'), // oauth client id
        'secret' => env('MEDIAWIKI_OAUTH_CLIENT_SECRET'), // oauth client secret

        'callback_uri' => env('MEDIAWIKI_OAUTH_CALLBACK_URL'), // redirect url
        'base_url' => env('MEDIAWIKI_OAUTH_BASE_URL'), // base url of wiki, for example https://meta.wikimedia.org
    ],
];
```

### Set variables in `.env`
```dotenv
MEDIAWIKI_OAUTH_CLIENT_ID=
MEDIAWIKI_OAUTH_CLIENT_SECRET=
MEDIAWIKI_OAUTH_CALLBACK_URL=
MEDIAWIKI_OAUTH_BASE_URL=
```

### Use

```php
class OauthLoginController extends Controller {
	public function __construct() {
		$this->middleware( 'guest' )->only( [ 'login', 'callback' ] );
		$this->middleware( 'auth' )->only( 'logout' );
	}

	public function login() {
		return Socialite::driver( 'mediawiki' )
			->redirect();
	}

	public function callback() {
		$socialiteUser = Socialite::driver( 'mediawiki' )->user();

		$user = User::firstOrCreate( [
			'username' => $socialiteUser->name,
		] );

		Auth::login( $user, false );
		return redirect()->intended( '/' );
	}

	public function logout( Request $request ) {
		$this->guard()->logout();
		$request->session()->invalidate();
		return redirect( '/' );
	}

	private function guard() {
		return Auth::guard();
	}
}
```

## Contributing and license

Please use [git-send-email](https://git-send-email.io) to send patches to
[~taavi/inbox@lists.sr.ht](mailto:~taavi/inbox@lists.sr.ht).

This package is licensed under the MIT license. See the LICENSE file
for specifics.

