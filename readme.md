Kohana Vkontakte API module
===========================

A handly drop-in module that implements Vkontakte API. Requires OAuth2 token for authorization.

API documentation
-----------------

Vkontakte API documentation can be found here: [http://vkontakte.ru/developers.php?o=-17680044&p=API+Method+Description](http://vkontakte.ru/developers.php?o=-17680044&p=API+Method+Description)

Example usage:

	// Create vkontakte api instance
	$vkapi = Vkapi::instance('oauth2tokenretrievedfromvkontakte');
	
	// Get profile information
	$profiles = $vkapi->getProfiles(array('uid' => 'someuserid'));
	
	// Post to client wall
	$vkapi->wall_post(array('message' => 'Hello World', 'friends_only' => 1));
	
Licence
-------
MIT

Copyright (c) 2011 Paul Chubatyy

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.



