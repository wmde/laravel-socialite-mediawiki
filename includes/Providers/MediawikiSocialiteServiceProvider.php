<?php
/**
 * MIT License
 *
 * Copyright (c) 2020 Taavi Väänänen
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

namespace Taavi\LaravelSocialiteMediawiki\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Taavi\LaravelSocialiteMediawiki\Socialite\One\WikiSocialiteProvider;
use Taavi\LaravelSocialiteMediawiki\Socialite\One\WikiSocialiteServer;

class MediawikiSocialiteServiceProvider extends ServiceProvider {
	public function boot() {
		$socialite = $this->app->make( Factory::class );
		$socialite->extend(
			'mediawiki',
			function ( $app ) use ( $socialite ) {
				$config = $app['config']['services.mediawiki'];
				return new WikiSocialiteProvider(
					$this->app['request'], new WikiSocialiteServer( $config )
				);
			}
		);
	}
}
