<?php
final class AnchorDefaultAdapter {
	function notFound()
	{
		if (!headers_sent()) {
			header("HTTP/1.1 404 Not Found");
		}
		?>

		<html>
			<head>
				<title>404 Not Found</title>

				<link href='http://fonts.googleapis.com/css?family=Oswald&amp;v1' rel='stylesheet' type='text/css'>

				<style type="text/css">
					body {
						margin: 0;
						padding: 0;
						background: #ddd;
						color: #444;
						font-size: 20px;
						font-family: 'Oswald', Helvetica, Arial, sans-serif;
					}
					#container {
						width: 900px;
						margin: 30px auto;
					}
					.troubleshooting {
						background: #aaa;
						padding: 15px 30px 30px;
						border-radius: 10px;
						margin: 0 -30px;
					}
					h1, h2 {
						text-transform: uppercase;
					}
					h1 {
						color: #333;
						font-size: 60px;
					}
					h2 {
						color: #333;
						font-size: 30px;
					}
				</style>
			</head>
			<body>
				<div id="container">
					<h1>Anchor: 404</h1>

					<div class="troubleshooting">
						<h2>Troubleshooting</h2>

						<p>Anchor can't find a route to this URL or a valid controller method.</p>

						<ul>
							<li>Check your controller path location. See <code>::setControllerPath()</code></li>
							<li>Is your controller class authorized for execution? See <code>::authorize()</code></li>
							<li>Is your controller method a public instance method?</li>
							<li>Don't want to see this page? Set your own 404 callback. See <code>::setNotFoundCallback()</code></li>
							<li>Have you set up a route to this URL? See <code>::add()</code></li>
						</ul>
					</div>
				</div>
			</body>

		</html>

		<?php
	}
}
