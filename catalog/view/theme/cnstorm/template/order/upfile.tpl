<!DOCTYPE html>
<html>
<head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
    <script src="catalog/view/javascript/jquery2/upfile.js"></script>
</head>
<body style="margin: 0px; padding: 0px;">
	<form action="index.php?route=account/multyupload" method="post" enctype="multipart/form-data">
		<div class="add_image" style="float: left;width: 93px;height: 93px;position: relative;border: 1px #bfbfbf solid;background: #ffffff;padding: 1px;margin: 0px;margin-right: 9px;">
			<label class="up-file" for="male_1">
				<img style="width: 93px;height: 93px;" src="image/add_image.png" />
			</label>
			<input name="fileToUpload" hidden="hidden" type="file" class="male" id="male_1"	style="display: none" />
			<input type="submit" style="display: none" />
		</div>
	</form>
</body>
</html>