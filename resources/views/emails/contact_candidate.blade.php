<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>MZT test assignment</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div id="app">
		<h1>Hey {{ $candidateName  }}, You have been contacted by company {{ $companyName }}. They are looking for a candidate.</h1>
</div>
</body>
</html>
