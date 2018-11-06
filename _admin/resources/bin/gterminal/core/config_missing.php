<?="<?xml version='1.0' encoding='utf-8'?>\n"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<!--
	Copyright (c) 2010 Theis Mackeprang

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
	-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Type-Script" content="text/javascript" />
	<meta name="description" content="TinyShell" />
	<meta name="keywords" content="TinyShell" />
	<title>TinyShell @ <?=ucwords($_SERVER['SERVER_NAME'])?></title>
	<link rel="stylesheet" type="text/css" href="core/style.css" />
	<link rel="stylesheet" type="text/css" href="theme.css" />
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="icon" type="image/x-icon" href="favicon.ico" />
</head>
<body onload="window.setTimeout(function(){window.scrollTo(0,0);},100)">
	<div id='terminal-history'><div class='pre'>TinyShell&gt; help install<br />Welcome to TinyShell!<br />&nbsp;<br />You have not configured TinyShell yet.<br />Please complete the following steps:<br />&nbsp;<br />1. Update config-example.php with desired username and password<br />2. Rename config-example.php to config.php<br />3. Reload this page<br /><span class='cursor'>&nbsp;</span></div></div>
</body>
</html>
<?exit;?>