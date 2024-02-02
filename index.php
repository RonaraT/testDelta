<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Тестовое получение данных из бд</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.10/lodash.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
 
</head>
<body>
<button id="get-data">Получить данные из бд</button>
<pre id="data-revenue"></pre>
<div id="error-revenue"></div>
<script>
	$(document).ready(function(){
		$('#get-data').on('click', function(){
			$.getJSON('/getting-data.php', function(data) {
				if(data.type == 'success'){
					dataString = JSON.stringify(data.text, null, 2);
					$('#data-revenue').html(dataString);
				}else{
					$('#error-revenue').html(JSON.stringify(data.error));
				}
			});
		});
	});
</script>
</body>
</html>
